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
        $branches = ['Distribucion', 'Galpon', 'Hiper Suraki', '2kNR', 'Lacteos', 'Surakarne Americas'];
        foreach ($branches as $name) {
            DB::table('branches')->insertOrIgnore([
                'name' => $name,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ─── Departamentos ─────────────────────────────────────────
        $departments = ['Sistemas', 'Tesoreria', 'Compras', 'Liquidacion', 'Ventas', 'Recursos Humanos'];
        foreach ($departments as $name) {
            DB::table('departments')->insertOrIgnore([
                'name' => $name,
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
            'role' => 'admin',
            'department_id' => 1, // Sistemas
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ─── Equipos de ejemplo ────────────────────────────────────
        $devices = [
            ['name' => 'Dell Latitude 7430', 'specs' => 'i7-1265U / 16GB / 512GB SSD', 'type' => 'Laptop', 'serial_number' => 'SN-5CD1234ABC', 'branch_id' => 1, 'department_id' => 1, 'status' => 'Activo'],
            ['name' => 'HP ProDesk 600 G9', 'specs' => 'i5-13500 / 32GB / 1TB NVMe', 'type' => 'Desktop', 'serial_number' => 'SN-CZC5678XYZ', 'branch_id' => 1, 'department_id' => 2, 'status' => 'Activo'],
            ['name' => 'Dell PowerEdge R750', 'specs' => '2x Xeon Gold / 256GB / 8x 2TB', 'type' => 'Servidor', 'serial_number' => 'SN-SRV2024001', 'branch_id' => 2, 'department_id' => 1, 'status' => 'Activo'],
            ['name' => 'Lenovo ThinkPad T14', 'specs' => 'i5-1245U / 16GB / 256GB SSD', 'type' => 'Laptop', 'serial_number' => 'SN-PF1AB2CD34', 'branch_id' => 3, 'department_id' => null, 'status' => 'En reparacion'],
            ['name' => 'Cisco Catalyst 9300', 'specs' => '48 puertos / PoE+ / 10Gb uplink', 'type' => 'Red', 'serial_number' => 'SN-FOC9876WXY', 'branch_id' => 2, 'department_id' => 1, 'status' => 'Activo'],
            ['name' => 'MacBook Pro 14 M3', 'specs' => 'M3 Pro / 18GB / 512GB SSD', 'type' => 'Laptop', 'serial_number' => 'SN-C02XYZ1234', 'branch_id' => 4, 'department_id' => null, 'status' => 'De baja'],
        ];

        foreach ($devices as $device) {
            $device['created_at'] = now();
            $device['updated_at'] = now();
            DB::table('devices')->insertOrIgnore($device);
        }
    }
}
