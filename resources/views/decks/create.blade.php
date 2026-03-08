@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="text-center mb-4">
                <h1 style="font-family: 'Press Start 2P', cursive; color: #FFD700; font-size: 1rem; text-shadow: 2px 2px #cc0000;">
                    Nouveau Deck
                </h1>
                <p style="color: #aaa;">Crée ton deck de combat !</p>
            </div>

            <div class="pokemon-form-card p-4">
                <form action="{{ route('decks.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label pokemon-label">Nom du deck</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label pokemon-label">Description <span style="color:#555;">(optionnel)</span></label>
                        <textarea id="description" name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Décris ta stratégie...">{{ old('description') }}</textarea>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn pokemon-btn pokemon-btn-block">
                            ✅ Créer le deck
                        </button>
                        <a href="{{ route('decks.index') }}" class="btn pokemon-cancel-btn px-4">
                            Annuler
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection