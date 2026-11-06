@extends('layouts.app')

@section('title', $equipo->nombre)

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ $equipo->escudo_url }}" alt="Escudo de {{ $equipo->nombre }}" class="team-escudo escudo-lg">
            <div>
                <h1 class="h3 mb-1">{{ $equipo->nombre }}</h1>
                <p class="text-muted mb-0">Detalle del equipo.</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i>Editar
            </a>
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

    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h2 class="h5 mb-0">Jugadores ({{ $equipo->jugadores->count() }})</h2>
        <a href="{{ route('jugadores.create', ['equipo_id' => $equipo->id]) }}" class="btn btn-sm btn-primary">
            Agregar jugador
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($equipo->jugadores->isEmpty())
                <p class="text-muted mb-0">Este equipo todavía no tiene jugadores registrados.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Jugador</th>
                                <th>Dorsal</th>
                                <th>Posición</th>
                                <th>Altura</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipo->jugadores as $jugador)
                                <tr>
                                    <td class="fw-semibold">{{ $jugador->apellido }}, {{ $jugador->nombre }}</td>
                                    <td>{{ $jugador->dorsal }}</td>
                                    <td>{{ $jugador->posicion }}</td>
                                    <td>{{ $jugador->altura ? $jugador->altura.' m' : '—' }}</td>
                                    <td>
                                        @if ($jugador->activo)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-secondary">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('jugadores.show', $jugador) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                        <a href="{{ route('jugadores.edit', $jugador) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                        <form action="{{ route('jugadores.destroy', $jugador) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar a {{ $jugador->nombre_completo }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
