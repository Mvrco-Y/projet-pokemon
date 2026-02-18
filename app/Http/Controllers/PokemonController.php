<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PokemonController extends Controller
{
    //Fonction qui retournera notre vue pokemon(liste de tous les pokemons)
    public function index(){
        return view('homepokemons');
    }
}
