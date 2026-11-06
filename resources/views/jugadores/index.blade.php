@extends('layouts.app')

@section('title', 'Jugadores')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Jugadores</h1>
            <p class="text-muted mb-0">Jugadores registrados por equipo.</p>
        </div>
        <a href="{{ route('jugadores.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i>Nuevo jugador
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('jugadores.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label" for="equipo_id">Equipo</label>
                    <select name="equipo_id" id="equipo_id" class="form-select">
                        <option value="">Todos los equipos</option>
                        @foreach ($equipos as $equipo)
                            <option value="{{ $equipo->id }}" @selected(request('equipo_id') == $equipo->id)>
                                {{ $equipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="buscar">Buscar por nombre o apellido</label>
                    <input type="text" id="buscar" name="buscar" class="form-control" value="{{ request('buscar') }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i>Filtrar
                    </button>
                    <a href="{{ route('jugadores.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($jugadores->isEmpty())
                <p class="text-muted mb-0">No se encontraron jugadores con los filtros aplicados.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Jugador</th>
                                <th>Equipo</th>
                                <th>Dorsal</th>
                                <th>Posición</th>
                                <th>Altura</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jugadores as $jugador)
                                <tr>
                                    <td class="fw-semibold">{{ $jugador->apellido }}, {{ $jugador->nombre }}</td>
                                    <td>
                                        <a href="{{ route('equipos.show', $jugador->equipo) }}">
                                            {{ $jugador->equipo->nombre }}
                                        </a>
                                    </td>
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
                                        <a href="{{ route('jugadores.show', $jugador) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('jugadores.edit', $jugador) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('jugadores.destroy', $jugador) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar a {{ $jugador->nombre_completo }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $jugadores->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
