@extends('layouts.app')

@section('title', 'Nuevo equipo')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Nuevo equipo</h1>
        <p class="text-muted mb-0">Registra un equipo para la liga.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('equipos._form')
        </div>
    </div>
@endsection
