@extends('layouts.app')

@section('content')

<h1>Créer un nouveau deck</h1>

<form action="{{ route('decks.store') }}" method="POST">
    @csrf

    <label for="name">Nom du deck :</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="description">Description (optionnel) :</label><br>
    <textarea id="description" name="description"></textarea><br><br>

    <button type="submit">Créer le deck</button>
</form>

@endsection