<div class="mb-3">
    <h2 class="h5">Filtrer les Pokémon</h2>

    <form action="{{ route('pokemon.filter') }}" method="GET">
        <div class="row g-3">

            {{-- Type (liste fixe pour l’instant — on pourra la rendre dynamique plus tard) --}}
            <div class="col-12 col-md-4">
                <label for="type" class="form-label">Type</label>
                <select id="type" name="type" class="form-select">
                    <option value="">— Tous —</option>

                    @foreach($types as $type)
                        <option value="{{ $type }}"
                            @selected(request('type') === $type)>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Génération --}}
            <div class="col-6 col-md-3">
                <label for="generation" class="form-label">Génération</label>
                <select id="generation" name="generation" class="form-select">
                    <option value="">— Toutes —</option>
                    @for($i=1; $i<=9; $i++)
                        <option value="{{ $i }}" @selected((string)request('generation') === (string)$i)>Gen {{ $i }}</option>
                    @endfor
                </select>
            </div>

            {{-- Légendaire --}}
            <div class="col-6 col-md-3">
                <label for="is_legendary" class="form-label">Légendaire</label>
                <select id="is_legendary" name="is_legendary" class="form-select">
                    <option value="">— Tous —</option>
                    <option value="1" @selected(request('is_legendary') === '1')>Oui</option>
                    <option value="0" @selected(request('is_legendary') === '0')>Non</option>
                </select>
            </div>

            <div class="col-12 col-md-2 align-self-end">
                <button class="btn btn-secondary w-100" type="submit">Filtrer</button>
            </div>
        </div>
    </form>
</div>