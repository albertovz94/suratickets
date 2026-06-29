<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@suraki.local',
            'username' => 'admin_sistemas',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Usuario Final',
            'email' => 'usuario@suraki.local',
            'username' => 'usuario_caja1',
            'password' => bcrypt('password'),
            'role' => 'usuario',
            'branch_id' => 1,
        ]);
    }
}
