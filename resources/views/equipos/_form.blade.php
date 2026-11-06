@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ isset($equipo) ? route('equipos.update', $equipo) : route('equipos.store') }}">
    @csrf
    @isset($equipo)
        @method('PUT')
    @endisset

    <div class="mb-3">
        <label class="form-label" for="nombre">Nombre del equipo</label>
        <input type="text" id="nombre" name="nombre" class="form-control"
               value="{{ old('nombre', $equipo->nombre ?? '') }}" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="ciudad">Ciudad</label>
            <input type="text" id="ciudad" name="ciudad" class="form-control"
                   value="{{ old('ciudad', $equipo->ciudad ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="entrenador">Entrenador</label>
            <input type="text" id="entrenador" name="entrenador" class="form-control"
                   value="{{ old('entrenador', $equipo->entrenador ?? '') }}">
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label" for="anio_fundacion">Año de fundación</label>
        <input type="number" id="anio_fundacion" name="anio_fundacion" class="form-control"
               min="1900" max="{{ date('Y') }}" value="{{ old('anio_fundacion', $equipo->anio_fundacion ?? '') }}">
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('equipos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
