@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Ajouter un Pokémon au deck : {{ $deck->name }}</h1>

   <a href="{{ route('decks.show', $deck->id) }}" class="btn btn-light">← Retour au deck</a>

    {{-- Formulaire de recherche / filtres --}}
    <form method="GET" action="{{ route('decks.pokemons.add', $deck->id) }}" class="row g-3 mb-4">

        {{-- Recherche par nom --}}
        <div class="col-md-4">
            <label for="q" class="form-label">Recherche (nom)</label>
            <input type="text" id="q" name="q" class="form-control"
                   placeholder="ex: Pikachu"
                   value="{{ request('q') }}">
        </div>

        {{-- Filtre type --}}
        <div class="col-md-3">
            <label for="type" class="form-label">Type</label>
            <select id="type" name="type" class="form-select">
                <option value="">— Tous —</option>
                @isset($types)
                    @foreach($types as $t)
                        <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endforeach
                @endisset
            </select>
        </div>

        {{-- Filtre génération --}}
        <div class="col-md-3">
            <label for="generation" class="form-label">Génération</label>
            <select id="generation" name="generation" class="form-select">
                <option value="">— Toutes —</option>
                @isset($generations)
                    @foreach($generations as $g)
                        <option value="{{ $g }}" {{ request('generation') == $g ? 'selected' : '' }}>
                            {{ $g }}
                        </option>
                    @endforeach
                @endisset
            </select>
        </div>

        {{-- Filtre légendaire --}}
        <div class="col-md-2">
            <label for="is_legendary" class="form-label">Légendaire</label>
            <select id="is_legendary" name="is_legendary" class="form-select">
                <option value="">— Indifférent —</option>
                <option value="1" {{ request('is_legendary') === '1' ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ request('is_legendary') === '0' ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <div class="col-12">
            <button class="btn btn-primary" type="submit">Rechercher</button>
        </div>
    </form>

    {{-- Résultats --}}
    <div class="card">
        <div class="card-body">

            @if(isset($pokemons) && $pokemons->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th style="width:80px;">#</th>
                                <th>Nom</th>
                                <th>Types</th>
                                <th style="width: 160px;" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pokemons as $p)
                                <tr>
                                    <td>{{ $p->pokedex_number }}</td>
                                    <td>
                                        <a href="{{ route('pokemon.detail', $p->id) }}">
                                            {{ $p->name }}
                                        </a>
                                    </td>
                                    <td>{{ $p->type1 }}{{ $p->type2 ? ' / '.$p->type2 : '' }}</td>

                                    {{-- ICI: la cellule Actions, dans la boucle, donc 1 ligne = 1 bouton --}}
                                    <td class="text-end">
                                        @php
                                            $limitReached = $deck->pokemons->count() >= 5;
                                            $alreadyInDeck = $deck->pokemons->pluck('id')->contains($p->id);
                                        @endphp

                                        @if($alreadyInDeck)
                                            <button class="btn btn-sm btn-secondary" disabled>Déjà dans le deck</button>
                                        @elseif($limitReached)
                                            <button class="btn btn-sm btn-secondary" disabled>Limite 5 atteinte</button>
                                        @else
                                            <form action="{{ route('decks.pokemons.store', $deck->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="pokemon_id" value="{{ $p->id }}">
                                                <button type="submit" class="btn btn-sm btn-primary">Ajouter</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $pokemons->links() }}
                </div>
            @else
                <p class="text-muted mb-0">Aucun résultat pour ces critères.</p>
            @endif

        </div>
    </div>

</div>
@endsection