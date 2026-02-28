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



    public function detail($id)
    {
        return view('pokemon.detail', ['id' => $id]);
    }


}
