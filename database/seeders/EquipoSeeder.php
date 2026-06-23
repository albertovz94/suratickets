<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Equipo;
use App\Models\Sucursal;
use App\Models\Departamento;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Equipo::truncate();

        $equiposData = [
            [
                'name' => 'Dell Latitude 7430',
                'specs' => 'i7-1265U / 16GB / 512GB SSD',
                'type' => 'Laptop',
                'serial_number' => 'SN: 5CD1234ABC',
                'sucursal' => 'Sede Principal',
                'departamento' => 'Piso 2 - Oficina 205',
                'status' => 'Activo',
            ],
            [
                'name' => 'HP ProDesk 600 G9',
                'specs' => 'i5-13500 / 32GB / 1TB NVMe',
                'type' => 'Desktop',
                'serial_number' => 'SN: CZC5678XYZ',
                'sucursal' => 'Sede Principal',
                'departamento' => 'Piso 1 - Oficina 103',
                'status' => 'Activo',
            ],
            [
                'name' => 'Dell PowerEdge R750',
                'specs' => '2x Xeon Gold / 256GB / 8x 2TB',
                'type' => 'Servidor',
                'serial_number' => 'SN: SRV-2024-001',
                'sucursal' => 'Data Center',
                'departamento' => 'Rack A3',
                'status' => 'Activo',
            ],
            [
                'name' => 'Lenovo ThinkPad T14',
                'specs' => 'i5-1245U / 16GB / 256GB SSD',
                'type' => 'Laptop',
                'serial_number' => 'SN: PF1AB2CD34',
                'sucursal' => 'Sede Norte',
                'departamento' => 'Taller de Reparacion',
                'status' => 'En reparacion',
            ],
            [
                'name' => 'Cisco Catalyst 9300',
                'specs' => '48 puertos / PoE+ / 10Gb uplink',
                'type' => 'Red',
                'serial_number' => 'SN: FOC9876WXYZ',
                'sucursal' => 'Data Center',
                'departamento' => 'Rack B1',
                'status' => 'Activo',
            ],
            [
                'name' => 'MacBook Pro 14 M3',
                'specs' => 'M3 Pro / 18GB / 512GB SSD',
                'type' => 'Laptop',
                'serial_number' => 'SN: C02XYZ12345',
                'sucursal' => 'Almacen Central',
                'departamento' => 'Almacen IT',
                'status' => 'De baja',
            ],
        ];

        foreach ($equiposData as $data) {
            $sucursal = Sucursal::firstOrCreate(['nombre' => $data['sucursal']]);
            $departamento = Departamento::firstOrCreate(['nombre' => $data['departamento'], 'sucursal_id' => $sucursal->id]);

            Equipo::create([
                'name' => $data['name'],
                'specs' => $data['specs'],
                'type' => $data['type'],
                'serial_number' => $data['serial_number'],
                'sucursal_id' => $sucursal->id,
                'departamento_id' => $departamento->id,
                'status' => $data['status'],
            ]);
        }
    }
}
