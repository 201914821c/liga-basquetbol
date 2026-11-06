@extends('layouts.app')

@section('title', 'Panel principal')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Panel principal</h1>
            <p class="text-muted mb-0">Resumen general de la liga de básquetbol.</p>
        </div>
        <a href="{{ route('estadisticas.index') }}" class="btn btn-primary">Ver estadísticas</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Equipos</p>
                    <p class="display-6 mb-0">{{ $totales['equipos'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Jugadores</p>
                    <p class="display-6 mb-0">{{ $totales['jugadores'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Partidos</p>
                    <p class="display-6 mb-0">{{ $totales['partidos'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Finalizados</p>
                    <p class="display-6 mb-0">{{ $totales['finalizados'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="h5 mb-3">Próximo partido</h2>
            @if ($proximoPartido)
                <p class="mb-1 fw-semibold">
                    {{ $proximoPartido->equipoLocal->nombre }} vs. {{ $proximoPartido->equipoVisitante->nombre }}
                </p>
                <p class="text-muted mb-3">
                    {{ $proximoPartido->fecha->format('d/m/Y H:i') }}
                    @if ($proximoPartido->lugar)
                        — {{ $proximoPartido->lugar }}
                    @endif
                </p>
                <a href="{{ route('partidos.show', $proximoPartido) }}" class="btn btn-sm btn-outline-primary">
                    Ver partido
                </a>
            @else
                <p class="text-muted mb-0">No hay partidos programados.</p>
            @endif
        </div>
    </div>
@endsection
