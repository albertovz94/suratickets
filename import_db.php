<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$filePath = __DIR__.'/jeralth/suraki_helpdesk_export.sql';
if (!file_exists($filePath)) {
    die("Error: SQL file not found at $filePath\n");
}

$sql = file_get_contents($filePath);

// Detect UTF-16LE BOM and convert to UTF-8
if (substr($sql, 0, 2) === "\xff\xfe") {
    $sql = mb_convert_encoding(substr($sql, 2), 'UTF-8', 'UTF-16LE');
} elseif (substr($sql, 0, 2) === "\xfe\xff") {
    $sql = mb_convert_encoding(substr($sql, 2), 'UTF-8', 'UTF-16BE');
}

try {
    Illuminate\Support\Facades\DB::unprepared($sql);
    echo "Database imported successfully.\n";
} catch (\Exception $e) {
    echo "Error importing database: " . $e->getMessage() . "\n";
}
