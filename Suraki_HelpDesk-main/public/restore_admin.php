<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::firstOrCreate(
    ['username' => 'admin_sistemas'],
    [
        'name' => 'Admin Sistemas',
        'email' => 'admin_sistemas@suraki.com',
        'password' => Hash::make('password'),
        'rol' => 'admin',
        'departamento_id' => 1, // Sistemas
        'email_verified_at' => now(),
    ]
);

echo "Cuenta restaurada exitosamente.<br><br>";
echo "<strong>Usuario/Username:</strong> admin_sistemas<br>";
echo "<strong>Correo:</strong> admin_sistemas@suraki.com<br>";
echo "<strong>Contraseña:</strong> password<br><br>";
echo "<a href='/'>Ir al Login</a>";
