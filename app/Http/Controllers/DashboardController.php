<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Partido;

class DashboardController extends Controller
{
    public function index()
    {
        $totales = [
            'equipos' => Equipo::count(),
            'jugadores' => Jugador::count(),
            'partidos' => Partido::count(),
            'finalizados' => Partido::where('estado', 'finalizado')->count(),
        ];

        $proximoPartido = Partido::with(['equipoLocal', 'equipoVisitante'])
            ->where('estado', 'programado')
            ->orderBy('fecha')
            ->first();

        return view('dashboard', compact('totales', 'proximoPartido'));
    }
}
