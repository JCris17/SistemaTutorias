<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Crear roles si no existen
        Role::firstOrCreate(['name' => 'Coordinador']);
        Role::firstOrCreate(['name' => 'Tutor']);
        Role::firstOrCreate(['name' => 'Estudiante']);

        // Asignar rol al primer usuario
        $user = User::find(1);
        if ($user) {
            $user->assignRole('Coordinador');
        }
    }
}
