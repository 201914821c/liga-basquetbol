<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Partido;
use App\Services\ClasificacionService;

class EstadisticaController extends Controller
{
    public function index(ClasificacionService $clasificacion)
    {
        $tabla = $clasificacion->generar();

        $totales = [
            'equipos' => Equipo::count(),
            'jugadores' => Jugador::count(),
            'partidos' => Partido::count(),
            'finalizados' => Partido::where('estado', 'finalizado')->count(),
        ];

        $resultadosRecientes = Partido::with(['equipoLocal', 'equipoVisitante'])
            ->where('estado', 'finalizado')
            ->orderByDesc('fecha')
            ->take(5)
            ->get();

        $proximosPartidos = Partido::with(['equipoLocal', 'equipoVisitante'])
            ->where('estado', 'programado')
            ->orderBy('fecha')
            ->take(5)
            ->get();

        return view('estadisticas.index', compact(
            'tabla',
            'totales',
            'resultadosRecientes',
            'proximosPartidos'
        ));
    }
}
