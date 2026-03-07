@isset($pokemons)
    <div class="row g-3">
        @forelse ($pokemons as $p)
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('pokemon.detail', $p->id) }}" class="pokemon-card-link">
                    <div class="poke-card">
                        <div class="poke-overlay">
                            <span>Voir la fiche</span>
                        </div>
                        <img src="{{ asset($p->image_path) }}" alt="{{ $p->name }}">
                        <div class="poke-info">
                            <p class="poke-number">#{{ $p->pokedex_number ?? $p->id }}</p>
                            <p class="poke-name">{{ $p->name }}</p>
                            <div class="poke-types">
                                @if(isset($p->type1))
                                    <span class="badge type-badge type-{{ strtolower($p->type1) }}">{{ $p->type1 }}</span>
                                @endif
                                @if(isset($p->type2))
                                    <span class="badge type-badge type-{{ strtolower($p->type2) }}">{{ $p->type2 }}</span>
                                @endif
                            </div>
                            <p class="poke-gen">Gen {{ $p->generation ?? '?' }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p style="color:#aaa;">Aucun Pokémon à afficher.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $pokemons->links() }}
    </div>

@else
    <p style="color:#aaa;">La liste des Pokémon n'a pas été fournie.</p>
@endisset