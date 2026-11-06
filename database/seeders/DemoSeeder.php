<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Partido;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $equipos = [
            ['nombre' => 'Tigres de Lima', 'ciudad' => 'Lima', 'entrenador' => 'Carlos Ramírez', 'anio_fundacion' => 2005],
            ['nombre' => 'Águilas del Sur', 'ciudad' => 'Arequipa', 'entrenador' => 'Marco Díaz', 'anio_fundacion' => 2010],
            ['nombre' => 'Lobos de Trujillo', 'ciudad' => 'Trujillo', 'entrenador' => 'Jorge Salas', 'anio_fundacion' => 2008],
            ['nombre' => 'Halcones de Cusco', 'ciudad' => 'Cusco', 'entrenador' => 'Percy Quispe', 'anio_fundacion' => 2012],
        ];

        $equiposCreados = [];

        foreach ($equipos as $data) {
            $equiposCreados[$data['nombre']] = Equipo::updateOrCreate(
                ['nombre' => $data['nombre']],
                $data
            );
        }

        $jugadores = [
            'Tigres de Lima' => [
                ['nombre' => 'Diego', 'apellido' => 'Rojas', 'dorsal' => 4, 'posicion' => 'Base', 'altura' => 1.80],
                ['nombre' => 'Luis', 'apellido' => 'Fernández', 'dorsal' => 7, 'posicion' => 'Escolta', 'altura' => 1.88],
                ['nombre' => 'Andrés', 'apellido' => 'Vargas', 'dorsal' => 10, 'posicion' => 'Alero', 'altura' => 1.95],
                ['nombre' => 'Jorge', 'apellido' => 'Medina', 'dorsal' => 15, 'posicion' => 'Ala-Pívot', 'altura' => 2.01],
                ['nombre' => 'Raúl', 'apellido' => 'Castro', 'dorsal' => 21, 'posicion' => 'Pívot', 'altura' => 2.08],
            ],
            'Águilas del Sur' => [
                ['nombre' => 'Marco', 'apellido' => 'Gutiérrez', 'dorsal' => 3, 'posicion' => 'Base', 'altura' => 1.78],
                ['nombre' => 'Pablo', 'apellido' => 'Núñez', 'dorsal' => 8, 'posicion' => 'Escolta', 'altura' => 1.86],
                ['nombre' => 'Renzo', 'apellido' => 'Salazar', 'dorsal' => 11, 'posicion' => 'Alero', 'altura' => 1.94],
                ['nombre' => 'Iván', 'apellido' => 'Dueñas', 'dorsal' => 14, 'posicion' => 'Ala-Pívot', 'altura' => 2.00],
                ['nombre' => 'Hugo', 'apellido' => 'Paredes', 'dorsal' => 20, 'posicion' => 'Pívot', 'altura' => 2.06],
            ],
            'Lobos de Trujillo' => [
                ['nombre' => 'César', 'apellido' => 'Linares', 'dorsal' => 5, 'posicion' => 'Base', 'altura' => 1.81],
                ['nombre' => 'Alonso', 'apellido' => 'Ríos', 'dorsal' => 9, 'posicion' => 'Escolta', 'altura' => 1.87],
                ['nombre' => 'Miguel', 'apellido' => 'Torres', 'dorsal' => 12, 'posicion' => 'Alero', 'altura' => 1.93],
                ['nombre' => 'Bruno', 'apellido' => 'Cabrera', 'dorsal' => 18, 'posicion' => 'Ala-Pívot', 'altura' => 2.02],
                ['nombre' => 'Sergio', 'apellido' => 'Palacios', 'dorsal' => 23, 'posicion' => 'Pívot', 'altura' => 2.09],
            ],
            'Halcones de Cusco' => [
                ['nombre' => 'Kevin', 'apellido' => 'Huamán', 'dorsal' => 2, 'posicion' => 'Base', 'altura' => 1.77],
                ['nombre' => 'Edgar', 'apellido' => 'Choque', 'dorsal' => 6, 'posicion' => 'Escolta', 'altura' => 1.85],
                ['nombre' => 'Frank', 'apellido' => 'Condori', 'dorsal' => 13, 'posicion' => 'Alero', 'altura' => 1.96],
                ['nombre' => 'Ronald', 'apellido' => 'Mamani', 'dorsal' => 17, 'posicion' => 'Ala-Pívot', 'altura' => 2.03],
                ['nombre' => 'Elmer', 'apellido' => 'Quispe', 'dorsal' => 24, 'posicion' => 'Pívot', 'altura' => 2.07],
            ],
        ];

        foreach ($jugadores as $equipoNombre => $lista) {
            foreach ($lista as $jugador) {
                Jugador::updateOrCreate(
                    [
                        'equipo_id' => $equiposCreados[$equipoNombre]->id,
                        'dorsal' => $jugador['dorsal'],
                    ],
                    $jugador + ['activo' => true]
                );
            }
        }

        if (Partido::query()->exists()) {
            return;
        }

        $partidos = [
            ['Tigres de Lima', 'Águilas del Sur', now()->subDays(12)->setTime(18, 0), 'Coliseo Miguel Grau', 'finalizado', 88, 75],
            ['Lobos de Trujillo', 'Halcones de Cusco', now()->subDays(10)->setTime(19, 30), 'Coliseo Gran Chimú', 'finalizado', 91, 84],
            ['Águilas del Sur', 'Lobos de Trujillo', now()->subDays(7)->setTime(18, 0), 'Coliseo de Arequipa', 'finalizado', 79, 83],
            ['Halcones de Cusco', 'Tigres de Lima', now()->subDays(5)->setTime(20, 0), 'Coliseo Casa de la Juventud', 'finalizado', 70, 95],
            ['Tigres de Lima', 'Lobos de Trujillo', now()->subDays(2)->setTime(19, 0), 'Coliseo Miguel Grau', 'finalizado', 102, 98],
            ['Águilas del Sur', 'Halcones de Cusco', now()->addDays(3)->setTime(18, 30), 'Coliseo de Arequipa', 'programado', null, null],
            ['Tigres de Lima', 'Halcones de Cusco', now()->addDays(5)->setTime(19, 0), 'Coliseo Miguel Grau', 'programado', null, null],
        ];

        foreach ($partidos as [$local, $visitante, $fecha, $lugar, $estado, $puntosLocal, $puntosVisitante]) {
            Partido::create([
                'equipo_local_id' => $equiposCreados[$local]->id,
                'equipo_visitante_id' => $equiposCreados[$visitante]->id,
                'fecha' => Carbon::parse($fecha),
                'lugar' => $lugar,
                'estado' => $estado,
                'puntos_local' => $puntosLocal,
                'puntos_visitante' => $puntosVisitante,
            ]);
        }
    }
}
