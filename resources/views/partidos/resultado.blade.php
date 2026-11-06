@extends('layouts.app')

@section('title', 'Registrar resultado')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Registrar resultado</h1>
        <p class="text-muted mb-0">
            {{ $partido->equipoLocal->nombre }} vs. {{ $partido->equipoVisitante->nombre }}
            — {{ $partido->fecha->format('d/m/Y H:i') }}
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('partidos.guardarResultado', $partido) }}">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="puntos_local">
                            Puntos de {{ $partido->equipoLocal->nombre }}
                        </label>
                        <input type="number" id="puntos_local" name="puntos_local" class="form-control"
                               min="0" max="300" value="{{ old('puntos_local', $partido->puntos_local ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="puntos_visitante">
                            Puntos de {{ $partido->equipoVisitante->nombre }}
                        </label>
                        <input type="number" id="puntos_visitante" name="puntos_visitante" class="form-control"
                               min="0" max="300" value="{{ old('puntos_visitante', $partido->puntos_visitante ?? '') }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="notas">Notas</label>
                    <textarea id="notas" name="notas" rows="3" class="form-control">{{ old('notas', $partido->notas ?? '') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Guardar resultado</button>
                    <a href="{{ route('partidos.show', $partido) }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
