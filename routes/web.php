<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController; // Pour faire fonctionner notre fonction index qui retourne notre page pokemonhome
Route::get('/register', function () {
    return view('welcome');
});

//Toutes les routes pour la gestion de l'authentification
Auth::routes();

//Route qui affiche notre page d'acceuil une fois connecté
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Route pour afficher la vue pokemons(liste des pokemons)
Route::get('/', [PokemonController::class, 'index'])->name('homepokemon');