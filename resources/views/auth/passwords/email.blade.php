@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="text-center mb-4">
                <h1 style="font-family: 'Press Start 2P', cursive; color: #FFD700; font-size: 1rem; text-shadow: 2px 2px #cc0000;">
                    Mot de passe oublié
                </h1>
                <p style="color: #aaa;">On va te renvoyer dans l'arène !</p>
            </div>

            <div class="pokemon-form-card p-4">

                @if (session('status'))
                    <div class="alert mb-3" style="background:#1a3a1a; border:1px solid #78C850; color:#78C850; border-radius:8px;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label pokemon-label">Adresse Email</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn pokemon-btn">
                            Envoyer le lien
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