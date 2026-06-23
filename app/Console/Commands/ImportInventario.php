<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EquiposImport;
use Illuminate\Support\Facades\File;

class ImportInventario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'suraki:import-inventario';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa el archivo Excel de inventario a la base de datos de Equipos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = database_path('imports/INVENTARIO ACTIVOS FIJOS SURAKI 09-06.xlsx');

        if (!File::exists($filePath)) {
            $this->error("El archivo no se encontró en la ruta: {$filePath}");
            return Command::FAILURE;
        }

        $this->info("Iniciando la importación de Equipos desde Excel...");

        try {
            Excel::import(new EquiposImport, $filePath);
            $this->info("¡Importación completada con éxito!");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Hubo un error al importar: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
