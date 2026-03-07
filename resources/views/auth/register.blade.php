@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="text-center mb-4">
                <h1 style="font-family: 'Press Start 2P', cursive; color: #FFD700; font-size: 1rem; text-shadow: 2px 2px #cc0000;">
                    Inscription
                </h1>
                <p style="color: #aaa;">Commence ton aventure Dresseur !</p>
            </div>

            <div class="pokemon-form-card p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label pokemon-label">Nom du Dresseur</label>
                        <input id="name" type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label pokemon-label">Adresse Email</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label pokemon-label">Mot de passe</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required>
                        @error('password')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm" class="form-label pokemon-label">Confirmer le mot de passe</label>
                        <input id="password-confirm" type="password"
                            class="form-control"
                            name="password_confirmation" required>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn pokemon-btn">
                            S'inscrire
                        </button>
                    </div>

                </form>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" style="color: #aaa; font-size: 0.9rem;">
                    Déjà un compte ? <span style="color:#FFD700;">Se connecter</span>
                </a>
            </div>

        </div>
    </div>
</div>
@endsection