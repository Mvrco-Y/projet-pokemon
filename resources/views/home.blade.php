@extends('layouts.app')

@section('content')
<div class="container py-4">

    @if (session('status'))
        <div class="alert" style="background:#1a3a1a; border:1px solid #78C850; color:#78C850; border-radius:8px;">
            {{ session('status') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="font-family: 'Press Start 2P', cursive; color: #FFD700; font-size: 1rem; text-shadow: 2px 2px #cc0000; margin: 0;">
            Pokédex
        </h1>
        <a href="{{ route('decks.index') }}" class="btn pokemon-decks-btn">
            🗂️ Mes Decks
        </a>
    </div>

    <section class="mb-4">
        @include('pokemon.search')
    </section>

    <section class="mb-4">
        @include('pokemon.filter')
    </section>

    <section>
        @include('pokemon.show')
    </section>

</div>
@endsection