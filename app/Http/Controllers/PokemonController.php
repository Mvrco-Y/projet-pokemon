<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use App\Models\Pokemon; //import du modèle

class PokemonController extends Controller
{
    //Fonction qui retournera notre vue pokemon(liste de tous les pokemons)
    public function index(Request $request)    
    {
        $perPage = (int) $request->input('per_page', 24);
        $perPage = max(1, min($perPage, 100)); // sécurité : 1..100

        $pokemons = Pokemon::orderBy('pokedex_number')
            ->paginate($perPage)
            ->withQueryString(); // garde per_page & co. quand tu cliques sur les pages

        return view('homepokemons', [
            'pokemons' => $pokemons,
        ]);
    }

    
   private function getTypes()
    {
        $type1 = Pokemon::select('type1')
            ->whereNotNull('type1')
            ->distinct()
            ->pluck('type1');

        $type2 = Pokemon::select('type2')
            ->whereNotNull('type2')
            ->distinct()
            ->pluck('type2');

        return $type1->merge($type2)
            ->unique()
            ->sort()
            ->values();
    }


    public function show(Request $request)
    {
        $pokemons = Pokemon::orderBy('pokedex_number')
            ->paginate(36)
            ->withQueryString();

        $types = $this->getTypes();

        return view('home', compact('pokemons', 'types'));
    }


    public function search(Request $request)
    {
        $data = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $q = trim($data['q'] ?? '');

        $query = Pokemon::query();

        if ($q !== '') {
            $query->where('name', 'LIKE', '%' . $q . '%');
        }

        $pokemons = $query->orderBy('pokedex_number')
            ->paginate(36)
            ->withQueryString();

        $types = $this->getTypes();

        return view('home', compact('pokemons', 'types'));
    }


    public function filter(Request $request)
    {
        $data = $request->validate([
            'type'         => ['nullable', 'string'],
            'generation'   => ['nullable', 'integer'],
            'is_legendary' => ['nullable', 'in:0,1'],
        ]);

        $query = Pokemon::query();

        if (!empty($data['type'])) {
            $query->where(function ($q) use ($data) {
                $q->where('type1', $data['type'])
                  ->orWhere('type2', $data['type']);
            });
        }

        if (!empty($data['generation'])) {
            $query->where('generation', $data['generation']);
        }

        if ($request->filled('is_legendary')) {
            $query->where('is_legendary', $data['is_legendary']);
        }

        $pokemons = $query->orderBy('pokedex_number')
            ->paginate(36)
            ->withQueryString();

        $types = $this->getTypes();

        return view('home', compact('pokemons', 'types'));
    }

  
    public function detail($id)
    {
        $pokemon = Pokemon::find($id);

        if (!$pokemon) {
            abort(404);
        }

        return view('pokemon.detail', compact('pokemon'));
    }


}
