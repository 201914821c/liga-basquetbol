@php
    $posiciones = ['Base', 'Escolta', 'Alero', 'Ala-Pívot', 'Pívot'];
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

<form method="POST" action="{{ isset($jugador) ? route('jugadores.update', $jugador) : route('jugadores.store') }}">
    @csrf
    @isset($jugador)
        @method('PUT')
    @endisset

    <div class="mb-3">
        <label class="form-label" for="equipo_id">Equipo</label>
        <select name="equipo_id" id="equipo_id" class="form-select" required>
            <option value="">Selecciona un equipo</option>
            @foreach ($equipos as $equipo)
                <option value="{{ $equipo->id }}"
                    @selected(old('equipo_id', $jugador->equipo_id ?? $equipoSeleccionado ?? '') == $equipo->id)>
                    {{ $equipo->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control"
                   value="{{ old('nombre', $jugador->nombre ?? '') }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" class="form-control"
                   value="{{ old('apellido', $jugador->apellido ?? '') }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label" for="dorsal">Dorsal</label>
            <input type="number" id="dorsal" name="dorsal" class="form-control" min="0" max="99"
                   value="{{ old('dorsal', $jugador->dorsal ?? '') }}" required>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label" for="posicion">Posición</label>
            <select name="posicion" id="posicion" class="form-select" required>
                <option value="">Selecciona una posición</option>
                @foreach ($posiciones as $posicion)
                    <option value="{{ $posicion }}" @selected(old('posicion', $jugador->posicion ?? '') === $posicion)>
                        {{ $posicion }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label" for="altura">Altura (m)</label>
            <input type="number" step="0.01" id="altura" name="altura" class="form-control" min="1" max="2.5"
                   value="{{ old('altura', $jugador->altura ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="fecha_nacimiento">Fecha de nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control"
                   value="{{ old('fecha_nacimiento', isset($jugador) && $jugador->fecha_nacimiento ? $jugador->fecha_nacimiento->format('Y-m-d') : '') }}">
        </div>
        <div class="col-md-6 mb-3 d-flex align-items-end">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1"
                    @checked(old('activo', $jugador->activo ?? true))>
                <label class="form-check-label" for="activo">Jugador activo</label>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('jugadores.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
