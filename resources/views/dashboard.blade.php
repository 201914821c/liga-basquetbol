@extends('layouts.app')

@section('title', 'Panel principal')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Panel principal</h1>
            <p class="text-muted mb-0">Resumen general de la liga de básquetbol.</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <p class="mb-0">Usa el menú superior para gestionar equipos, jugadores y partidos.</p>
        </div>
    </div>
@endsection
