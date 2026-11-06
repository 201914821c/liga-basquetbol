@php
    $estados = ['programado' => 'Programado', 'finalizado' => 'Finalizado'];
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ isset($partido) ? route('partidos.update', $partido) : route('partidos.store') }}">
    @csrf
    @isset($partido)
        @method('PUT')
    @endisset

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="equipo_local_id">Equipo local</label>
            <select name="equipo_local_id" id="equipo_local_id" class="form-select" required>
                <option value="">Selecciona un equipo</option>
                @foreach ($equipos as $equipo)
                    <option value="{{ $equipo->id }}"
                        @selected(old('equipo_local_id', $partido->equipo_local_id ?? '') == $equipo->id)>
                        {{ $equipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="equipo_visitante_id">Equipo visitante</label>
            <select name="equipo_visitante_id" id="equipo_visitante_id" class="form-select" required>
                <option value="">Selecciona un equipo</option>
                @foreach ($equipos as $equipo)
                    <option value="{{ $equipo->id }}"
                        @selected(old('equipo_visitante_id', $partido->equipo_visitante_id ?? '') == $equipo->id)>
                        {{ $equipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="fecha">Fecha y hora</label>
            <input type="datetime-local" id="fecha" name="fecha" class="form-control"
                   value="{{ old('fecha', isset($partido) && $partido->fecha ? $partido->fecha->format('Y-m-d\TH:i') : '') }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="lugar">Lugar</label>
            <input type="text" id="lugar" name="lugar" class="form-control"
                   value="{{ old('lugar', $partido->lugar ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label" for="estado">Estado</label>
            <select name="estado" id="estado" class="form-select" required>
                @foreach ($estados as $valor => $etiqueta)
                    <option value="{{ $valor }}" @selected(old('estado', $partido->estado ?? 'programado') === $valor)>
                        {{ $etiqueta }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label" for="puntos_local">Puntos del local</label>
            <input type="number" id="puntos_local" name="puntos_local" class="form-control" min="0" max="300"
                   value="{{ old('puntos_local', $partido->puntos_local ?? '') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label" for="puntos_visitante">Puntos del visitante</label>
            <input type="number" id="puntos_visitante" name="puntos_visitante" class="form-control" min="0" max="300"
                   value="{{ old('puntos_visitante', $partido->puntos_visitante ?? '') }}">
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label" for="notas">Notas</label>
        <textarea id="notas" name="notas" rows="3" class="form-control">{{ old('notas', $partido->notas ?? '') }}</textarea>
        <div class="form-text">Si el partido está programado, el marcador se guardará como pendiente.</div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('partidos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
