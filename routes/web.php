<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController; 
use App\Http\Controllers\DeckController; 

Route::get('/register', function () {
    return view('welcome');
});

//Toutes les routes pour la gestion de l'authentification
Auth::routes();

//Route pour afficher la vue pokemons(liste des pokemons)
Route::get('/', [PokemonController::class, 'index'])->name('homepokemon');

//Route qui affiche notre page d'acceuil une fois connecté
Route::get('/home', [PokemonController::class, 'show'])
->middleware('auth')
->name('pokemon.show');

Route::get('/pokemons', [PokemonController::class, 'show'])
->middleware('auth')
->name('pokemon.show');

Route::get('/pokemons/search', [PokemonController::class, 'search'])
->middleware('auth')
->name('pokemon.search');

Route::get('/pokemons/filter', [PokemonController::class, 'filter'])
->middleware('auth')
->name('pokemon.filter');


Route::get('/pokemon/{id}', [PokemonController::class, 'detail'])->whereNumber('id')
->middleware('auth')
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


Route::put('/decks/{deck}', [DeckController::class, 'update'])
    ->middleware('auth')
    ->name('decks.update');



// Enregistrer la modification (renommer)
Route::put('/decks/{deck}', [DeckController::class, 'update'])
    ->middleware('auth')
    ->name('decks.update');

// Supprimer un deck
Route::delete('/decks/{deck}', [DeckController::class, 'destroy'])
    ->middleware('auth')
    ->name('decks.destroy');

Route::get('/decks/{deck}/pokemons/add', [DeckController::class, 'addPokemonForm'])
    ->middleware('auth')
    ->name('decks.pokemons.add');

    
Route::post('/decks/{deck}/pokemons', [DeckController::class, 'addPokemon'])
    ->middleware('auth')
    ->name('decks.pokemons.store');

Route::delete('/decks/{deck}/pokemons/{pokemon}', [\App\Http\Controllers\DeckController::class, 'removePokemon'])
    ->middleware('auth')
    ->name('decks.pokemons.destroy');