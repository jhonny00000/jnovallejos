<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $administrator = Role::firstOrCreate(
            ['nombre' => 'Administrador'],
            ['descripcion' => 'Acceso completo para administrar el sistema.'],
        );

        Role::firstOrCreate(
            ['nombre' => 'Vendedor'],
            ['descripcion' => 'Acceso operativo para gestionar ventas.'],
        );

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'role_id' => $administrator->id,
                'name' => 'Test User',
                'a_paterno' => 'Administrador',
                'a_materno' => null,
                'ci' => '12345678',
                'password' => 'password',
            ],
        );
    }
}
