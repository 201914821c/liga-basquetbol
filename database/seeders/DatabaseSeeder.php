<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@liga.test'],
            [
                'name' => 'Administrador de la Liga',
                'password' => 'password',
            ]
        );

        $this->call(DemoSeeder::class);
    }
}
