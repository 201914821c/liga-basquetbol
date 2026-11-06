@extends('layouts.app')

@section('title', 'Nuevo jugador')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Nuevo jugador</h1>
        <p class="text-muted mb-0">Registra un jugador y asígnalo a un equipo.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($equipos->isEmpty())
                <div class="alert alert-warning mb-0">
                    Primero debes registrar un equipo.
                    <a href="{{ route('equipos.create') }}">Crear equipo</a>.
                </div>
            @else
                @include('jugadores._form')
            @endif
        </div>
    </div>
@endsection
