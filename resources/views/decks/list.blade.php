@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Message flash succès --}}
    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    {{-- Bouton de création --}}
    <a href="{{ route('decks.create') }}" class="btn btn-primary">
        Créer un nouveau deck
    </a>

    <br><br>

    @php
        // ID du deck actuellement en mode édition (via ?edit=ID dans l'URL)
        $editingId = (int) request('edit');
    @endphp

    @if($decks->count() === 0)
        <p>Aucun deck pour le moment.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nom du deck</th>
                    <th>Total Pokémon</th>
                    <th style="width: 260px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($decks as $deck)
                    <tr>
                        {{-- Colonne: Nom du deck (lecture / édition inline) --}}
                        <td>
                            @if($editingId === $deck->id)
                                {{-- MODE ÉDITION INLINE --}}
                                <form action="{{ route('decks.update', $deck->id) }}"
                                      method="POST"
                                      class="d-flex gap-2 align-items-center">
                                    @csrf
                                    @method('PUT')

                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control form-control-sm"
                                        value="{{ old('name', $deck->name) }}"
                                        maxlength="100"
                                        required
                                        style="max-width: 260px;"
                                    />

                                    {{-- On ne modifie pas la description ici : on la conserve --}}
                                    <input type="hidden" name="description" value="{{ $deck->description }}">

                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Enregistrer
                                    </button>

                                    {{-- Annuler = revenir sans le paramètre ?edit --}}
                                    @php
                                        $backQuery = request()->except('edit');
                                    @endphp
                                    <a href="{{ route('decks.index', $backQuery) }}" class="btn btn-sm btn-light">
                                        Annuler
                                    </a>
                                </form>

                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            @else
                                {{-- MODE LECTURE --}}
                                <a href="{{ route('decks.show', $deck->id) }}">
                                    {{ $deck->name }}
                                </a>
                            @endif
                        </td>

                        {{-- Colonne: Total de Pokémon (quantités additionnées) --}}
                        <td>
                            {{ $deck->pokemons->sum('pivot.quantity') }}
                        </td>

                        {{-- Colonne: Actions --}}
                        <td>
                            @if($editingId === $deck->id)
                                {{-- Rien ici en mode édition : actions gérées dans la cellule Nom --}}
                                <span class="text-muted">Édition en cours…</span>
                            @else
                                @php
                                    // On garde les query params existants et on ajoute edit={id}
                                    $editQuery = array_merge(request()->query(), ['edit' => $deck->id]);
                                @endphp

                                {{-- Passer en mode édition inline --}}
                                <a href="{{ route('decks.index', $editQuery) }}"
                                   class="btn btn-sm btn-secondary">
                                    Modifier
                                </a>

                                {{-- Lien voir le deck (facultatif) --}}
                                <a href="{{ route('decks.show', $deck->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Voir
                                </a>

                                {{-- Supprimer --}}
                                <form action="{{ route('decks.destroy', $deck->id) }}"
                                      method="POST"
                                      style="display:inline-block;"
                                      onsubmit="return confirm('Supprimer ce deck ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Supprimer
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination (si ->paginate() est utilisé dans le contrôleur) --}}
        @if(method_exists($decks, 'hasPages') && $decks->hasPages())
            {{ $decks->links() }}
        @endif
    @endif
</div>
@endsection