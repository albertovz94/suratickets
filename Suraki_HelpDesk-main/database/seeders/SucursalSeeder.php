<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sucursales = ['Andinka', 'Kikana', 'Nabilka'];
        foreach ($sucursales as $sucursal) {
            \App\Models\Sucursal::create(['nombre' => $sucursal]);
        }
    }
}
