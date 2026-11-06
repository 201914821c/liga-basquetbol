<?php

namespace Tests\Feature;

use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JugadorTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_players(): void
    {
        $this->get('/jugadores')->assertRedirect('/login');
    }

    public function test_authenticated_users_can_create_players(): void
    {
        $user = User::factory()->create();
        $equipo = Equipo::create(['nombre' => 'Tigres']);

        $response = $this->actingAs($user)->post('/jugadores', [
            'equipo_id' => $equipo->id,
            'nombre' => 'Carlos',
            'apellido' => 'Mendoza',
            'dorsal' => 10,
            'posicion' => 'Alero',
            'altura' => 1.92,
            'activo' => '1',
        ]);

        $response->assertRedirect('/equipos/'.$equipo->id);
        $this->assertDatabaseHas('jugadores', [
            'equipo_id' => $equipo->id,
            'apellido' => 'Mendoza',
            'dorsal' => 10,
        ]);
    }

    public function test_dorsal_is_unique_per_team(): void
    {
        $user = User::factory()->create();
        $equipo = Equipo::create(['nombre' => 'Tigres']);
        Jugador::create([
            'equipo_id' => $equipo->id,
            'nombre' => 'Carlos',
            'apellido' => 'Mendoza',
            'dorsal' => 10,
            'posicion' => 'Alero',
        ]);

        $this->actingAs($user)->post('/jugadores', [
            'equipo_id' => $equipo->id,
            'nombre' => 'Luis',
            'apellido' => 'Pérez',
            'dorsal' => 10,
            'posicion' => 'Base',
        ])->assertSessionHasErrors('dorsal');
    }

    public function test_same_dorsal_is_allowed_in_different_teams(): void
    {
        $user = User::factory()->create();
        $tigres = Equipo::create(['nombre' => 'Tigres']);
        $aguilas = Equipo::create(['nombre' => 'Águilas']);
        Jugador::create([
            'equipo_id' => $tigres->id,
            'nombre' => 'Carlos',
            'apellido' => 'Mendoza',
            'dorsal' => 10,
            'posicion' => 'Alero',
        ]);

        $this->actingAs($user)->post('/jugadores', [
            'equipo_id' => $aguilas->id,
            'nombre' => 'Luis',
            'apellido' => 'Pérez',
            'dorsal' => 10,
            'posicion' => 'Base',
        ])->assertRedirect('/equipos/'.$aguilas->id);
    }

    public function test_authenticated_users_can_update_players(): void
    {
        $user = User::factory()->create();
        $equipo = Equipo::create(['nombre' => 'Tigres']);
        $jugador = Jugador::create([
            'equipo_id' => $equipo->id,
            'nombre' => 'Carlos',
            'apellido' => 'Mendoza',
            'dorsal' => 10,
            'posicion' => 'Alero',
        ]);

        $this->actingAs($user)->put('/jugadores/'.$jugador->id, [
            'equipo_id' => $equipo->id,
            'nombre' => 'Carlos',
            'apellido' => 'Mendoza',
            'dorsal' => 23,
            'posicion' => 'Pívot',
        ])->assertRedirect('/equipos/'.$equipo->id);

        $this->assertDatabaseHas('jugadores', ['id' => $jugador->id, 'dorsal' => 23]);
    }

    public function test_authenticated_users_can_delete_players(): void
    {
        $user = User::factory()->create();
        $equipo = Equipo::create(['nombre' => 'Tigres']);
        $jugador = Jugador::create([
            'equipo_id' => $equipo->id,
            'nombre' => 'Carlos',
            'apellido' => 'Mendoza',
            'dorsal' => 10,
            'posicion' => 'Alero',
        ]);

        $this->actingAs($user)->delete('/jugadores/'.$jugador->id)
            ->assertRedirect('/equipos/'.$equipo->id);

        $this->assertDatabaseMissing('jugadores', ['id' => $jugador->id]);
    }
}
