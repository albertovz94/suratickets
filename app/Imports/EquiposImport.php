<?php

namespace App\Imports;

use App\Models\Equipo;
use App\Models\Sucursal;
use App\Models\Departamento;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EquiposImport implements ToCollection, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2; // Omitir la primera fila (encabezados)
    }

    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Verificar que la fila no esté completamente vacía (ej. ID Único o Serial vacío)
            if (!isset($row[0]) && !isset($row[7])) {
                continue;
            }

            // Índices basados en las columnas proporcionadas:
            // 0: ID UNICO
            // 1: TIPO DE ACTIVO
            // 2: UBICACION FUNCIONAL (Departamento)
            // 3: SUCURSAL
            // 4: CONTADOR
            // 5: DESCRIPCION (Specs)
            // 6: MARCA -MODELO (Name)
            // 7: NUMERO DE SERIE
            // 8: FECHA ADQUISICION
            // 9: OPERATIVO
            // 10: REQUIERE MTTO
            // 11: DESIN-CORPORAR
            // 12: FECHA DEL INVENTARIO
            // 13: URL del QR

            $tipo_activo = trim($row[1] ?? 'Otro');
            $departamento_nombre = trim($row[2] ?? 'Sin asignar');
            $sucursal_nombre = trim($row[3] ?? 'Principal');
            $descripcion = trim($row[5] ?? '');
            $marca_modelo = trim($row[6] ?? '');
            $numero_serie = trim($row[7] ?? '');
            $id_unico = trim($row[0] ?? '');
            
            // Valores lógicos
            $operativo = strtoupper(trim($row[9] ?? ''));
            $requiere_mtto = strtoupper(trim($row[10] ?? ''));
            $desincorporar = strtoupper(trim($row[11] ?? ''));

            // Construir valores finales
            $name = $marca_modelo ?: ($descripcion ?: 'Equipo sin nombre');
            if (empty($numero_serie)) {
                $numero_serie = $id_unico ?: 'SN-'.uniqid();
            }

            // Mapeo del Tipo de Equipo a los permitidos (Laptop,Desktop,Servidor,Red,Impresora,Otro)
            $allowedTypes = ['Laptop', 'Desktop', 'Servidor', 'Red', 'Impresora', 'Otro'];
            $mappedType = 'Otro';
            foreach ($allowedTypes as $at) {
                if (stripos($tipo_activo, $at) !== false) {
                    $mappedType = $at;
                    break;
                }
            }

            // Lógica de Estado
            $status = 'Activo';
            if ($desincorporar === 'SI' || $desincorporar === 'X') {
                $status = 'De baja';
            } elseif ($requiere_mtto === 'SI' || $requiere_mtto === 'X') {
                $status = 'En reparacion';
            } elseif ($operativo === 'NO') {
                $status = 'En reparacion';
            }

            // Manejar relaciones
            $sucursal = Sucursal::firstOrCreate(
                ['nombre' => $sucursal_nombre],
                ['activa' => true]
            );

            $departamento = Departamento::firstOrCreate(
                ['nombre' => $departamento_nombre, 'sucursal_id' => $sucursal->id]
            );

            // Crear o Actualizar el Equipo (usamos serial_number como clave)
            Equipo::updateOrCreate(
                ['serial_number' => $numero_serie],
                [
                    'name' => substr($name, 0, 255),
                    'specs' => substr($descripcion, 0, 255),
                    'type' => $mappedType,
                    'sucursal_id' => $sucursal->id,
                    'departamento_id' => $departamento->id,
                    'status' => $status,
                ]
            );
        }
    }
}
