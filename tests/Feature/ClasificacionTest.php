<?php

namespace Tests\Feature;

use App\Models\Equipo;
use App\Models\Partido;
use App\Models\User;
use App\Services\ClasificacionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClasificacionTest extends TestCase
{
    use RefreshDatabase;

    public function test_standings_are_calculated_from_finished_matches(): void
    {
        $a = Equipo::create(['nombre' => 'Tigres']);
        $b = Equipo::create(['nombre' => 'Águilas']);
        $c = Equipo::create(['nombre' => 'Lobos']);

        Partido::create([
            'equipo_local_id' => $a->id,
            'equipo_visitante_id' => $b->id,
            'fecha' => '2026-11-01 18:00:00',
            'estado' => 'finalizado',
            'puntos_local' => 88,
            'puntos_visitante' => 75,
        ]);

        Partido::create([
            'equipo_local_id' => $b->id,
            'equipo_visitante_id' => $c->id,
            'fecha' => '2026-11-02 18:00:00',
            'estado' => 'finalizado',
            'puntos_local' => 90,
            'puntos_visitante' => 80,
        ]);

        $tabla = (new ClasificacionService)->generar();

        $this->assertSame($b->id, $tabla[0]['equipo']->id);
        $this->assertSame(3, $tabla[0]['pts']);
        $this->assertSame(1, $tabla[0]['pg']);
        $this->assertSame(1, $tabla[0]['pp']);
        $this->assertSame(-3, $tabla[0]['dif']);

        $this->assertSame($a->id, $tabla[1]['equipo']->id);
        $this->assertSame(2, $tabla[1]['pts']);
        $this->assertSame(13, $tabla[1]['dif']);

        $this->assertSame($c->id, $tabla[2]['equipo']->id);
        $this->assertSame(1, $tabla[2]['pts']);
    }

    public function test_scheduled_matches_do_not_affect_standings(): void
    {
        $a = Equipo::create(['nombre' => 'Tigres']);
        $b = Equipo::create(['nombre' => 'Águilas']);

        Partido::create([
            'equipo_local_id' => $a->id,
            'equipo_visitante_id' => $b->id,
            'fecha' => '2026-12-01 18:00:00',
            'estado' => 'programado',
        ]);

        $tabla = (new ClasificacionService)->generar();

        $this->assertSame(0, $tabla[0]['pj']);
        $this->assertSame(0, $tabla[0]['pts']);
    }

    public function test_authenticated_users_can_see_statistics(): void
    {
        $user = User::factory()->create();
        Equipo::create(['nombre' => 'Tigres']);

        $this->actingAs($user)->get('/estadisticas')
            ->assertOk()
            ->assertSee('Tabla de posiciones')
            ->assertSee('Tigres');
    }
}
