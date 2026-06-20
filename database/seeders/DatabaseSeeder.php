<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ─── Sucursales ────────────────────────────────────────────
        $sucursales = ['Distribucion', 'Galpon', 'Hiper Suraki', '2kNR', 'Lacteos', 'Surakarne Americas'];
        foreach ($sucursales as $nombre) {
            DB::table('sucursales')->insertOrIgnore([
                'nombre' => $nombre,
                'activa' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ─── Departamentos ─────────────────────────────────────────
        $departamentos = ['Sistemas', 'Tesoreria', 'Compras', 'Liquidacion', 'Ventas', 'Recursos Humanos'];
        foreach ($departamentos as $nombre) {
            DB::table('departamentos')->insertOrIgnore([
                'nombre' => $nombre,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ─── Usuario Admin por defecto ─────────────────────────────
        DB::table('users')->insertOrIgnore([
            'name' => 'Administrador',
            'email' => 'admin@suraki.com',
            'username' => 'admin_sistemas', // Restore username
            'password' => Hash::make('password'),
            'rol' => 'admin',
            'departamento_id' => 1, // Sistemas
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ─── Equipos de ejemplo ────────────────────────────────────
        $equipos = [
            ['name' => 'Dell Latitude 7430', 'specs' => 'i7-1265U / 16GB / 512GB SSD', 'type' => 'Laptop', 'serial_number' => 'SN-5CD1234ABC', 'sucursal_id' => 1, 'departamento_id' => 1, 'status' => 'Activo'],
            ['name' => 'HP ProDesk 600 G9', 'specs' => 'i5-13500 / 32GB / 1TB NVMe', 'type' => 'Desktop', 'serial_number' => 'SN-CZC5678XYZ', 'sucursal_id' => 1, 'departamento_id' => 2, 'status' => 'Activo'],
            ['name' => 'Dell PowerEdge R750', 'specs' => '2x Xeon Gold / 256GB / 8x 2TB', 'type' => 'Servidor', 'serial_number' => 'SN-SRV2024001', 'sucursal_id' => 2, 'departamento_id' => 1, 'status' => 'Activo'],
            ['name' => 'Lenovo ThinkPad T14', 'specs' => 'i5-1245U / 16GB / 256GB SSD', 'type' => 'Laptop', 'serial_number' => 'SN-PF1AB2CD34', 'sucursal_id' => 3, 'departamento_id' => null, 'status' => 'En reparacion'],
            ['name' => 'Cisco Catalyst 9300', 'specs' => '48 puertos / PoE+ / 10Gb uplink', 'type' => 'Red', 'serial_number' => 'SN-FOC9876WXY', 'sucursal_id' => 2, 'departamento_id' => 1, 'status' => 'Activo'],
            ['name' => 'MacBook Pro 14 M3', 'specs' => 'M3 Pro / 18GB / 512GB SSD', 'type' => 'Laptop', 'serial_number' => 'SN-C02XYZ1234', 'sucursal_id' => 4, 'departamento_id' => null, 'status' => 'De baja'],
        ];

        foreach ($equipos as $equipo) {
            $equipo['created_at'] = now();
            $equipo['updated_at'] = now();
            DB::table('equipos')->insertOrIgnore($equipo);
        }
    }
}
