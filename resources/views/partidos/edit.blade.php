@extends('layouts.app')

@section('title', 'Editar partido')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar partido</h1>
        <p class="text-muted mb-0">
            {{ $partido->equipoLocal->nombre }} vs. {{ $partido->equipoVisitante->nombre }}
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('partidos._form')
        </div>
    </div>
@endsection
