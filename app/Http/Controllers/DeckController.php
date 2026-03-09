<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Deck;
use App\Models\Pokemon;

class DeckController extends Controller
{

    public function index()
    {
        return view('decks.index');
    }

    public function deck(Request $request)
    {
        // Nombre d’éléments par page (1 à 50)
        $perPage = (int) $request->input('per_page', 10);
        $perPage = max(1, min($perPage, 50));

        // Récupérer les decks de l'utilisateur connecté avec pagination
        $decks = auth()->user()
            ->decks()
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();

        return view('decks.index', [
            'decks' => $decks,
        ]);
    }


    public function create()
    {
        return view('decks.create');
    }

    public function store(Request $request)
    {
        // 1) Validation
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        // 2) Création du deck lié à l'utilisateur connecté
        $deck = auth()->user()->decks()->create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        // 3) Redirection avec message
        return redirect()
            ->route('decks.index')
            ->with('status', 'Deck créé avec succès.');
    }


    public function show(Deck $deck)
    {
        // Sécurité : l'utilisateur ne peut voir que ses propres decks
        abort_if($deck->user_id !== auth()->id(), Response::HTTP_FORBIDDEN);

        // Charger les pokémon du deck (avec la quantité depuis la pivot)
        $deck->load(['pokemons' => function ($q) {
            $q->select('pokemon.id', 'name', 'pokedex_number', 'type1', 'type2', 'image_path')
                ->orderBy('pokedex_number');
        }]);

        return view('decks.show', compact('deck'));
    }

    public function edit(Deck $deck)
    {
        // Sécurité
        abort_if($deck->user_id !== auth()->id(), Response::HTTP_FORBIDDEN);

        return view('decks.edit', compact('deck'));
    }



    public function destroy(Deck $deck)
    {
        // Sécurité
        abort_if($deck->user_id !== auth()->id(), Response::HTTP_FORBIDDEN);

        $deck->delete();

        return redirect()
            ->route('decks.index')
            ->with('status', 'Deck supprimé.');
    }


    public function addPokemonForm(\App\Models\Deck $deck, Request $request)
    {
        abort_if($deck->user_id !== auth()->id(), Response::HTTP_FORBIDDEN);

        // 1) Lire les inputs (sans forcer la validation compliquée pour l’instant)
        $q            = trim((string) $request->input('q', ''));
        $type         = $request->input('type');
        $generation   = $request->input('generation');
        $isLegendary  = $request->input('is_legendary');

        // 2) Construire la requête
        $query = Pokemon::query();

        if ($q !== '') {
            $query->where('name', 'LIKE', "%{$q}%");
        }

        if (!empty($type)) {
            $query->where(function ($sub) use ($type) {
                $sub->where('type1', $type)->orWhere('type2', $type);
            });
        }

        if (!empty($generation)) {
            $query->where('generation', (int) $generation);
        }

        if ($request->filled('is_legendary')) {
            $query->where('is_legendary', $isLegendary === '1');
        }

        // 3) Récupérer les options pour les filtres
        $types = Pokemon::select('type1')->whereNotNull('type1')->distinct()->pluck('type1')
            ->merge(
                Pokemon::select('type2')->whereNotNull('type2')->distinct()->pluck('type2')
            )
            ->unique()->sort()->values();

        $generations = Pokemon::select('generation')->distinct()->orderBy('generation')->pluck('generation');

        // 4) Résultats paginés
        $pokemons = $query->orderBy('pokedex_number')
            ->paginate(24)
            ->withQueryString(); // conserve q/type/generation/is_legendary

        return view('decks.pokemons.add', [
            'deck'        => $deck,
            'types'       => $types,
            'generations' => $generations,
            'pokemons'    => $pokemons,
        ]);
    }

    public function addPokemon(\Illuminate\Http\Request $request, \App\Models\Deck $deck)
    {
        // Sécurité : seul le propriétaire peut modifier son deck
        abort_if($deck->user_id !== auth()->id(), Response::HTTP_FORBIDDEN);

        // Validation basique : l'ID doit exister dans la table 'pokemon'
        $data = $request->validate([
            'pokemon_id' => ['required', 'integer', 'exists:pokemon,id'],
        ]);

        $pokemonId = (int) $data['pokemon_id'];

        // Empêcher les doublons
        $alreadyInDeck = $deck->pokemons()->where('pokemon.id', $pokemonId)->exists();
        if ($alreadyInDeck) {
            return back()->with('error', 'Ce Pokémon est déjà dans le deck.')
                ->withInput();
        }

        // Règle métier : max 5 Pokémon distincts
        $distinctCount = $deck->pokemons()->count();
        if ($distinctCount >= 5) {
            return back()->with('error', 'Limite atteinte : 5 Pokémon distincts par deck.');
        }

        // Ajout (quantity par défaut selon ta migration pivot)
        $deck->pokemons()->attach($pokemonId);

        // Redirection vers la page du deck avec message de succès
        return redirect()
            ->route('decks.show', $deck->id)
            ->with('status', 'Pokémon ajouté au deck.');
    }

    public function removePokemon(\App\Models\Deck $deck, \App\Models\Pokemon $pokemon)
    {
        // Sécurité : seul le propriétaire peut modifier son deck
        abort_if($deck->user_id !== auth()->id(), Response::HTTP_FORBIDDEN);

        // Détacher le Pokémon (si non présent, detach ne casse pas)
        $deck->pokemons()->detach($pokemon->id);

        return redirect()
            ->route('decks.show', $deck->id)
            ->with('status', 'Pokémon retiré du deck.');
    }

    public function update(Request $request, Deck $deck)
    {
        abort_if($deck->user_id !== auth()->id(), Response::HTTP_FORBIDDEN);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $deck->update($data);

        return redirect()
            ->route('decks.index')
            ->with('status', 'Deck modifié avec succès.');
    }
}
