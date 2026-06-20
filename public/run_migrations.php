<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$kernel->call('migrate:fresh', ['--seed' => true, '--force' => true]);
echo "<pre>";
echo "Base de datos migrada y rellenada correctamente con datos de prueba.\n\n";
echo "Las migraciones ahora están consolidadas en 7 archivos en lugar de 13.\n\n";
echo $kernel->output();
echo "</pre>";
