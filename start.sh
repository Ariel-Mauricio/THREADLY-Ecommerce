#!/bin/bash

# THREADLY - E-commerce Server Startup Script
# Para Linux/Mac

echo "============================================"
echo "   THREADLY - Sistema E-commerce"
echo "   Iniciando servidor de desarrollo..."
echo "============================================"
echo ""

cd "$(dirname "$0")"

echo "[1/5] Verificando PHP..."
if ! command -v php &> /dev/null; then
    echo "ERROR: PHP no encontrado."
    exit 1
fi
echo "     PHP encontrado correctamente."
echo ""

echo "[2/5] Verificando archivo .env..."
if [ ! -f ".env" ]; then
    echo "     Creando archivo .env desde .env.example..."
    cp .env.example .env
    echo "     Generando APP_KEY..."
    php artisan key:generate --quiet
fi
echo "     Archivo .env configurado."
echo ""

echo "[3/5] Limpiando cache..."
php artisan config:clear --quiet
php artisan cache:clear --quiet
php artisan view:clear --quiet
php artisan route:clear --quiet
echo "     Cache limpiado."
echo ""

echo "[4/5] Verificando base de datos..."
if ! php artisan migrate:status &> /dev/null; then
    echo "     ADVERTENCIA: Configura la base de datos en .env"
    echo "     Luego ejecuta: php artisan migrate"
else
    echo "     Base de datos conectada."
fi
echo ""

echo "[5/5] Iniciando servidor..."
echo ""
echo "============================================"
echo "   Servidor iniciado en:"
echo "   http://127.0.0.1:8000"
echo ""
echo "   Panel Admin: http://127.0.0.1:8000/admin"
echo "   Usuario: admin@threadly.com"
echo "   Password: Admin123!"
echo ""
echo "   Presiona Ctrl+C para detener el servidor"
echo "============================================"
echo ""

php artisan serve
