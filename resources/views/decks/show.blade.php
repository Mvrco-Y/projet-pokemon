@extends('layouts.app')

@section('content')
<div class="container py-4">

    @if(session('status'))
        <div class="alert" style="background:#1a3a1a; border:1px solid #78C850; color:#78C850; border-radius:8px;">
            {{ session('status') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="deck-show-header mb-4">
        <div>
            <h1 class="deck-show-title">{{ $deck->name }}</h1>
            @if($deck->description)
                <p class="deck-show-desc">{{ $deck->description }}</p>
            @endif
        </div>
        <div class="deck-show-actions">
            <a href="{{ route('decks.index') }}" class="btn pokemon-cancel-btn px-3 py-2">← Retour</a>
            <form action="{{ route('decks.destroy', $deck->id) }}" method="POST"
                  onsubmit="return confirm('Supprimer ce deck ?');" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button class="btn pokemon-delete-btn px-3 py-2">🗑️ Supprimer</button>
            </form>
        </div>
    </div>

    {{-- Barre de progression --}}
    @php
        $totalDistinct = $deck->pokemons->count();
        $limitReached  = $totalDistinct >= 5;
        $percent       = ($totalDistinct / 5) * 100;
    @endphp

    <div class="deck-progress-section mb-4">
        <div class="d-flex justify-content-between mb-1">
            <span class="deck-progress-label">Pokémon dans le deck</span>
            <span class="deck-progress-count">{{ $totalDistinct }} / 5</span>
        </div>
        <div class="pokemon-stat-bar-bg">
            <div class="pokemon-stat-bar"
                 style="width: {{ $percent }}%; background: linear-gradient(90deg, #cc0000, #FFD700);"></div>
        </div>
    </div>

    {{-- Bouton ajouter --}}
    <div class="mb-4">
        @if($limitReached)
            <button class="btn pokemon-decks-btn disabled" disabled>
                🚫 Limite atteinte (5/5)
            </button>
        @else
            <a href="{{ route('decks.pokemons.add', $deck->id) }}" class="btn pokemon-decks-btn">
                ➕ Ajouter un Pokémon
            </a>
        @endif
    </div>

    {{-- Grille Pokémon --}}
    @if($deck->pokemons->count() === 0)
        <div class="deck-empty">
            <p>Aucun Pokémon dans ce deck.</p>
            <p style="font-size:0.75rem; color:#555;">Commence par ajouter un Pokémon !</p>
        </div>
    @else
        <div class="row g-4 justify-content-center">
    @foreach($deck->pokemons as $index => $p)
        <div class="{{ $index === 0 ? 'col-12 col-md-8' : 'col-12 col-md-6' }}">
                    <div class="deck-poke-card">

                        {{-- Bouton retirer --}}
                        <form action="{{ route('decks.pokemons.destroy', [$deck->id, $p->id]) }}"
                              method="POST"
                              onsubmit="return confirm('Retirer {{ $p->name }} du deck ?');"
                              class="deck-remove-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="deck-remove-btn" title="Retirer">✕</button>
                        </form>

                        {{-- Lien vers la fiche --}}
                        <a href="{{ route('pokemon.detail', $p->id) }}" class="deck-poke-link">
                            <div class="deck-poke-overlay">
                                <span>Voir la fiche</span>
                            </div>
                            <img src="{{ asset($p->image_path) }}" alt="{{ $p->name }}" class="deck-poke-img">
                            <p class="deck-poke-number">#{{ $p->pokedex_number }}</p>
                            <p class="deck-poke-name">{{ $p->name }}</p>
                            <div>
                                <span class="badge type-badge type-{{ strtolower($p->type1) }}">{{ $p->type1 }}</span>
                                @if($p->type2)
                                    <span class="badge type-badge type-{{ strtolower($p->type2) }}">{{ $p->type2 }}</span>
                                @endif
                            </div>
                        </a>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection