<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController; // Pour faire fonctionner notre fonction index qui retourne notre page pokemonhome
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route pour afficher la vue pokemons(liste des pokemons)
Route::get('/pokemons', [PokemonController::class, 'index'])->name('homepokemon');