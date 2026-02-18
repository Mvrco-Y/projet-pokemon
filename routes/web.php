<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Toutes les routes pour la gestion de l'authentification
Auth::routes();

//Route pour retourner notre vue qui vas afficher tous nos pokemons


