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

    
    public function show(Request $request)
    {
        $perPage = 40; // fixe : toujours 40 par page

        $pokemons = Pokemon::orderBy('pokedex_number')
            ->paginate($perPage)
            ->withQueryString(); // garde les paramètres éventuels dans l'URL

        return view('home', [
            'pokemons' => $pokemons,
        ]);
    }

    
    public function search(Request $request)
    {
        // 1) Valider l’entrée
        $data = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $q = trim($data['q'] ?? '');

        // 2) Construire la requête
        $query = Pokemon::query();

        if ($q !== '') {
            // Recherche insensible à la casse selon la BDD (LIKE basique)
            $query->where('name', 'LIKE', '%' . $q . '%');
        }

        // 3) Pagination fixe à 40 par page (même règle que show)
        $pokemons = $query->orderBy('pokedex_number')
            ->paginate(40)
            ->withQueryString(); // garde ?q=... pendant la pagination

        // 4) Retourner la home qui inclura 'pokemon.show'
        return view('home', [
            'pokemons' => $pokemons,
            'q' => $q, // utile si tu veux réafficher la valeur dans le champ
        ]);
    }


    public function detail($id)
    {
        return view('pokemon.detail', ['id' => $id]);
    }


}
