{{-- resources/views/pokemon/show.blade.php --}}

@isset($pokemons)
    <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Type(s)</th>
                    <th>Génération</th>
                    <th>Détail</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pokemons as $p)
                    <tr>
                        <td>{{ $p->pokedex_number ?? $p->id }}</td>
                        <td>{{ $p->name }}</td>
                        <td>
                            @php
                                // Adapte ceci selon ton schéma de données
                                $types = [];
                                if (isset($p->type_primary))   $types[] = $p->type_primary;
                                if (isset($p->type_secondary)) $types[] = $p->type_secondary;
                            @endphp
                            {{ $types ? implode(', ', $types) : '—' }}
                        </td>
                        <td>{{ $p->generation ?? '—' }}</td>
                        <td>
                            <a href="{{ route('pokemon.detail', $p->id) }}" class="btn btn-sm btn-primary">
                                Voir la fiche
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Aucun Pokémon à afficher.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $pokemons->links() }}
    </div>
@else
    <div class="alert alert-warning">La liste des Pokémon n'a pas été fournie à la vue.</div>
@endisset