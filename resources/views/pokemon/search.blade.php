<div class="mb-4">
    <form action="{{ route('pokemon.search') }}" method="GET">
        <div class="input-group pokemon-search-group">
            <span class="input-group-text pokemon-search-icon">🔍</span>
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                class="form-control pokemon-search-input"
                placeholder="Rechercher un Pokémon (ex: Bulba)..."
            >
            <button class="btn pokemon-search-btn" type="submit">Rechercher</button>
        </div>
    </form>
</div>