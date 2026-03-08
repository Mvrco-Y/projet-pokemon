@extends('layouts.app')

@section('content')
<div class="container py-4">

    @isset($pokemon)
    <div class="row g-4">

        {{-- Colonne gauche : image + infos de base --}}
        <div class="col-md-4">
            <div class="pokemon-detail-card text-center p-4">

                @if($pokemon->is_legendary)
                    <div class="mb-2">
                        <span class="badge" style="background: linear-gradient(90deg, #FFD700, #ffb300); color:#000; font-size:0.7rem; padding: 6px 12px;">
                            ⭐ Légendaire
                        </span>
                    </div>
                @endif

                @if($pokemon->image_path)
                    <img src="{{ asset($pokemon->image_path) }}"
                         alt="{{ $pokemon->name }}"
                         class="pokemon-detail-img">
                @endif

                <p class="pokemon-detail-number">#{{ $pokemon->pokedex_number ?? $pokemon->id }}</p>
                <h1 class="pokemon-detail-name">{{ $pokemon->name }}</h1>

                <div class="mb-2">
                    <span class="badge type-badge type-{{ strtolower($pokemon->type1) }}">{{ $pokemon->type1 }}</span>
                    @if($pokemon->type2)
                        <span class="badge type-badge type-{{ strtolower($pokemon->type2) }}">{{ $pokemon->type2 }}</span>
                    @endif
                </div>

                <p style="color:#aaa; font-size:0.85rem;">Génération {{ $pokemon->generation }}</p>
            </div>
        </div>

        {{-- Colonne droite : stats --}}
        <div class="col-md-8">
            <div class="pokemon-detail-card p-4 h-100">
                <h2 style="font-family: 'Press Start 2P', cursive; color:#FFD700; font-size:0.75rem; margin-bottom: 1.5rem;">
                    📊 Statistiques
                </h2>

                @php
                    $stats = [
                        'HP'          => $pokemon->hp,
                        'Attaque'     => $pokemon->attack,
                        'Défense'     => $pokemon->defense,
                        'Sp. Attaque' => $pokemon->sp_attack,
                        'Sp. Défense' => $pokemon->sp_defense,
                        'Vitesse'     => $pokemon->speed,
                    ];
                    $colors = [
                        'HP'          => '#ff5959',
                        'Attaque'     => '#F08030',
                        'Défense'     => '#6890F0',
                        'Sp. Attaque' => '#F85888',
                        'Sp. Défense' => '#78C850',
                        'Vitesse'     => '#FFD700',
                    ];
                @endphp

                @foreach($stats as $label => $value)
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="pokemon-stat-label">{{ $label }}</span>
                        <span class="pokemon-stat-value">{{ $value }}</span>
                    </div>
                    <div class="pokemon-stat-bar-bg">
                        <div class="pokemon-stat-bar"
                             style="width: {{ min(($value / 255) * 100, 100) }}%; background: {{ $colors[$label] }};"></div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>

    </div>

    <div class="mt-4 d-flex gap-3">
        <a href="{{ url()->previous() }}" class="btn pokemon-search-btn px-4 py-2">
            ← Retour
        </a>
        <a href="{{ route('pokemon.show') }}" class="btn pokemon-decks-btn px-4 py-2">
            📋 Voir la liste
        </a>
    </div>

    @else
        <p style="color:#aaa;">Pokémon introuvable.</p>
    @endisset

</div>
@endsection