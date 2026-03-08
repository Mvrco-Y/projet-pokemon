@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="font-family: 'Press Start 2P', cursive; color: #FFD700; font-size: 0.85rem; text-shadow: 2px 2px #cc0000;">
            Ajouter un Pokémon
        </h1>
        <a href="{{ route('decks.show', $deck->id) }}" class="btn pokemon-cancel-btn px-3 py-2">← Retour</a>
    </div>

    {{-- Filtres --}}
    <div class="pokemon-filter-card p-3 mb-4">
        <form method="GET" action="{{ route('decks.pokemons.add', $deck->id) }}">
            <div class="row g-3 align-items-end">

                <div class="col-12 col-md-4">
                    <label class="form-label pokemon-filter-label">Recherche</label>
                    <div class="input-group pokemon-search-group">
                        <span class="input-group-text pokemon-search-icon">🔍</span>
                        <input type="text" name="q" class="form-control pokemon-search-input"
                               placeholder="ex: Pikachu" value="{{ request('q') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label pokemon-filter-label">Type</label>
                    <select name="type" class="form-select pokemon-select">
                        <option value="">— Tous —</option>
                        @isset($types)
                            @foreach($types as $t)
                                <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label pokemon-filter-label">Génération</label>
                    <select name="generation" class="form-select pokemon-select">
                        <option value="">— Toutes —</option>
                        @isset($generations)
                            @foreach($generations as $g)
                                <option value="{{ $g }}" {{ request('generation') == $g ? 'selected' : '' }}>Gen {{ $g }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label pokemon-filter-label">Légendaire</label>
                    <select name="is_legendary" class="form-select pokemon-select">
                        <option value="">— Tous —</option>
                        <option value="1" {{ request('is_legendary') === '1' ? 'selected' : '' }}>Oui</option>
                        <option value="0" {{ request('is_legendary') === '0' ? 'selected' : '' }}>Non</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <button class="btn pokemon-search-btn w-100 py-2" type="submit">OK</button>
                </div>

            </div>
        </form>
    </div>

    {{-- Grille Pokémon --}}
    @if(isset($pokemons) && $pokemons->count() > 0)
        <div class="row g-3">
            @foreach($pokemons as $p)
                @php
                    $limitReached  = $deck->pokemons->count() >= 5;
                    $alreadyInDeck = $deck->pokemons->pluck('id')->contains($p->id);
                @endphp
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="add-poke-card {{ $alreadyInDeck ? 'already-in' : '' }} {{ $limitReached && !$alreadyInDeck ? 'limit-reached' : '' }}">

                        {{-- Overlay hover : Ajouter --}}
                        @if(!$alreadyInDeck && !$limitReached)
                            <form action="{{ route('decks.pokemons.store', $deck->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="pokemon_id" value="{{ $p->id }}">
                                <button type="submit" class="add-poke-overlay">
                                    ➕ Ajouter
                                </button>
                            </form>
                        @elseif($alreadyInDeck)
                            <div class="add-poke-overlay already-overlay">✅ Dans le deck</div>
                        @else
                            <div class="add-poke-overlay limit-overlay">🚫 Limite</div>
                        @endif

                        {{-- Bouton détail --}}
                        <a href="{{ route('pokemon.detail', $p->id) }}" class="add-poke-detail" target="_blank" title="Voir la fiche">👁</a>

                        <img src="{{ asset($p->image_path) }}" alt="{{ $p->name }}" class="add-poke-img">
                        <p class="add-poke-number">#{{ $p->pokedex_number }}</p>
                        <p class="add-poke-name">{{ $p->name }}</p>
                        <div>
                            <span class="badge type-badge type-{{ strtolower($p->type1) }}">{{ $p->type1 }}</span>
                            @if($p->type2)
                                <span class="badge type-badge type-{{ strtolower($p->type2) }}">{{ $p->type2 }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $pokemons->links() }}</div>

    @else
        <div class="deck-empty">
            <p>Aucun résultat pour ces critères.</p>
        </div>
    @endif

</div>
@endsection