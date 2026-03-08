@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="font-family: 'Press Start 2P', cursive; color: #FFD700; font-size: 1rem; text-shadow: 2px 2px #cc0000;">
            Mes Decks
        </h1>
        <a href="{{ route('decks.create') }}" class="btn pokemon-decks-btn">
            ➕ Nouveau Deck
        </a>
    </div>

    @php $editingId = (int) request('edit'); @endphp

    @if($decks->count() === 0)
        <p style="color:#aaa;">Aucun deck pour le moment.</p>
    @else
        <div class="row g-4">
            @foreach($decks as $deck)
                <div class="col-12 col-md-6 col-lg-4">

                    @if($editingId === $deck->id)
                        {{-- MODE ÉDITION --}}
                        <div class="deck-card p-4">
                            <form action="{{ route('decks.update', $deck->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="description" value="{{ $deck->description }}">
                                <input type="text" name="name"
                                    class="form-control pokemon-search-input mb-3"
                                    value="{{ old('name', $deck->name) }}"
                                    maxlength="100" required>
                                @error('name')
                                    <div style="color:#ff5959; font-size:0.8rem;" class="mb-2">{{ $message }}</div>
                                @enderror
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn pokemon-search-btn px-3 py-2">
                                        Enregistrer
                                    </button>
                                    @php $backQuery = request()->except('edit'); @endphp
                                    <a href="{{ route('decks.index', $backQuery) }}" class="btn pokemon-cancel-btn px-3 py-2">
                                        Annuler
                                    </a>
                                </div>
                            </form>
                        </div>

                    @else
                        {{-- MODE LECTURE --}}
                        <a href="{{ route('decks.show', $deck->id) }}" class="deck-card-link">
                            <div class="deck-card p-4 position-relative">

                                {{-- Badge nombre de Pokémon --}}
                                <span class="deck-pokemon-badge">
                                    {{ $deck->pokemons->sum('pivot.quantity') }} Pokémon
                                </span>

                                {{-- Nom du deck --}}
                                <h3 class="deck-name mb-3">{{ $deck->name }}</h3>

                                {{-- 3 premiers Pokémon en miniature --}}
                                <div class="deck-previews mb-3">
                                    @forelse($deck->pokemons->take(5) as $p)
                                        <img src="{{ asset($p->image_path) }}" alt="{{ $p->name }}" class="deck-preview-img">
                                    @empty
                                        <span style="color:#555; font-size:0.8rem;">Aucun Pokémon</span>
                                    @endforelse
                                </div>

                                {{-- Barre de progression --}}
                                @php
                                    $total = $deck->pokemons->sum('pivot.quantity');
                                    $max = 5;
                                    $percent = min(($total / $max) * 100, 100);
                                @endphp
                                <div class="mb-1 d-flex justify-content-between" style="font-size:0.75rem; color:#aaa;">
                                    <span>Progression</span>
                                    <span style="color:#FFD700;">{{ $total }} / {{ $max }}</span>
                                </div>
                                <div class="pokemon-stat-bar-bg mb-3">
                                    <div class="pokemon-stat-bar" style="width: {{ $percent }}%; background: linear-gradient(90deg, #cc0000, #FFD700);"></div>
                                </div>

                                {{-- Actions --}}
                                <div class="deck-actions" onclick="event.stopPropagation()">
                                    @php $editQuery = array_merge(request()->query(), ['edit' => $deck->id]); @endphp
                                    <a href="{{ route('decks.index', $editQuery) }}" class="btn pokemon-search-btn btn-sm px-3">
                                        ✏️ Modifier
                                    </a>
                                    <form action="{{ route('decks.destroy', $deck->id) }}" method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('Supprimer ce deck ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn pokemon-delete-btn btn-sm px-3">
                                            🗑️ Supprimer
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </a>
                    @endif

                </div>
            @endforeach
        </div>

        @if(method_exists($decks, 'hasPages') && $decks->hasPages())
            <div class="mt-4">{{ $decks->links() }}</div>
        @endif
    @endif

</div>
@endsection