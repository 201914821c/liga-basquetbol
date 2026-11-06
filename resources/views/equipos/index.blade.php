@extends('layouts.app')

@section('title', 'Equipos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Equipos</h1>
            <p class="text-muted mb-0">Equipos registrados en la liga.</p>
        </div>
        <a href="{{ route('equipos.create') }}" class="btn btn-primary">
            <i class="bi bi-shield-plus me-1"></i>Nuevo equipo
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($equipos->isEmpty())
                <p class="text-muted mb-0">Todavía no hay equipos registrados.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Ciudad</th>
                                <th>Entrenador</th>
                                <th>Fundación</th>
                                <th>Jugadores</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipos as $equipo)
                                <tr>
                                    <td>{{ $equipo->id }}</td>
                                    <td class="fw-semibold">{{ $equipo->nombre }}</td>
                                    <td>{{ $equipo->ciudad ?? '—' }}</td>
                                    <td>{{ $equipo->entrenador ?? '—' }}</td>
                                    <td>{{ $equipo->anio_fundacion ?? '—' }}</td>
                                    <td>{{ $equipo->jugadores_count }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('equipos.show', $equipo) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('equipos.destroy', $equipo) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar el equipo {{ $equipo->nombre }}?');">
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
                    {{ $equipos->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
