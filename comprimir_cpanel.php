<?php
// Empaquetador Zip Multiplataforma (Usa '/' como separador para cPanel)
$directories = [
    'app' => 'C:\\laragon\\www\\suraki_temp_app',
    'vendor_1' => 'C:\\laragon\\www\\suraki_temp_v1',
    'vendor_2' => 'C:\\laragon\\www\\suraki_temp_v2',
    'vendor_3' => 'C:\\laragon\\www\\suraki_temp_v3',
];

foreach ($directories as $name => $path) {
    if (!is_dir($path)) continue;

    $zipPath = "C:\\laragon\\www\\suraki_helpdesk_{$name}.zip";
    if (file_exists($zipPath)) unlink($zipPath);

    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($files as $file) {
            $realPath = $file->getRealPath();
            // str_replace para asegurar formato Unix
            $relativePath = str_replace('\\', '/', str_replace($path . DIRECTORY_SEPARATOR, '', $realPath));
            
            if ($file->isDir()) {
                $zip->addEmptyDir($relativePath);
            } else {
                $zip->addFile($realPath, $relativePath);
            }
        }
        $zip->close();
        echo "Generado: {$zipPath}\n";
    } else {
        echo "Error al crear: {$zipPath}\n";
    }
}
