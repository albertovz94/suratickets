<?php
// safe_deploy.php - Panel de Emergencia y Recuperación Autónomo de Suraki HelpDesk
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseDir = realpath(__DIR__ . '/..');

// Clave de acceso de emergencia
$secretToken = 'SurakiSecreto2026';
$envPath = $baseDir . '/.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    if (preg_match('/^APP_KEY=(.*)$/m', $envContent, $matches)) {
        $secretToken = trim($matches[1], "\"' \r\n");
    }
}

// Autenticación de sesión
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $pass = $_POST['password'] ?? '';
    if ($pass === $secretToken || $pass === 'SurakiSecreto2026') {
        $_SESSION['authenticated_deploy_suraki'] = true;
        header('Location: safe_deploy.php');
        exit;
    } else {
        $error = "Clave de emergencia incorrecta.";
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['authenticated_deploy_suraki']);
    header('Location: safe_deploy.php');
    exit;
}

$authenticated = $_SESSION['authenticated_deploy_suraki'] ?? false;

// Si no está autenticado, formulario de acceso
if (!$authenticated) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recuperación de Emergencia - Suraki HelpDesk</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-slate-900 text-slate-100 flex items-center justify-center min-h-screen p-4">
        <div class="max-w-md w-full bg-slate-800/80 backdrop-blur-xl border border-slate-700 rounded-3xl p-8 shadow-2xl text-center">
            <div class="w-14 h-14 bg-rose-500/10 border border-rose-500/20 text-rose-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h1 class="text-2xl font-bold text-white mb-1">Recuperación de Emergencia</h1>
            <p class="text-sm text-slate-400 mb-6">Acceso exclusivo de administración en caso de fallos del sistema.</p>

            <?php if (isset($error)): ?>
                <div class="mb-4 p-3 bg-rose-500/20 border border-rose-500/30 text-rose-300 rounded-xl text-xs">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="login">
                <div>
                    <input type="password" name="password" placeholder="Ingresa clave APP_KEY o SurakiSecreto2026" required class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-rose-500 transition-colors">
                </div>
                <button type="submit" class="w-full py-3 bg-rose-600 hover:bg-rose-500 text-white font-bold text-sm rounded-xl transition-colors shadow-lg shadow-rose-600/30">
                    Ingresar al Panel de Emergencia
                </button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// LÓGICA DE ACCIONES DE EMERGENCIA
$message = '';
$messageType = 'success';

// Helper extracción ZIP independiente
function safeExtractZip($zipPath, $baseDir) {
    if (!class_exists('ZipArchive')) {
        throw new Exception("Extensión ZipArchive no disponible.");
    }
    $zip = new ZipArchive();
    if ($zip->open($zipPath) !== true) {
        throw new Exception("No se pudo abrir el archivo ZIP.");
    }

    $extracted = 0;
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $filename = $zip->getNameIndex($i);
        $normalized = str_replace('\\', '/', $filename);

        if (basename($normalized) === '.env' || $normalized === '.env') continue;
        if (substr($normalized, -1) === '/') continue;

        $dest = $baseDir . '/' . $normalized;
        $dir = dirname($dest);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $content = $zip->getFromIndex($i);
        if ($content !== false) {
            file_put_contents($dest, $content);
            $extracted++;

            if (strpos($normalized, 'public/') === 0) {
                $alt = $baseDir . '/public_html/' . substr($normalized, 7);
                $altDir = dirname($alt);
                if (!is_dir($altDir)) mkdir($altDir, 0755, true);
                file_put_contents($alt, $content);
            } elseif (strpos($normalized, 'public_html/') === 0) {
                $alt = $baseDir . '/public/' . substr($normalized, 12);
                $altDir = dirname($alt);
                if (!is_dir($altDir)) mkdir($altDir, 0755, true);
                file_put_contents($alt, $content);
            }
        }
    }
    $zip->close();
    return $extracted;
}

// Helper Limpieza Caché
function clearCachesManually($baseDir) {
    $bootstrapCache = $baseDir . '/bootstrap/cache';
    if (is_dir($bootstrapCache)) {
        $files = glob($bootstrapCache . '/*.php');
        foreach ($files as $f) @unlink($f);
    }
    $storageViews = $baseDir . '/storage/framework/views';
    if (is_dir($storageViews)) {
        $files = glob($storageViews . '/*.php');
        foreach ($files as $f) @unlink($f);
    }
}

// Acción: Restaurar Respaldo
if (isset($_POST['action']) && $_POST['action'] === 'restore') {
    $filename = basename($_POST['filename'] ?? '');
    $zipPath = $baseDir . '/storage/app/backups/' . $filename;
    if (!file_exists($zipPath)) {
        $zipPath = $baseDir . '/' . $filename;
    }

    if (file_exists($zipPath)) {
        try {
            $count = safeExtractZip($zipPath, $baseDir);
            clearCachesManually($baseDir);
            $message = "¡Sistema restaurado con éxito desde '{$filename}' ({$count} archivos restaurados)!";
        } catch (Exception $e) {
            $message = "Error al restaurar: " . $e->getMessage();
            $messageType = 'error';
        }
    } else {
        $message = "Archivo de respaldo no encontrado.";
        $messageType = 'error';
    }
}

// Acción: Subir nuevo ZIP de emergencia
if (isset($_POST['action']) && $_POST['action'] === 'upload_zip' && isset($_FILES['zip_file'])) {
    if ($_FILES['zip_file']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['zip_file']['tmp_name'];
        try {
            $count = safeExtractZip($tmpName, $baseDir);
            clearCachesManually($baseDir);
            $message = "¡Paquete de emergencia instalado con éxito ({$count} archivos actualizados)!";
        } catch (Exception $e) {
            $message = "Error al extraer paquete: " . $e->getMessage();
            $messageType = 'error';
        }
    } else {
        $message = "Error al subir el archivo ZIP.";
        $messageType = 'error';
    }
}

// Leer respaldos disponibles
$backups = [];
$backupDir = $baseDir . '/storage/app/backups';
if (is_dir($backupDir)) {
    $files = scandir($backupDir);
    foreach ($files as $f) {
        if (pathinfo($f, PATHINFO_EXTENSION) === 'zip') {
            $full = $backupDir . '/' . $f;
            $backups[] = [
                'filename' => $f,
                'size' => round(filesize($full) / 1024 / 1024, 2) . ' MB',
                'date' => date('Y-m-d H:i:s', filemtime($full)),
                'mtime' => filemtime($full)
            ];
        }
    }
    usort($backups, fn($a, $b) => $b['mtime'] - $a['mtime']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Emergencia Autónomo - Suraki HelpDesk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen p-6 font-sans">
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-slate-800/80 border border-slate-700 rounded-3xl p-6 flex flex-wrap items-center justify-between gap-4 shadow-xl">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-rose-500/20 text-rose-500 rounded-2xl border border-rose-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white">Panel de Rescate e Instalación de Emergencia</h1>
                    <p class="text-xs text-slate-400">Herramienta independiente fuera de Laravel para restaurar el sistema si la web cae.</p>
                </div>
            </div>
            <a href="?action=logout" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-200 text-xs font-bold rounded-xl transition-colors">
                Cerrar Sesión
            </a>
        </div>

        <?php if ($message): ?>
            <div class="p-4 <?= $messageType === 'success' ? 'bg-emerald-500/20 border-emerald-500/30 text-emerald-300' : 'bg-rose-500/20 border-rose-500/30 text-rose-300' ?> border rounded-2xl text-sm font-medium">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Opción 1: Subida Directa de ZIP de Emergencia -->
            <div class="bg-slate-800/80 border border-slate-700 rounded-3xl p-6 shadow-xl flex flex-col justify-between">
                <div>
                    <h2 class="text-base font-bold text-white mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Instalar ZIP de Emergencia
                    </h2>
                    <p class="text-xs text-slate-400 mb-6">Sube y fuerza la extracción de <code>actualizacion_suraki_helpdesk.zip</code> para reparar el sistema.</p>

                    <form method="POST" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="action" value="upload_zip">
                        <div>
                            <input type="file" name="zip_file" accept=".zip" required class="block w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-700 file:text-white hover:file:bg-slate-600 cursor-pointer">
                        </div>
                        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs rounded-xl transition-colors shadow-lg shadow-indigo-600/30">
                            Extraer e Instalar ZIP Ahora
                        </button>
                    </form>
                </div>
            </div>

            <!-- Opción 2: Puntos de Restauración (Backups) -->
            <div class="bg-slate-800/80 border border-slate-700 rounded-3xl p-6 shadow-xl flex flex-col justify-between">
                <div>
                    <h2 class="text-base font-bold text-white mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Restaurar Punto de Respaldo
                    </h2>
                    <p class="text-xs text-slate-400 mb-4">Selecciona un respaldo anterior para regresar la aplicación a un estado estable.</p>

                    <div class="space-y-3 max-h-[260px] overflow-y-auto pr-1">
                        <?php if (empty($backups)): ?>
                            <div class="p-4 border border-dashed border-slate-700 text-center text-xs text-slate-500 rounded-xl">
                                No se encontraron archivos de respaldo en el servidor.
                            </div>
                        <?php else: ?>
                            <?php foreach ($backups as $bk): ?>
                                <form method="POST" class="p-3 bg-slate-900/60 border border-slate-700/60 rounded-xl flex items-center justify-between gap-3 text-xs">
                                    <input type="hidden" name="action" value="restore">
                                    <input type="hidden" name="filename" value="<?= htmlspecialchars($bk['filename']) ?>">
                                    <div class="min-w-0 flex-1">
                                        <p class="font-bold text-slate-200 truncate" title="<?= htmlspecialchars($bk['filename']) ?>"><?= htmlspecialchars($bk['filename']) ?></p>
                                        <p class="text-slate-500 text-[11px]"><?= $bk['date'] ?> &bull; <?= $bk['size'] ?></p>
                                    </div>
                                    <button type="submit" onclick="return confirm('¿Restaurar sistema a <?= htmlspecialchars($bk['filename']) ?>?')" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-lg transition-colors whitespace-nowrap">
                                        Restaurar
                                    </button>
                                </form>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
