<div class="mb-4 pokemon-filter-card p-3">
    <h2 style="font-family: 'Press Start 2P', cursive; color: #FFD700; font-size: 0.7rem; margin-bottom: 1rem;">
        ⚙️ Filtrer les Pokémon
    </h2>

    <form action="{{ route('pokemon.filter') }}" method="GET">
        <div class="row g-3 align-items-end">

            <div class="col-12 col-md-4">
                <label for="type" class="form-label pokemon-filter-label">Type</label>
                <select id="type" name="type" class="form-select pokemon-select">
                    <option value="">— Tous —</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" @selected(request('type') === $type)>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-3">
                <label for="generation" class="form-label pokemon-filter-label">Génération</label>
                <select id="generation" name="generation" class="form-select pokemon-select">
                    <option value="">— Toutes —</option>
                    @for($i=1; $i<=9; $i++)
                        <option value="{{ $i }}" @selected((string)request('generation') === (string)$i)>Gen {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-6 col-md-3">
                <label for="is_legendary" class="form-label pokemon-filter-label">Légendaire</label>
                <select id="is_legendary" name="is_legendary" class="form-select pokemon-select">
                    <option value="">— Tous —</option>
                    <option value="1" @selected(request('is_legendary') === '1')>Oui</option>
                    <option value="0" @selected(request('is_legendary') === '0')>Non</option>
                </select>
            </div>

            <div class="col-12 col-md-2">
                <button class="btn pokemon-search-btn w-100 py-2" type="submit">Filtrer</button>
            </div>

        </div>
    </form>
</div>