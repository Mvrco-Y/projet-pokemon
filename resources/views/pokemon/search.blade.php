<div class="mb-3">
    <h2 class="h5">Rechercher un Pokémon 🔍</h2>

    <form action="{{ route('pokemon.search') }}" method="GET">
        <div class="input-group">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                class="form-control"
                placeholder="Nom du Pokémon (ex: Bulba)"
            >
            <button class="btn btn-primary" type="submit">Rechercher</button>
        </div>
    </form>
</div>