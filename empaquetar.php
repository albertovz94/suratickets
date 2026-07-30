<?php
// Script sencillo para empaquetar Suraki HelpDesk
$zip = new ZipArchive();
$zipName = 'actualizacion_suraki_helpdesk.zip';

if ($zip->open($zipName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    
    // Función para añadir directorios completos con un prefijo personalizado en el ZIP
    $addFolderToZip = function($folderPath, $zipPrefix) use ($zip) {
        if (!is_dir($folderPath)) return;
        $dir = new RecursiveDirectoryIterator($folderPath, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($dir);

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $realPath = $file->getRealPath();
                $relativePath = substr($realPath, strlen($folderPath) + 1);
                $relativePath = str_replace('\\', '/', $relativePath);
                
                $zipPath = $zipPrefix . '/' . $relativePath;
                $zip->addFile($realPath, $zipPath);
            }
        }
    };

    // 1. Backend (app)
    $addFolderToZip(__DIR__ . '/app', 'app');
    
    // 2. Rutas (routes)
    $addFolderToZip(__DIR__ . '/routes', 'routes');
    
    // 3. Vistas y Resources (resources)
    $addFolderToZip(__DIR__ . '/resources', 'resources');

    // 4. Migraciones de Base de Datos (database/migrations)
    $addFolderToZip(__DIR__ . '/database/migrations', 'database/migrations');
    
    // 5. Frontend compilado Assets (public/build & public_html/build)
    $addFolderToZip(__DIR__ . '/public/build', 'public/build');
    $addFolderToZip(__DIR__ . '/public/build', 'public_html/build');

    // 6. Archivo de Recuperación Autónomo de Emergencia
    if (file_exists(__DIR__ . '/public/safe_deploy.php')) {
        $zip->addFile(__DIR__ . '/public/safe_deploy.php', 'public/safe_deploy.php');
        $zip->addFile(__DIR__ . '/public/safe_deploy.php', 'public_html/safe_deploy.php');
    }

    $zip->close();
    echo "¡Archivo ZIP '$zipName' creado con éxito!\n";
    echo "Tamaño: " . round(filesize($zipName) / 1024 / 1024, 2) . " MB\n";
} else {
    echo "Falló la creación del archivo ZIP.\n";
}
