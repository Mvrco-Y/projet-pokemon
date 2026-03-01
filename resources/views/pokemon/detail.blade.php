@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3">Fiche du Pokémon</h1>

    @isset($pokemon)
        <div class="card">
            <div class="card-header">
                {{ $pokemon->name }}

                @if($pokemon->is_legendary)
                    <span class="badge bg-warning text-dark ms-2">
                        Légendaire
                    </span>
                @endif
            </div>

            <div class="card-body">
                <dl class="row mb-0">

                    <dt class="col-sm-3">#</dt>
                    <dd class="col-sm-9">
                        {{ $pokemon->pokedex_number ?? $pokemon->id }}
                    </dd>

                    <dt class="col-sm-3">Types</dt>
                    <dd class="col-sm-9">
                        {{ $pokemon->type1 }}
                        @if($pokemon->type2)
                            , {{ $pokemon->type2 }}
                        @endif
                    </dd>

                    <dt class="col-sm-3">Génération</dt>
                    <dd class="col-sm-9">
                        {{ $pokemon->generation }}
                    </dd>

                    <dt class="col-sm-3">HP</dt>
                    <dd class="col-sm-9">{{ $pokemon->hp }}</dd>

                    <dt class="col-sm-3">Attaque</dt>
                    <dd class="col-sm-9">{{ $pokemon->attack }}</dd>

                    <dt class="col-sm-3">Défense</dt>
                    <dd class="col-sm-9">{{ $pokemon->defense }}</dd>

                    <dt class="col-sm-3">Sp. Attaque</dt>
                    <dd class="col-sm-9">{{ $pokemon->sp_attack }}</dd>

                    <dt class="col-sm-3">Sp. Défense</dt>
                    <dd class="col-sm-9">{{ $pokemon->sp_defense }}</dd>

                    <dt class="col-sm-3">Vitesse</dt>
                    <dd class="col-sm-9">{{ $pokemon->speed }}</dd>

                </dl>

                @if($pokemon->image_path)
                    <div class="mt-3">
                        <img src="{{ asset($pokemon->image_path) }}"
                             alt="{{ $pokemon->name }}"
                             class="img-fluid">
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-3 d-flex gap-2">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                ← Retour
            </a>

            <a href="{{ route('pokemon.show') }}" class="btn btn-primary">
                Voir la liste
            </a>
        </div>

    @else
        <div class="alert alert-warning">
            Pokémon introuvable.
        </div>
    @endisset
</div>
@endsection