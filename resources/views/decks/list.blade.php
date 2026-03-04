<a href="{{ route('decks.create') }}" class="btn btn-primary">
    Créer un nouveau deck
</a>

<br><br>

@if($decks->count() === 0)
    <p>Aucun deck pour le moment.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Nom du deck</th>
                <th>Total Pokémon</th>
                <th style="width: 220px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($decks as $deck)
                <tr>
                    {{-- Ouvrir le deck en cliquant sur le nom --}}
                    <td>
                        <a href="{{ route('decks.show', $deck->id) }}">
                            {{ $deck->name }}
                        </a>
                    </td>

                    {{-- Total de Pokémon (quantités additionnées) --}}
                    <td>
                        {{ $deck->pokemons->sum('pivot.quantity') }}
                    </td>

                    <td>
                        {{-- Modifier (renommer) --}}
                        <a href="{{ route('decks.edit', $deck->id) }}" class="btn btn-sm btn-secondary">
                            Modifier
                        </a>

                        {{-- Supprimer --}}
                        <form action="{{ route('decks.destroy', $deck->id) }}"
                              method="POST"
                              style="display:inline-block;"
                              onsubmit="return confirm('Supprimer ce deck ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination (si tu as utilisé ->paginate() dans le controller) --}}
    @if(method_exists($decks, 'hasPages') && $decks->hasPages())
        {{ $decks->links() }}
    @endif
@endif