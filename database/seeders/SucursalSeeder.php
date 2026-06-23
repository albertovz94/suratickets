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
        $sucursales = ['Andinka', 'Kikana', 'Nabilka', 'distribucion', 'Galpon', 'Hiper Suraki', '2kNR', 'Lacteos', 'Surakarne americas'];
        foreach ($sucursales as $sucursal) {
            \App\Models\Sucursal::firstOrCreate(['nombre' => $sucursal]);
        }
    }
}
