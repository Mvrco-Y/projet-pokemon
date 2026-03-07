@extends('welcome')

@section('content')

<div class="container py-5">
    <h1 class="text-center mb-5" style="font-family: 'Press Start 2P', cursive; color: #FFD700; font-size: 1.2rem; text-shadow: 2px 2px #cc0000;">
        Pokédex
    </h1>

    <div id="pokemonCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

            @foreach ($pokemons->chunk(6) as $index => $chunk)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="row justify-content-center g-3">
                        @foreach ($chunk as $pokemon)
                            <div class="col-6 col-md-4 col-lg-2">
                                <div class="card pokemon-card text-center">
                                    <img src="{{ asset($pokemon->image_path) }}" alt="{{ $pokemon->name }}" class="card-img-top p-2">
                                    <div class="card-body p-2">
                                        <p class="pokemon-number">#{{ $pokemon->pokedex_number }}</p>
                                        <p class="pokemon-name">{{ $pokemon->name }}</p>
                                        <div>
                                            <span class="badge type-badge type-{{ strtolower($pokemon->type1) }}">{{ $pokemon->type1 }}</span>
                                            @if($pokemon->type2)
                                                <span class="badge type-badge type-{{ strtolower($pokemon->type2) }}">{{ $pokemon->type2 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Contrôles -->
        <button class="carousel-control-prev" type="button" data-bs-target="#pokemonCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#pokemonCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<style>
    .pokemon-card {
        background: linear-gradient(145deg, #1a1a2e, #16213e);
        border: 2px solid #FFD700;
        border-radius: 12px;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        height: 280px;
    }
    .pokemon-card img {
        height: 140px;
        object-fit: contain;
    }
    .pokemon-card:hover {
        transform: translateY(-8px) scale(1.05);
        box-shadow: 0 0 25px #FFD700bb;
    }
    .pokemon-number {
        color: #aaa;
        font-size: 0.65rem;
        margin-bottom: 2px;
        font-family: 'Press Start 2P', cursive;
    }
    .pokemon-name {
        color: #fff;
        font-weight: 700;
        font-size: 1.1rem;
        text-transform: capitalize;
        margin-bottom: 4px;
    }
    .type-badge { font-size: 0.75rem; margin: 2px; }
    .type-fire { background-color: #F08030; }
    .type-water { background-color: #6890F0; }
    .type-grass { background-color: #78C850; }
    .type-electric { background-color: #F8D030; color: #000; }
    .type-psychic { background-color: #F85888; }
    .type-ice { background-color: #98D8D8; color: #000; }
    .type-dragon { background-color: #7038F8; }
    .type-dark { background-color: #705848; }
    .type-fairy { background-color: #EE99AC; color: #000; }
    .type-normal { background-color: #A8A878; }
    .type-fighting { background-color: #C03028; }
    .type-poison { background-color: #A040A0; }
    .type-ground { background-color: #E0C068; color: #000; }
    .type-flying { background-color: #A890F0; }
    .type-bug { background-color: #A8B820; }
    .type-rock { background-color: #B8A038; }
    .type-ghost { background-color: #705898; }
    .type-steel { background-color: #B8B8D0; color: #000; }

    /* Flèches carousel */
    .carousel-control-prev,
    .carousel-control-next {
        width: 50px;
        height: 50px;
        background: #FFD700;
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
    }
    .carousel-control-prev { left: -25px; }
    .carousel-control-next { right: -25px; }
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        filter: invert(1) brightness(0);
    }
</style>

@endsection