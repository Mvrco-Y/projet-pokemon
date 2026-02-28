@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div >
                <div>
                   

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                       

                        <main>
                            <section class='filterpokemon'>
                                @include('pokemon.search')
                            </section>

                            <section class='searchpokemon'>
                                @include('pokemon.filter')
                            </section>

                            <section class='listpokemon'>
                               @include('pokemon.show')
                            </section>
                            
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
