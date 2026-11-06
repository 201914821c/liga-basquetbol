@extends('layouts.app')

@section('title', 'Editar jugador')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar jugador</h1>
        <p class="text-muted mb-0">Actualiza la información de {{ $jugador->nombre_completo }}.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('jugadores._form')
        </div>
    </div>
@endsection
