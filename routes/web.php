<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController; // Pour faire fonctionner notre fonction index qui retourne notre page pokemonhome
Route::get('/register', function () {
    return view('welcome');
});

//Toutes les routes pour la gestion de l'authentification
Auth::routes();

//Route pour afficher la vue pokemons(liste des pokemons)
Route::get('/', [PokemonController::class, 'index'])->name('homepokemon');

//Route qui affiche notre page d'acceuil une fois connecté
Route::get('/home', [PokemonController::class, 'show'])->name('pokemon.show');

Route::get('/pokemons', [PokemonController::class, 'show'])->name('pokemon.show');    // liste (40/page)
Route::get('/pokemons/search', [PokemonController::class, 'search'])->name('pokemon.search');
Route::get('/pokemons/filter', [PokemonController::class, 'filter'])->name('pokemon.filter');



Route::get('/pokemon/{id}', [PokemonController::class, 'detail'])->whereNumber('id')
->name('pokemon.detail'); 
