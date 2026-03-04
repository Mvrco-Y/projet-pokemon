<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deck; 

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
        abort_if($deck->user_id !== auth()->id(), 403);

        // Charger les pokémon du deck (avec la quantité depuis la pivot)
        $deck->load(['pokemons' => function ($q) {
            $q->select('pokemon.id', 'name', 'pokedex_number', 'type1', 'type2')
            ->orderBy('pokedex_number');
        }]);

        return view('decks.show', compact('deck'));
    }

    public function edit(Deck $deck)
    {
        // Sécurité
        abort_if($deck->user_id !== auth()->id(), 403);

        return view('decks.edit', compact('deck'));
    }


    public function update(Request $request, Deck $deck)
    {
        // Sécurité
        abort_if($deck->user_id !== auth()->id(), 403);

        // Validation simple
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $deck->update($data);

        return redirect()
            ->route('decks.index')
            ->with('status', 'Deck modifié avec succès.');
    }


    public function destroy(Deck $deck)
    {
        // Sécurité
        abort_if($deck->user_id !== auth()->id(), 403);

        $deck->delete();

        return redirect()
            ->route('decks.index')
            ->with('status', 'Deck supprimé.');
    }


}
