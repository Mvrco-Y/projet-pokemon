@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="text-center mb-4">
                <h1 style="font-family: 'Press Start 2P', cursive; color: #FFD700; font-size: 1rem; text-shadow: 2px 2px #cc0000;">
                    Vérification
                </h1>
                <p style="color: #aaa;">Vérifie ta boîte mail Dresseur !</p>
            </div>

            <div class="pokemon-form-card p-4 text-center">

                @if (session('resent'))
                    <div class="alert" style="background:#1a3a1a; border:1px solid #78C850; color:#78C850; border-radius:8px;">
                        ✅ Un nouveau lien de vérification a été envoyé à ton adresse email.
                    </div>
                @endif

                <p style="color:#aaa; margin: 1rem 0;">
                    Avant de continuer, vérifie ton email et clique sur le lien de vérification.
                </p>

                <p style="color:#aaa;">
                    Tu n'as pas reçu l'email ?
                </p>

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn pokemon-btn mt-2">
                        Renvoyer le lien
                    </button>
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