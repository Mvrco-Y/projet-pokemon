@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Message flash --}}
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h1 class="mb-2">Deck : {{ $deck->name }}</h1>
    @if($deck->description)
        <p class="text-muted">{{ $deck->description }}</p>
    @endif

    {{-- Actions haut de page --}}
    <div class="d-flex gap-2 mb-4">
        <a href="{{ route('decks.index') }}" class="btn btn-light">← Retour à mes decks</a>
        <a href="{{ route('decks.edit', $deck->id) }}" class="btn btn-secondary">Renommer</a>
        <form action="{{ route('decks.destroy', $deck->id) }}" method="POST" onsubmit="return confirm('Supprimer ce deck ?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Supprimer le deck</button>
        </form>
    </div>

    {{-- Bouton Ajouter un Pokémon (le formulaire viendra plus tard) --}}
    @php
        $totalInDeck = $deck->pokemons->sum('pivot.quantity'); // total cartes (si un jour on gère des quantités)
        $totalDistinct = $deck->pokemons->count();            // nombre d'entrées distinctes
        $limitReached = $totalDistinct >= 5;                  // contrainte business : max 5 pokémon distincts
    @endphp

    <div class="mb-3 d-flex align-items-center justify-content-between">
        <h2 class="h5 mb-0">Pokémon du deck ({{ $totalDistinct }}/5 distincts)</h2>

        {{-- Pour l’instant, on met juste un bouton qui pointera vers le futur formulaire --}}
        <button
            class="btn btn-primary"
            type="button"
            @if($limitReached) disabled @endif
            onclick="document.getElementById('add-pokemon-placeholder').scrollIntoView({ behavior: 'smooth' });"
            title="{{ $limitReached ? 'Limite: 5 Pokémon déjà atteinte' : 'Ajouter un Pokémon' }}"
        >
            Ajouter un Pokémon
        </button>
    </div>

    @if($deck->pokemons->count() === 0)
        <p class="text-muted">Aucun Pokémon pour l’instant. Clique sur “Ajouter un Pokémon”.</p>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Types</th>
                        <th class="text-end" style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deck->pokemons as $p)
                        <tr>
                            <td>{{ $p->pokedex_number }}</td>
                            <td>
                                {{-- Lien vers la fiche détail du pokémon --}}
                                <a href="{{ route('pokemons.detail', $p->id) }}">
                                    {{ $p->name }}
                                </a>
                            </td>
                            <td>{{ $p->type1 }}{{ $p->type2 ? ' / '.$p->type2 : '' }}</td>
                            <td class="text-end">
                                {{-- Supprimer ce Pokémon du deck --}}
                                <form
                                    action="{{ route('decks.pokemons.destroy', [$deck->id, $p->id]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Retirer {{ $p->name }} du deck ?');"
                                    class="d-inline-block"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        Retirer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total distincts :</th>
                        <th class="text-end">{{ $totalDistinct }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif

    {{-- Placeholder du futur formulaire d’ajout --}}
    <div id="add-pokemon-placeholder" class="mt-5">
        <div class="alert alert-info mb-0">
            Le formulaire d’ajout de Pokémon sera ajouté ici à l’étape suivante.
        </div>
    </div>
</div>
@endsection