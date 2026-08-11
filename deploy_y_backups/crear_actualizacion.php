<?php
$zipPath = "actualizacion_helpdesk.zip";
if (file_exists($zipPath)) unlink($zipPath);
$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
    $filesToZip = [
        "app/Http/Middleware/AddContentSecurityPolicyHeaders.php",
        "app/Livewire/Layout/NotificationBell.php",
        "resources/views/livewire/tickets/ticket-detail.blade.php",
        "resources/views/livewire/layout/notification-bell.blade.php",
        "resources/views/layouts/app.blade.php"
    ];
    foreach ($filesToZip as $file) {
        if (file_exists($file)) {
            $zip->addFile($file, $file);
            echo "Añadido: $file\n";
        } else {
            echo "Falta: $file\n";
        }
    }
    $zip->close();
    echo "Actualización creada en $zipPath\n";
} else {
    echo "Error al crear ZIP";
}
?>