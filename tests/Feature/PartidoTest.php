<?php

namespace Tests\Feature;

use App\Models\Equipo;
use App\Models\Partido;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartidoTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_matches(): void
    {
        $this->get('/partidos')->assertRedirect('/login');
    }

    public function test_authenticated_users_can_create_matches(): void
    {
        $user = User::factory()->create();
        $local = Equipo::create(['nombre' => 'Tigres']);
        $visitante = Equipo::create(['nombre' => 'Águilas']);

        $response = $this->actingAs($user)->post('/partidos', [
            'equipo_local_id' => $local->id,
            'equipo_visitante_id' => $visitante->id,
            'fecha' => '2026-11-10T18:00',
            'lugar' => 'Coliseo Central',
            'estado' => 'programado',
        ]);

        $partido = Partido::first();

        $response->assertRedirect('/partidos/'.$partido->id);
        $this->assertDatabaseHas('partidos', [
            'equipo_local_id' => $local->id,
            'equipo_visitante_id' => $visitante->id,
            'estado' => 'programado',
        ]);
    }

    public function test_a_team_cannot_play_against_itself(): void
    {
        $user = User::factory()->create();
        $equipo = Equipo::create(['nombre' => 'Tigres']);

        $this->actingAs($user)->post('/partidos', [
            'equipo_local_id' => $equipo->id,
            'equipo_visitante_id' => $equipo->id,
            'fecha' => '2026-11-10T18:00',
            'estado' => 'programado',
        ])->assertSessionHasErrors('equipo_visitante_id');
    }

    public function test_authenticated_users_can_register_a_result(): void
    {
        $user = User::factory()->create();
        $local = Equipo::create(['nombre' => 'Tigres']);
        $visitante = Equipo::create(['nombre' => 'Águilas']);
        $partido = Partido::create([
            'equipo_local_id' => $local->id,
            'equipo_visitante_id' => $visitante->id,
            'fecha' => '2026-11-10 18:00:00',
            'estado' => 'programado',
        ]);

        $response = $this->actingAs($user)->patch('/partidos/'.$partido->id.'/resultado', [
            'puntos_local' => 88,
            'puntos_visitante' => 75,
        ]);

        $response->assertRedirect('/partidos/'.$partido->id);
        $this->assertDatabaseHas('partidos', [
            'id' => $partido->id,
            'estado' => 'finalizado',
            'puntos_local' => 88,
            'puntos_visitante' => 75,
        ]);
    }

    public function test_result_cannot_be_registered_without_scores(): void
    {
        $user = User::factory()->create();
        $local = Equipo::create(['nombre' => 'Tigres']);
        $visitante = Equipo::create(['nombre' => 'Águilas']);
        $partido = Partido::create([
            'equipo_local_id' => $local->id,
            'equipo_visitante_id' => $visitante->id,
            'fecha' => '2026-11-10 18:00:00',
            'estado' => 'programado',
        ]);

        $this->actingAs($user)->patch('/partidos/'.$partido->id.'/resultado', [
            'puntos_local' => '',
            'puntos_visitante' => '',
        ])->assertSessionHasErrors(['puntos_local', 'puntos_visitante']);
    }
}
