<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PokemonController extends Controller
{
    //on retourne notre vue pokemons
    public function lstPokemon(){

        return view('pokemons');
    }
}
