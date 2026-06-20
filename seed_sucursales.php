<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

App\Models\Sucursal::insert([
    ['nombre' => 'distribucion'],
    ['nombre' => 'Galpon'],
    ['nombre' => 'Hiper Suraki'],
    ['nombre' => '2kNR'],
    ['nombre' => 'Lacteos'],
    ['nombre' => 'Surakarne americas']
]);

echo "Sucursales añadidas exitosamente.\n";
