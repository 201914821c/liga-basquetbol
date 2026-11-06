<?php

namespace App\Services;

use App\Models\Equipo;
use App\Models\Partido;
use Illuminate\Support\Collection;

class ClasificacionService
{
    /**
     * Genera la tabla de posiciones a partir de los partidos finalizados.
     * Se otorgan 2 puntos por victoria y 1 punto por derrota.
     */
    public function generar(): Collection
    {
        $equipos = Equipo::all();
        $partidos = Partido::where('estado', 'finalizado')->get();

        return $equipos
            ->map(function (Equipo $equipo) use ($partidos) {
                $pj = 0;
                $pg = 0;
                $pp = 0;
                $pf = 0;
                $pc = 0;

                foreach ($partidos as $partido) {
                    if ($partido->equipo_local_id === $equipo->id) {
                        $pj++;
                        $pf += $partido->puntos_local;
                        $pc += $partido->puntos_visitante;
                        $partido->puntos_local > $partido->puntos_visitante ? $pg++ : $pp++;
                    } elseif ($partido->equipo_visitante_id === $equipo->id) {
                        $pj++;
                        $pf += $partido->puntos_visitante;
                        $pc += $partido->puntos_local;
                        $partido->puntos_visitante > $partido->puntos_local ? $pg++ : $pp++;
                    }
                }

                return [
                    'equipo' => $equipo,
                    'pj' => $pj,
                    'pg' => $pg,
                    'pp' => $pp,
                    'pf' => $pf,
                    'pc' => $pc,
                    'dif' => $pf - $pc,
                    'pts' => ($pg * 2) + $pp,
                ];
            })
            ->sort(function (array $a, array $b) {
                return [$b['pts'], $b['dif'], $b['pf']] <=> [$a['pts'], $a['dif'], $a['pf']];
            })
            ->values();
    }
}
