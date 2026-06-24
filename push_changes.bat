@echo off
echo ========================================================
echo Actualizando el repositorio en GitHub...
echo ========================================================
git add .
git commit -m "Refactor: Limpieza de arquitectura y archivos innecesarios"
git push origin main
echo ========================================================
echo ¡Actualizacion completada con exito!
echo Puedes eliminar este archivo (push_changes.bat)
echo ========================================================
pause
