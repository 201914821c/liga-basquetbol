@extends('layouts.app')

@section('title', $jugador->nombre_completo)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $jugador->nombre_completo }}</h1>
            <p class="text-muted mb-0">Ficha del jugador.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('jugadores.edit', $jugador) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('equipos.show', $jugador->equipo) }}" class="btn btn-outline-secondary">Ver equipo</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Equipo</dt>
                <dd class="col-sm-9">
                    <a href="{{ route('equipos.show', $jugador->equipo) }}">{{ $jugador->equipo->nombre }}</a>
                </dd>

                <dt class="col-sm-3">Dorsal</dt>
                <dd class="col-sm-9">{{ $jugador->dorsal }}</dd>

                <dt class="col-sm-3">Posición</dt>
                <dd class="col-sm-9">{{ $jugador->posicion }}</dd>

                <dt class="col-sm-3">Altura</dt>
                <dd class="col-sm-9">{{ $jugador->altura ? $jugador->altura.' m' : '—' }}</dd>

                <dt class="col-sm-3">Fecha de nacimiento</dt>
                <dd class="col-sm-9">
                    {{ $jugador->fecha_nacimiento ? $jugador->fecha_nacimiento->format('d/m/Y') : '—' }}
                </dd>

                <dt class="col-sm-3">Estado</dt>
                <dd class="col-sm-9">
                    @if ($jugador->activo)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
@endsection
