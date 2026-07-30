<?php

namespace App\Services;

use ZipArchive;
use Illuminate\Support\Facades\File;

class SafeZipExtractor
{
    /**
     * Realiza un respaldo del código actual antes de actualizar
     */
    public static function backupCurrentCode($prefix = 'auto_backup_before_deploy')
    {
        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $zipName = $prefix . '_' . date('Y_m_d_His') . '.zip';
        $zipPath = $backupDir . '/' . $zipName;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \Exception("No se pudo crear el archivo zip de respaldo.");
        }

        $foldersToBackup = ['app', 'routes', 'resources', 'config', 'database', 'public'];

        foreach ($foldersToBackup as $folder) {
            $folderPath = base_path($folder);
            if (!File::exists($folderPath)) {
                continue;
            }

            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($folderPath, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen(base_path()) + 1);
                    $relativePath = str_replace('\\', '/', $relativePath);
                    
                    if (strpos($relativePath, 'storage/') === 0 || strpos($relativePath, 'node_modules/') === 0 || strpos($relativePath, 'vendor/') === 0) {
                        continue;
                    }

                    $zip->addFile($filePath, $relativePath);
                }
            }
        }

        $zip->close();
        return $zipPath;
    }

    /**
     * Extrae un archivo ZIP de actualización sobre la raíz
     */
    public static function extract($zipFilePath)
    {
        if (!class_exists(ZipArchive::class)) {
            throw new \Exception("La extensión PHP ZipArchive no está habilitada en el servidor.");
        }

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath) !== true) {
            throw new \Exception("No se pudo abrir el archivo ZIP de actualización.");
        }

        $isCpanel = File::exists(base_path('public_html'));
        $filesExtracted = [];
        $filesSkipped = [];

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            $normalizedName = str_replace('\\', '/', $filename);

            // Proteger .env por seguridad
            if (basename($normalizedName) === '.env' || $normalizedName === '.env') {
                $filesSkipped[] = $filename;
                continue;
            }

            if (substr($normalizedName, -1) === '/') {
                continue;
            }

            $targetPathName = $normalizedName;
            if ($isCpanel && strpos($normalizedName, 'public/') === 0) {
                $targetPathName = 'public_html/' . substr($normalizedName, 7);
            }

            $destination = base_path($targetPathName);
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true);
            }

            $content = $zip->getFromIndex($i);
            if ($content !== false) {
                File::put($destination, $content);
                $filesExtracted[] = $targetPathName;
            }
        }

        $zip->close();

        // Reset de OPcache de PHP si está habilitado en el servidor (Nginx/Apache)
        if (function_exists('opcache_reset')) {
            @opcache_reset();
        }

        // Limpiar archivos de vista compilados manualmente en storage
        $viewsPath = storage_path('framework/views');
        if (File::exists($viewsPath)) {
            $files = File::files($viewsPath);
            foreach ($files as $f) {
                if ($f->getFilename() !== '.gitignore') {
                    @File::delete($f->getRealPath());
                }
            }
        }

        return [
            'extracted_count' => count($filesExtracted),
            'skipped_count' => count($filesSkipped),
        ];
    }
}
