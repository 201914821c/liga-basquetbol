<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::withCount('jugadores')->orderBy('nombre')->paginate(10);

        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        return view('equipos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'unique:equipos,nombre'],
            'escudo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'entrenador' => ['nullable', 'string', 'max:100'],
            'anio_fundacion' => ['nullable', 'integer', 'min:1900', 'max:'.date('Y')],
        ]);

        if ($request->hasFile('escudo')) {
            $data['escudo'] = $this->guardarEscudo($request);
        }

        Equipo::create($data);

        return redirect()->route('equipos.index')
            ->with('success', 'El equipo fue registrado correctamente.');
    }

    public function show(Equipo $equipo)
    {
        $equipo->load(['jugadores' => fn ($query) => $query->orderBy('apellido')->orderBy('nombre')]);

        return view('equipos.show', compact('equipo'));
    }

    public function edit(Equipo $equipo)
    {
        return view('equipos.edit', compact('equipo'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'unique:equipos,nombre,'.$equipo->id],
            'escudo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'entrenador' => ['nullable', 'string', 'max:100'],
            'anio_fundacion' => ['nullable', 'integer', 'min:1900', 'max:'.date('Y')],
        ]);

        if ($request->hasFile('escudo')) {
            $this->eliminarEscudo($equipo);
            $data['escudo'] = $this->guardarEscudo($request);
        } elseif ($request->boolean('quitar_escudo')) {
            $this->eliminarEscudo($equipo);
            $data['escudo'] = null;
        }

        $equipo->update($data);

        return redirect()->route('equipos.index')
            ->with('success', 'El equipo fue actualizado correctamente.');
    }

    public function destroy(Equipo $equipo)
    {
        if ($equipo->partidosLocal()->exists() || $equipo->partidosVisitante()->exists()) {
            return redirect()->route('equipos.index')
                ->with('error', 'No se puede eliminar un equipo que tiene partidos registrados.');
        }

        $this->eliminarEscudo($equipo);
        $equipo->delete();

        return redirect()->route('equipos.index')
            ->with('success', 'El equipo fue eliminado correctamente.');
    }

    private function guardarEscudo(Request $request): string
    {
        $archivo = $request->file('escudo');
        $nombre = $archivo->hashName();
        $archivo->move(public_path('escudos'), $nombre);

        return $nombre;
    }

    private function eliminarEscudo(Equipo $equipo): void
    {
        if (! $equipo->escudo) {
            return;
        }

        $ruta = public_path('escudos/'.$equipo->escudo);

        if (File::exists($ruta)) {
            File::delete($ruta);
        }
    }
}
