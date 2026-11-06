<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

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
            'ciudad' => ['nullable', 'string', 'max:100'],
            'entrenador' => ['nullable', 'string', 'max:100'],
            'anio_fundacion' => ['nullable', 'integer', 'min:1900', 'max:'.date('Y')],
        ]);

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
            'ciudad' => ['nullable', 'string', 'max:100'],
            'entrenador' => ['nullable', 'string', 'max:100'],
            'anio_fundacion' => ['nullable', 'integer', 'min:1900', 'max:'.date('Y')],
        ]);

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

        $equipo->delete();

        return redirect()->route('equipos.index')
            ->with('success', 'El equipo fue eliminado correctamente.');
    }
}
