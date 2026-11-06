@extends('layouts.app')

@section('title', 'Partidos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Partidos</h1>
            <p class="text-muted mb-0">Calendario y resultados de la liga.</p>
        </div>
        <a href="{{ route('partidos.create') }}" class="btn btn-primary">Nuevo partido</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('partidos.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label" for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="programado" @selected(request('estado') === 'programado')>Programado</option>
                        <option value="finalizado" @selected(request('estado') === 'finalizado')>Finalizado</option>
                    </select>
                </div>
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
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('partidos.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($partidos->isEmpty())
                <p class="text-muted mb-0">No hay partidos registrados con los filtros aplicados.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Local</th>
                                <th>Visitante</th>
                                <th>Marcador</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($partidos as $partido)
                                <tr>
                                    <td>{{ $partido->fecha->format('d/m/Y H:i') }}</td>
                                    <td class="fw-semibold">{{ $partido->equipoLocal->nombre }}</td>
                                    <td class="fw-semibold">{{ $partido->equipoVisitante->nombre }}</td>
                                    <td>
                                        @if ($partido->estaFinalizado())
                                            {{ $partido->puntos_local }} - {{ $partido->puntos_visitante }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        @if ($partido->estaFinalizado())
                                            <span class="badge bg-success">Finalizado</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Programado</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('partidos.show', $partido) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                        @if (! $partido->estaFinalizado())
                                            <a href="{{ route('partidos.resultado', $partido) }}" class="btn btn-sm btn-outline-success">Resultado</a>
                                        @endif
                                        <a href="{{ route('partidos.edit', $partido) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                        <form action="{{ route('partidos.destroy', $partido) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar este partido?');">
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

                <div class="mt-3">
                    {{ $partidos->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
