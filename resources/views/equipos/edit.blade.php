@extends('layouts.app')

@section('title', 'Editar equipo')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar equipo</h1>
        <p class="text-muted mb-0">Actualiza la información de {{ $equipo->nombre }}.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('equipos._form')
        </div>
    </div>
@endsection
