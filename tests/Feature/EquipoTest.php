<?php

namespace Tests\Feature;

use App\Models\Equipo;
use App\Models\Partido;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipoTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_teams(): void
    {
        $this->get('/equipos')->assertRedirect('/login');
    }

    public function test_authenticated_users_can_see_teams(): void
    {
        $user = User::factory()->create();
        $equipo = Equipo::create(['nombre' => 'Tigres', 'ciudad' => 'Lima']);

        $this->actingAs($user)->get('/equipos')
            ->assertOk()
            ->assertSee('Tigres');
    }

    public function test_authenticated_users_can_create_teams(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/equipos', [
            'nombre' => 'Águilas',
            'ciudad' => 'Arequipa',
            'entrenador' => 'Luis Ramos',
            'anio_fundacion' => 2010,
        ]);

        $response->assertRedirect('/equipos');
        $this->assertDatabaseHas('equipos', ['nombre' => 'Águilas']);
    }

    public function test_authenticated_users_can_update_teams(): void
    {
        $user = User::factory()->create();
        $equipo = Equipo::create(['nombre' => 'Tigres']);

        $response = $this->actingAs($user)->put('/equipos/'.$equipo->id, [
            'nombre' => 'Tigres FC',
            'ciudad' => 'Trujillo',
        ]);

        $response->assertRedirect('/equipos');
        $this->assertDatabaseHas('equipos', ['id' => $equipo->id, 'nombre' => 'Tigres FC']);
    }

    public function test_authenticated_users_can_delete_teams(): void
    {
        $user = User::factory()->create();
        $equipo = Equipo::create(['nombre' => 'Tigres']);

        $this->actingAs($user)->delete('/equipos/'.$equipo->id)
            ->assertRedirect('/equipos');

        $this->assertDatabaseMissing('equipos', ['id' => $equipo->id]);
    }

    public function test_team_with_matches_cannot_be_deleted(): void
    {
        $user = User::factory()->create();
        $local = Equipo::create(['nombre' => 'Tigres']);
        $visitante = Equipo::create(['nombre' => 'Águilas']);
        Partido::create([
            'equipo_local_id' => $local->id,
            'equipo_visitante_id' => $visitante->id,
            'fecha' => '2026-11-10 18:00:00',
            'estado' => 'programado',
        ]);

        $this->actingAs($user)->delete('/equipos/'.$local->id)
            ->assertRedirect('/equipos')
            ->assertSessionHas('error');

        $this->assertDatabaseHas('equipos', ['id' => $local->id]);
    }

    public function test_team_name_must_be_unique(): void
    {
        $user = User::factory()->create();
        Equipo::create(['nombre' => 'Tigres']);

        $this->actingAs($user)->post('/equipos', ['nombre' => 'Tigres'])
            ->assertSessionHasErrors('nombre');
    }
}
