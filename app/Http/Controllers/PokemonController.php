<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use App\Models\Pokemon; //import du modèle

class PokemonController extends Controller
{
    //Fonction qui retournera notre vue pokemon(liste de tous les pokemons)
    public function index(){
        // $pokemons = Pokemon::all();
        $pokemons = Pokemon::orderBy('id')->take(50)->get();
        return view('homepokemons', ['pokemons'=>$pokemons]);
    }
}
