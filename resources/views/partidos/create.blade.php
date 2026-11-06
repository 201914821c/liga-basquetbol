@extends('layouts.app')

@section('title', 'Nuevo partido')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Nuevo partido</h1>
        <p class="text-muted mb-0">Programa un encuentro entre dos equipos.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($equipos->count() < 2)
                <div class="alert alert-warning mb-0">
                    Necesitas al menos dos equipos registrados para crear un partido.
                    <a href="{{ route('equipos.create') }}">Crear equipo</a>.
                </div>
            @else
                @include('partidos._form')
            @endif
        </div>
    </div>
@endsection
