
@extends('layouts.app')

@section('content')
    <h1>Mes Decks</h1>
    @include('decks.list')

    
{{-- Pagination --}}
@if(isset($decks) && $decks->hasPages())
    {{ $decks->links() }}
@endif


@endsection
