<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FilesystemIterator;

class PackageProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:empaquetar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Empaqueta el proyecto en un archivo ZIP listo para subir a producción (cPanel)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Limpiando cachés para producción...');
        $this->call('optimize:clear');

        $zipPath = base_path('suraki_helpdesk_produccion.zip');
        
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        $this->info("Creando archivo ZIP en: {$zipPath}");

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            $this->error('No se pudo crear el archivo ZIP.');
            return 1;
        }

        $rootPath = base_path();
        
        // Carpetas y archivos a ignorar para producción
        $excludes = [
            '.git',
            'node_modules',
            'tests',
            '.env', // Nunca subir el .env local a producción
            'storage/logs',
            'storage/framework/cache',
            'storage/framework/views',
            'storage/framework/sessions',
            'suraki_helpdesk_produccion.zip'
        ];

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $count = 0;
        foreach ($files as $name => $file) {
            $relativePath = str_replace($rootPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $relativePath = str_replace('\\', '/', $relativePath);

            $skip = false;
            foreach ($excludes as $exclude) {
                if (str_starts_with($relativePath, $exclude)) {
                    $skip = true;
                    break;
                }
            }

            if ($skip) {
                continue;
            }

            if (!$file->isDir()) {
                $zip->addFile($file->getPathname(), $relativePath);
                $count++;
            } else {
                $zip->addEmptyDir($relativePath);
            }
        }

        $zip->close();

        // Re-crear directorios vacíos necesarios de Laravel en storage
        $zip = new ZipArchive();
        if ($zip->open($zipPath) === true) {
            $zip->addEmptyDir('storage/logs');
            $zip->addEmptyDir('storage/framework/cache/data');
            $zip->addEmptyDir('storage/framework/views');
            $zip->addEmptyDir('storage/framework/sessions');
            $zip->close();
        }

        $this->info("¡Empaquetado completado con éxito! Se comprimieron {$count} archivos.");
        $this->info("Archivo generado y listo para subir: {$zipPath}");
        
        return 0;
    }
}
