<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Partido;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PartidoController extends Controller
{
    public function index(Request $request)
    {
        $equipos = Equipo::orderBy('nombre')->get();

        $query = Partido::with(['equipoLocal', 'equipoVisitante']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('equipo_id')) {
            $equipoId = $request->integer('equipo_id');
            $query->where(function ($sub) use ($equipoId) {
                $sub->where('equipo_local_id', $equipoId)
                    ->orWhere('equipo_visitante_id', $equipoId);
            });
        }

        $partidos = $query->orderByDesc('fecha')
            ->paginate(10)
            ->withQueryString();

        return view('partidos.index', compact('partidos', 'equipos'));
    }

    public function create()
    {
        $equipos = Equipo::orderBy('nombre')->get();

        return view('partidos.create', compact('equipos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        if ($data['estado'] === 'programado') {
            $data['puntos_local'] = null;
            $data['puntos_visitante'] = null;
        }

        $partido = Partido::create($data);

        return redirect()->route('partidos.show', $partido)
            ->with('success', 'El partido fue registrado correctamente.');
    }

    public function show(Partido $partido)
    {
        $partido->load(['equipoLocal', 'equipoVisitante']);

        return view('partidos.show', compact('partido'));
    }

    public function edit(Partido $partido)
    {
        $equipos = Equipo::orderBy('nombre')->get();

        return view('partidos.edit', compact('partido', 'equipos'));
    }

    public function update(Request $request, Partido $partido)
    {
        $data = $request->validate($this->rules(), $this->messages());

        if ($data['estado'] === 'programado') {
            $data['puntos_local'] = null;
            $data['puntos_visitante'] = null;
        }

        $partido->update($data);

        return redirect()->route('partidos.show', $partido)
            ->with('success', 'El partido fue actualizado correctamente.');
    }

    public function destroy(Partido $partido)
    {
        $partido->delete();

        return redirect()->route('partidos.index')
            ->with('success', 'El partido fue eliminado correctamente.');
    }

    public function resultado(Partido $partido)
    {
        $partido->load(['equipoLocal', 'equipoVisitante']);

        return view('partidos.resultado', compact('partido'));
    }

    public function guardarResultado(Request $request, Partido $partido)
    {
        $data = $request->validate([
            'puntos_local' => ['required', 'integer', 'min:0', 'max:300'],
            'puntos_visitante' => ['required', 'integer', 'min:0', 'max:300'],
            'notas' => ['nullable', 'string', 'max:500'],
        ]);

        $partido->update([
            'puntos_local' => $data['puntos_local'],
            'puntos_visitante' => $data['puntos_visitante'],
            'notas' => $data['notas'] ?? $partido->notas,
            'estado' => 'finalizado',
        ]);

        return redirect()->route('partidos.show', $partido)
            ->with('success', 'El resultado del partido fue registrado.');
    }

    private function rules(): array
    {
        return [
            'equipo_local_id' => ['required', 'integer', 'exists:equipos,id'],
            'equipo_visitante_id' => ['required', 'integer', 'exists:equipos,id', 'different:equipo_local_id'],
            'fecha' => ['required', 'date'],
            'lugar' => ['nullable', 'string', 'max:150'],
            'estado' => ['required', Rule::in(['programado', 'finalizado'])],
            'puntos_local' => ['nullable', 'integer', 'min:0', 'max:300', 'required_if:estado,finalizado'],
            'puntos_visitante' => ['nullable', 'integer', 'min:0', 'max:300', 'required_if:estado,finalizado'],
            'notas' => ['nullable', 'string', 'max:500'],
        ];
    }

    private function messages(): array
    {
        return [
            'equipo_visitante_id.different' => 'El equipo visitante debe ser diferente al equipo local.',
        ];
    }
}
