@extends('layouts.app')

@section('title', $equipo->nombre)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $equipo->nombre }}</h1>
            <p class="text-muted mb-0">Detalle del equipo.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('equipos.index') }}" class="btn btn-outline-secondary">Volver</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Ciudad</dt>
                <dd class="col-sm-9">{{ $equipo->ciudad ?? '—' }}</dd>

                <dt class="col-sm-3">Entrenador</dt>
                <dd class="col-sm-9">{{ $equipo->entrenador ?? '—' }}</dd>

                <dt class="col-sm-3">Año de fundación</dt>
                <dd class="col-sm-9">{{ $equipo->anio_fundacion ?? '—' }}</dd>

                <dt class="col-sm-3">Registrado</dt>
                <dd class="col-sm-9">{{ $equipo->created_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
@endsection
