$tempDirApp = "C:\laragon\www\suraki_temp_app"
$tempV1 = "C:\laragon\www\suraki_temp_v1"
$tempV2 = "C:\laragon\www\suraki_temp_v2"
$tempV3 = "C:\laragon\www\suraki_temp_v3"

Write-Host "Limpiando temporales anteriores..."
$temps = @($tempDirApp, $tempV1, $tempV2, $tempV3)
foreach ($t in $temps) { if (Test-Path $t) { Remove-Item -Force -Recurse $t } }

Write-Host "Limpiando caches de Laravel..."
c:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe artisan optimize:clear

New-Item -ItemType Directory -Force -Path $tempDirApp | Out-Null
New-Item -ItemType Directory -Force -Path "$tempV1\vendor" | Out-Null
New-Item -ItemType Directory -Force -Path "$tempV2\vendor" | Out-Null
New-Item -ItemType Directory -Force -Path "$tempV3\vendor" | Out-Null

Write-Host "Copiando archivos ligeros de la APP (ignora vendor, node_modules)..."
robocopy "C:\laragon\www\suraki-helpdesk" $tempDirApp /E /XD .git node_modules tests vendor /XF .env *.zip > $null

Write-Host "Limpiando logs temporales en la APP..."
Remove-Item -Force -Recurse "$tempDirApp\storage\logs\*" -ErrorAction SilentlyContinue
Remove-Item -Force -Recurse "$tempDirApp\storage\framework\cache\data\*" -ErrorAction SilentlyContinue
Remove-Item -Force -Recurse "$tempDirApp\storage\framework\views\*" -ErrorAction SilentlyContinue
Remove-Item -Force -Recurse "$tempDirApp\storage\framework\sessions\*" -ErrorAction SilentlyContinue

Write-Host "Dividiendo carpeta VENDOR en 3 partes..."
$vendorPath = "C:\laragon\www\suraki-helpdesk\vendor"
$folders = Get-ChildItem -Path $vendorPath -Directory

$count = 0
foreach ($folder in $folders) {
    if ($count % 3 -eq 0) {
        robocopy $folder.FullName "$tempV1\vendor\$($folder.Name)" /E /XD .git tests > $null
    } elseif ($count % 3 -eq 1) {
        robocopy $folder.FullName "$tempV2\vendor\$($folder.Name)" /E /XD .git tests > $null
    } else {
        robocopy $folder.FullName "$tempV3\vendor\$($folder.Name)" /E /XD .git tests > $null
    }
    $count++
}
robocopy $vendorPath "$tempV1\vendor" *.* /XF *.ps1 /XD * > $null

Write-Host "Comprimiendo en formato ZIP nativo de Linux (para cPanel)..."
c:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe C:\laragon\www\suraki-helpdesk\comprimir_cpanel.php

Write-Host "Limpiando archivos temporales..."
foreach ($t in $temps) { Remove-Item -Force -Recurse $t }

Write-Host ""
Write-Host "=========================================================="
Write-Host "¡LISTO! Se han generado CUATRO archivos COMPATIBLES CON CPANEL:"
Write-Host "1. suraki_helpdesk_app.zip"
Write-Host "2. suraki_helpdesk_vendor_1.zip"
Write-Host "3. suraki_helpdesk_vendor_2.zip"
Write-Host "4. suraki_helpdesk_vendor_3.zip"
Write-Host "=========================================================="
