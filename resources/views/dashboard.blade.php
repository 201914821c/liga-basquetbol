@extends('layouts.app')

@section('title', 'Panel principal')

@section('content')
    <section class="hero mb-4">
        <div class="hero-content">
            <span class="badge bg-warning text-dark mb-3">Temporada 2026</span>
            <h1 class="display-5 mb-2">Bienvenido, {{ auth()->user()->name }}</h1>
            <p class="lead mb-4">
                Administra equipos, jugadores y partidos de la liga, y sigue la tabla de posiciones en tiempo real.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('estadisticas.index') }}" class="btn btn-primary">
                    <i class="bi bi-bar-chart-line me-1"></i>Ver estadísticas
                </a>
                <a href="{{ route('partidos.create') }}" class="btn btn-outline-light">
                    <i class="bi bi-plus-circle me-1"></i>Programar partido
                </a>
            </div>
        </div>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="stat-icon mb-3"><i class="bi bi-shield-shaded"></i></div>
                    <p class="text-muted mb-1">Equipos</p>
                    <p class="stat-value mb-0">{{ $totales['equipos'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="stat-icon mb-3"><i class="bi bi-people"></i></div>
                    <p class="text-muted mb-1">Jugadores</p>
                    <p class="stat-value mb-0">{{ $totales['jugadores'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="stat-icon mb-3"><i class="bi bi-calendar-event"></i></div>
                    <p class="text-muted mb-1">Partidos</p>
                    <p class="stat-value mb-0">{{ $totales['partidos'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="stat-icon mb-3"><i class="bi bi-check2-circle"></i></div>
                    <p class="text-muted mb-1">Finalizados</p>
                    <p class="stat-value mb-0">{{ $totales['finalizados'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h5 section-title mb-3">Próximo partido</h2>
                    @if ($proximoPartido)
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <div>
                                <p class="mb-1 fw-semibold fs-5">
                                    {{ $proximoPartido->equipoLocal->nombre }}
                                    <span class="text-muted">vs.</span>
                                    {{ $proximoPartido->equipoVisitante->nombre }}
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-calendar3 me-1"></i>{{ $proximoPartido->fecha->format('d/m/Y H:i') }}
                                    @if ($proximoPartido->lugar)
                                        <span class="ms-3"><i class="bi bi-geo-alt me-1"></i>{{ $proximoPartido->lugar }}</span>
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('partidos.show', $proximoPartido) }}" class="btn btn-outline-primary">
                                Ver partido
                            </a>
                        </div>
                    @else
                        <p class="text-muted mb-0">No hay partidos programados.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h5 section-title mb-3">Accesos rápidos</h2>
                    <div class="d-grid gap-2">
                        <a href="{{ route('equipos.create') }}" class="btn btn-outline-primary text-start">
                            <i class="bi bi-shield-plus me-2"></i>Registrar equipo
                        </a>
                        <a href="{{ route('jugadores.create') }}" class="btn btn-outline-primary text-start">
                            <i class="bi bi-person-plus me-2"></i>Registrar jugador
                        </a>
                        <a href="{{ route('partidos.create') }}" class="btn btn-outline-primary text-start">
                            <i class="bi bi-calendar-plus me-2"></i>Programar partido
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
