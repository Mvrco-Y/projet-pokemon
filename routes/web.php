<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController; // Pour faire fonctionner notre fonction index qui retourne notre page pokemonhome
use App\Http\Controllers\DeckController; // Pour faire fonctionner notre fonction index qui retourne notre page decks.index
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


Route::get('/decks', [DeckController::class, 'index'])
->middleware('auth')
->name('decks.index');

Route::get('/decks', [DeckController::class, 'deck'])
->middleware('auth')
->name('decks.index');

Route::get('/decks/create', [DeckController::class, 'create'])
    ->middleware('auth')
    ->name('decks.create');


Route::post('/decks', [DeckController::class, 'store'])
    ->middleware('auth')
    ->name('decks.store');


// Afficher un deck (pokémon à l’intérieur)
Route::get('/decks/{deck}', [DeckController::class, 'show'])
    ->middleware('auth')
    ->name('decks.show');

// Formulaire de modification (renommer)
Route::get('/decks/{deck}/edit', [DeckController::class, 'edit'])
    ->middleware('auth')
    ->name('decks.edit');


// Enregistrer la modification (renommer)
Route::put('/decks/{deck}', [DeckController::class, 'update'])
    ->middleware('auth')
    ->name('decks.update');

// Supprimer un deck
Route::delete('/decks/{deck}', [DeckController::class, 'destroy'])
    ->middleware('auth')
    ->name('decks.destroy');
