@extends('layouts.app')

@section('title', 'Estadísticas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Estadísticas</h1>
            <p class="text-muted mb-0">Tabla de posiciones, resultados y próximos partidos.</p>
        </div>
        <a href="{{ route('partidos.create') }}" class="btn btn-primary">Nuevo partido</a>
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

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-1">Tabla de posiciones</h2>
            <p class="text-muted small mb-3">2 puntos por victoria y 1 punto por derrota.</p>

            @if ($tabla->isEmpty())
                <p class="text-muted mb-0">Aún no hay equipos registrados.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Equipo</th>
                                <th class="text-center">PJ</th>
                                <th class="text-center">PG</th>
                                <th class="text-center">PP</th>
                                <th class="text-center">PF</th>
                                <th class="text-center">PC</th>
                                <th class="text-center">DIF</th>
                                <th class="text-center">PTS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tabla as $posicion => $fila)
                                <tr class="{{ $posicion === 0 ? 'table-success' : '' }}">
                                    <td>{{ $posicion + 1 }}</td>
                                    <td class="fw-semibold">
                                        <a href="{{ route('equipos.show', $fila['equipo']) }}">{{ $fila['equipo']->nombre }}</a>
                                    </td>
                                    <td class="text-center">{{ $fila['pj'] }}</td>
                                    <td class="text-center">{{ $fila['pg'] }}</td>
                                    <td class="text-center">{{ $fila['pp'] }}</td>
                                    <td class="text-center">{{ $fila['pf'] }}</td>
                                    <td class="text-center">{{ $fila['pc'] }}</td>
                                    <td class="text-center">{{ $fila['dif'] > 0 ? '+'.$fila['dif'] : $fila['dif'] }}</td>
                                    <td class="text-center fw-bold">{{ $fila['pts'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Resultados recientes</h2>
                    @forelse ($resultadosRecientes as $partido)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <div>
                                <div class="fw-semibold">
                                    {{ $partido->equipoLocal->nombre }} {{ $partido->puntos_local }}
                                    -
                                    {{ $partido->puntos_visitante }} {{ $partido->equipoVisitante->nombre }}
                                </div>
                                <div class="text-muted small">{{ $partido->fecha->format('d/m/Y') }}</div>
                            </div>
                            <a href="{{ route('partidos.show', $partido) }}" class="btn btn-sm btn-outline-secondary align-self-center">Ver</a>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Todavía no hay partidos finalizados.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Próximos partidos</h2>
                    @forelse ($proximosPartidos as $partido)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <div>
                                <div class="fw-semibold">
                                    {{ $partido->equipoLocal->nombre }} vs. {{ $partido->equipoVisitante->nombre }}
                                </div>
                                <div class="text-muted small">
                                    {{ $partido->fecha->format('d/m/Y H:i') }}
                                    @if ($partido->lugar)
                                        — {{ $partido->lugar }}
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('partidos.show', $partido) }}" class="btn btn-sm btn-outline-secondary align-self-center">Ver</a>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No hay partidos programados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
