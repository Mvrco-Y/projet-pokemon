@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="text-center mb-4">
                <h1 style="font-family: 'Press Start 2P', cursive; color: #FFD700; font-size: 1rem; text-shadow: 2px 2px #cc0000;">
                    Connexion
                </h1>
                <p style="color: #aaa;">Bienvenue Dresseur !</p>
            </div>

            <div class="pokemon-form-card p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label pokemon-label">Adresse Email</label>
                        <input id="email" type="email"
                            class="form-control pokemon-input @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label pokemon-label">Mot de passe</label>
                        <input id="password" type="password"
                            class="form-control pokemon-input @error('password') is-invalid @enderror"
                            name="password" required>
                        @error('password')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember" style="color:#aaa;">Se souvenir de moi</label>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn pokemon-btn">
                            Se connecter
                        </button>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a href="{{ route('password.request') }}" style="color: #FFD700; font-size: 0.85rem;">
                                Mot de passe oublié ?
                            </a>
                        </div>
                    @endif

                </form>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('register') }}" style="color: #aaa; font-size: 0.9rem;">
                    Pas encore de compte ? <span style="color:#FFD700;">S'inscrire</span>
                </a>
            </div>

        </div>
    </div>
</div>



@endsection