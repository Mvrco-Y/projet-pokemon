@extends('welcome')

@section('content')

    <h2>Liste des Pokémons</h2>

    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Type 1</th>
                <th>Type 2</th>
                <th>Image</th>
            </tr>
        </thead>

        <tbody>
            @foreach($pokemons as $pokemon)
                <tr>
                    <td>{{ $pokemon->id }}</td>
                    <td>{{ $pokemon->name }}</td>
                    <td>{{ $pokemon->type1 }}</td>
                    <td>{{ $pokemon->type2 ?? '—' }}</td>

                    <td>
                        <img 
                            src="{{ asset($pokemon->image_path) }}" 
                            alt="{{ $pokemon->name }}" 
                            width="50"
                            height="30"
                        >
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection




