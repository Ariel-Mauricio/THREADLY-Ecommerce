@echo off
title THREADLY - E-commerce Server
color 0A

echo ============================================
echo    THREADLY - Sistema E-commerce
echo    Iniciando servidor de desarrollo...
echo ============================================
echo.

cd /d "%~dp0"

echo [1/5] Verificando PHP...
php -v >nul 2>&1
if errorlevel 1 (
    echo ERROR: PHP no encontrado. Asegurate de tener XAMPP instalado.
    pause
    exit /b 1
)
echo      PHP encontrado correctamente.
echo.

echo [2/5] Verificando archivo .env...
if not exist ".env" (
    echo      Creando archivo .env desde .env.example...
    copy .env.example .env >nul
    echo      Generando APP_KEY...
    php artisan key:generate --quiet
)
echo      Archivo .env configurado.
echo.

echo [3/5] Limpiando cache...
php artisan config:clear --quiet
php artisan cache:clear --quiet
php artisan view:clear --quiet
php artisan route:clear --quiet
echo      Cache limpiado.
echo.

echo [4/7] Verificando base de datos...
php artisan migrate:status >nul 2>&1
if errorlevel 1 (
    echo      ADVERTENCIA: Configura la base de datos en .env
    echo      Luego ejecuta: php artisan migrate
) else (
    echo      Base de datos conectada.
)
echo.

echo [5/7] Ejecutando seeders...
php artisan db:seed --quiet 2>nul
if errorlevel 1 (
    echo      Seeders ya ejecutados o sin cambios.
) else (
    echo      Seeders ejecutados correctamente.
)
echo.

echo [6/7] Creando enlace simbolico para storage...
if not exist "public\storage" (
    php artisan storage:link --quiet
    echo      Enlace simbolico creado.
) else (
    echo      Enlace simbolico ya existe.
)
echo.

echo [7/7] Iniciando servidor...
echo.
echo ============================================
echo    Servidor iniciado en:
echo    http://127.0.0.1:8000
echo.
echo    Panel Admin: http://127.0.0.1:8000/admin
echo    Usuario: admin@threadly.com
echo    Password: Admin123!
echo.
echo    Presiona Ctrl+C para detener el servidor
echo ============================================
echo.

php artisan serve

pause
