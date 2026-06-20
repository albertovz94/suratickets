<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Equipo;

Equipo::truncate();

$equipos = [
    [
        'name' => 'Dell Latitude 7430',
        'specs' => 'i7-1265U / 16GB / 512GB SSD',
        'type' => 'Laptop',
        'serial_number' => 'SN: 5CD1234ABC',
        'sucursal' => 'Sede Principal',
        'departamento' => 'Piso 2 - Oficina 205',
        'assigned_to_name' => 'Carlos Mendoza',
        'status' => 'Activo',
    ],
    [
        'name' => 'HP ProDesk 600 G9',
        'specs' => 'i5-13500 / 32GB / 1TB NVMe',
        'type' => 'Desktop',
        'serial_number' => 'SN: CZC5678XYZ',
        'sucursal' => 'Sede Principal',
        'departamento' => 'Piso 1 - Oficina 103',
        'assigned_to_name' => 'Maria Garcia',
        'status' => 'Activo',
    ],
    [
        'name' => 'Dell PowerEdge R750',
        'specs' => '2x Xeon Gold / 256GB / 8x 2TB',
        'type' => 'Servidor',
        'serial_number' => 'SN: SRV-2024-001',
        'sucursal' => 'Data Center',
        'departamento' => 'Rack A3',
        'assigned_to_name' => 'Infraestructura',
        'status' => 'Activo',
    ],
    [
        'name' => 'Lenovo ThinkPad T14',
        'specs' => 'i5-1245U / 16GB / 256GB SSD',
        'type' => 'Laptop',
        'serial_number' => 'SN: PF1AB2CD34',
        'sucursal' => 'Sede Norte',
        'departamento' => 'Taller de Reparacion',
        'assigned_to_name' => '--',
        'status' => 'En reparacion',
    ],
    [
        'name' => 'Cisco Catalyst 9300',
        'specs' => '48 puertos / PoE+ / 10Gb uplink',
        'type' => 'Red',
        'serial_number' => 'SN: FOC9876WXYZ',
        'sucursal' => 'Data Center',
        'departamento' => 'Rack B1',
        'assigned_to_name' => 'Redes',
        'status' => 'Activo',
    ],
    [
        'name' => 'MacBook Pro 14 M3',
        'specs' => 'M3 Pro / 18GB / 512GB SSD',
        'type' => 'Laptop',
        'serial_number' => 'SN: C02XYZ12345',
        'sucursal' => 'Almacen Central',
        'departamento' => 'Almacen IT',
        'assigned_to_name' => '--',
        'status' => 'De baja',
    ],
];

foreach ($equipos as $equipo) {
    Equipo::create($equipo);
}

echo "Equipos seeded successfully.\n";
