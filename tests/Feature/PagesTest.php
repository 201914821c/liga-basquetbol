<?php

namespace Tests\Feature;

use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Partido;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_main_pages_render_for_authenticated_users(): void
    {
        $user = User::factory()->create();
        $local = Equipo::create(['nombre' => 'Tigres', 'ciudad' => 'Lima']);
        $visitante = Equipo::create(['nombre' => 'Águilas', 'ciudad' => 'Arequipa']);
        $jugador = Jugador::create([
            'equipo_id' => $local->id,
            'nombre' => 'Diego',
            'apellido' => 'Rojas',
            'dorsal' => 4,
            'posicion' => 'Base',
        ]);
        $partido = Partido::create([
            'equipo_local_id' => $local->id,
            'equipo_visitante_id' => $visitante->id,
            'fecha' => '2026-11-10 18:00:00',
            'estado' => 'programado',
        ]);

        $rutas = [
            '/dashboard',
            '/estadisticas',
            '/equipos',
            '/equipos/create',
            '/equipos/'.$local->id,
            '/equipos/'.$local->id.'/edit',
            '/jugadores',
            '/jugadores/create',
            '/jugadores/'.$jugador->id,
            '/jugadores/'.$jugador->id.'/edit',
            '/partidos',
            '/partidos/create',
            '/partidos/'.$partido->id,
            '/partidos/'.$partido->id.'/edit',
            '/partidos/'.$partido->id.'/resultado',
        ];

        foreach ($rutas as $ruta) {
            $this->actingAs($user)->get($ruta)->assertOk();
        }
    }
}
