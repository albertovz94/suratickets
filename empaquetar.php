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

    // Añadir backend (app)
    $addFolderToZip(__DIR__ . '/app', 'app');
    
    // Añadir rutas (routes)
    $addFolderToZip(__DIR__ . '/routes', 'routes');
    
    // Añadir vistas (resources/views)
    $addFolderToZip(__DIR__ . '/resources/views', 'resources/views');
    
    // Añadir Frontend compilado (Vite / public)
    // Se mapea a public_html/build por si usas ese formato en tu hosting de producción
    $addFolderToZip(__DIR__ . '/public/build', 'public_html/build');

    $zip->close();
    echo "¡Archivo ZIP '$zipName' creado con éxito!\n";
    echo "Tamaño: " . round(filesize($zipName) / 1024 / 1024, 2) . " MB\n";
} else {
    echo "Falló la creación del archivo ZIP.\n";
}
