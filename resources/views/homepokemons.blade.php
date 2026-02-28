@extends('welcome')

@section('content')

    <div>
        @foreach ($pokemons as $pokemon)
            <div>
            <img src="{{ asset($pokemon->image_path) }}" alt="{{ $pokemon->name }}">
            <div>#{{ $pokemon->pokedex_number }} — {{ $pokemon->name }}</div>
            <div>
                {{ $pokemon->type1 }}@if($pokemon->type2) / {{ $pokemon->type2 }} @endif
            </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $pokemons->onEachSide(1)->links() }}
    </div>

@endsection




