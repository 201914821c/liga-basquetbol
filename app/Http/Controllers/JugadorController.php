<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Jugador;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JugadorController extends Controller
{
    public function index(Request $request)
    {
        $equipos = Equipo::orderBy('nombre')->get();

        $query = Jugador::with('equipo');

        if ($request->filled('equipo_id')) {
            $query->where('equipo_id', $request->integer('equipo_id'));
        }

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($sub) use ($buscar) {
                $sub->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('apellido', 'like', "%{$buscar}%");
            });
        }

        $jugadores = $query->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('jugadores.index', compact('jugadores', 'equipos'));
    }

    public function create(Request $request)
    {
        $equipos = Equipo::orderBy('nombre')->get();

        return view('jugadores.create', [
            'equipos' => $equipos,
            'equipoSeleccionado' => $request->integer('equipo_id'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules($request));

        $data['activo'] = $request->boolean('activo');

        $jugador = Jugador::create($data);

        return redirect()->route('equipos.show', $jugador->equipo_id)
            ->with('success', 'El jugador fue registrado correctamente.');
    }

    public function show(Jugador $jugador)
    {
        $jugador->load('equipo');

        return view('jugadores.show', compact('jugador'));
    }

    public function edit(Jugador $jugador)
    {
        $equipos = Equipo::orderBy('nombre')->get();

        return view('jugadores.edit', compact('jugador', 'equipos'));
    }

    public function update(Request $request, Jugador $jugador)
    {
        $data = $request->validate($this->rules($request, $jugador));

        $data['activo'] = $request->boolean('activo');

        $jugador->update($data);

        return redirect()->route('equipos.show', $jugador->equipo_id)
            ->with('success', 'El jugador fue actualizado correctamente.');
    }

    public function destroy(Jugador $jugador)
    {
        $equipoId = $jugador->equipo_id;
        $jugador->delete();

        return redirect()->route('equipos.show', $equipoId)
            ->with('success', 'El jugador fue eliminado correctamente.');
    }

    private function rules(Request $request, ?Jugador $jugador = null): array
    {
        return [
            'equipo_id' => ['required', 'integer', 'exists:equipos,id'],
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'dorsal' => [
                'required',
                'integer',
                'min:0',
                'max:99',
                Rule::unique('jugadores', 'dorsal')
                    ->where(fn ($query) => $query->where('equipo_id', $request->integer('equipo_id')))
                    ->ignore($jugador?->id),
            ],
            'posicion' => ['required', Rule::in(['Base', 'Escolta', 'Alero', 'Ala-Pívot', 'Pívot'])],
            'altura' => ['nullable', 'numeric', 'min:1', 'max:2.5'],
            'fecha_nacimiento' => ['nullable', 'date', 'before:today'],
            'activo' => ['sometimes', 'boolean'],
        ];
    }
}
