@extends('layouts.app')

@section('title', 'Detalle del partido')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                {{ $partido->equipoLocal->nombre }} vs. {{ $partido->equipoVisitante->nombre }}
            </h1>
            <p class="text-muted mb-0">{{ $partido->fecha->format('d/m/Y H:i') }}</p>
        </div>
        <div class="d-flex gap-2">
            @if (! $partido->estaFinalizado())
                <a href="{{ route('partidos.resultado', $partido) }}" class="btn btn-success">Registrar resultado</a>
            @endif
            <a href="{{ route('partidos.edit', $partido) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('partidos.index') }}" class="btn btn-outline-secondary">Volver</a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <div class="row align-items-center">
                <div class="col-5">
                    <img src="{{ $partido->equipoLocal->escudo_url }}"
                         alt="Escudo de {{ $partido->equipoLocal->nombre }}"
                         class="team-escudo escudo-lg mb-2">
                    <h2 class="h4 mb-1">{{ $partido->equipoLocal->nombre }}</h2>
                    <span class="text-muted">Local</span>
                </div>
                <div class="col-2">
                    @if ($partido->estaFinalizado())
                        <span class="display-5 fw-bold">
                            {{ $partido->puntos_local }} - {{ $partido->puntos_visitante }}
                        </span>
                    @else
                        <span class="display-6 text-muted">vs.</span>
                    @endif
                </div>
                <div class="col-5">
                    <img src="{{ $partido->equipoVisitante->escudo_url }}"
                         alt="Escudo de {{ $partido->equipoVisitante->nombre }}"
                         class="team-escudo escudo-lg mb-2">
                    <h2 class="h4 mb-1">{{ $partido->equipoVisitante->nombre }}</h2>
                    <span class="text-muted">Visitante</span>
                </div>
            </div>
            <div class="mt-3">
                @if ($partido->estaFinalizado())
                    <span class="badge bg-success">Finalizado</span>
                @else
                    <span class="badge bg-warning text-dark">Programado</span>
                @endif
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Lugar</dt>
                <dd class="col-sm-9">{{ $partido->lugar ?? '—' }}</dd>

                <dt class="col-sm-3">Notas</dt>
                <dd class="col-sm-9">{{ $partido->notas ?? '—' }}</dd>

                <dt class="col-sm-3">Registrado</dt>
                <dd class="col-sm-9">{{ $partido->created_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
@endsection
