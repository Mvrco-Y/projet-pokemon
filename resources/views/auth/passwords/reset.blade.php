@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="text-center mb-4">
                <h1 style="font-family: 'Press Start 2P', cursive; color: #FFD700; font-size: 1rem; text-shadow: 2px 2px #cc0000;">
                    Nouveau mot de passe
                </h1>
                <p style="color: #aaa;">Choisis un nouveau mot de passe Dresseur !</p>
            </div>

            <div class="pokemon-form-card p-4">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label pokemon-label">Adresse Email</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ $email ?? old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label pokemon-label">Nouveau mot de passe</label>
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
                            Réinitialiser
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" style="color: #aaa; font-size: 0.9rem;">
                    Retour à la <span style="color:#FFD700;">Connexion</span>
                </a>
            </div>

        </div>
    </div>
</div>
@endsection