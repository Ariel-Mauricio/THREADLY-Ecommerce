# 👕 THREADLY - E-commerce de Ropa

Sistema de tienda online de ropa desarrollado con Laravel 12 para Ecuador, con integración de pagos PayPhone.

---

## 🚀 Inicio Rápido

### Windows
```bash
# Doble clic en:
start.bat
```

### Linux/Mac
```bash
chmod +x start.sh
./start.sh
```

---

## 📋 Requisitos

- PHP 8.2+
- MySQL 5.7+ o MariaDB 10.3+
- Composer 2.x
- Node.js 18+ (para compilar assets)
- XAMPP, WAMP, Laragon o similar

---

## ⚙️ Instalación Manual

### 1. Clonar e instalar dependencias
```bash
git clone [URL_REPOSITORIO] threadly
cd threadly
composer install
npm install && npm run build
```

### 2. Configurar entorno
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configurar base de datos
Edita `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=threadly
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Ejecutar migraciones
```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan storage:link
```

### 5. Iniciar servidor
```bash
php artisan serve
```

---

## 🔐 Credenciales de Acceso

### Panel de Administración
```
URL:      http://127.0.0.1:8000/admin
Email:    admin@threadly.com
Password: Admin123!
```

---

## 📧 Configuración de Correos Electrónicos

### ⚠️ IMPORTANTE: Los correos NO funcionan sin configuración

Para que el sistema envíe correos (confirmación de pedidos, recuperación de contraseña, etc.), debes configurar un servidor SMTP.

### Opción 1: Gmail (Recomendado para pruebas)

1. **Habilitar verificación en 2 pasos** en tu cuenta de Google
2. **Crear una "Contraseña de aplicación"**:
   - Ve a https://myaccount.google.com/apppasswords
   - Selecciona "Correo" y "Computadora Windows"
   - Google te dará una contraseña de 16 caracteres (ej: `abcd efgh ijkl mnop`)

3. **Configurar en `.env`**:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email_real@gmail.com
MAIL_PASSWORD=abcdefghijklmnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email_real@gmail.com
MAIL_FROM_NAME="THREADLY"
```

### Opción 2: Mailtrap (Para desarrollo)
Mailtrap captura los correos sin enviarlos realmente. Perfecto para pruebas.
1. Crea cuenta en https://mailtrap.io
2. Copia las credenciales SMTP

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_username_mailtrap
MAIL_PASSWORD=tu_password_mailtrap
```

### Opción 3: Sin correos (desarrollo local)
```env
MAIL_MAILER=log
```
Los correos se guardarán en `storage/logs/laravel.log`

---

## 💳 Configuración de PayPhone (Pagos)

### Modo Sandbox (Pruebas)
```env
PAYPHONE_TOKEN=tu_token_sandbox
PAYPHONE_STORE_ID=tu_store_id_sandbox
PAYPHONE_ENV=sandbox
```

### Modo Producción
```env
PAYPHONE_TOKEN=tu_token_produccion
PAYPHONE_STORE_ID=tu_store_id_produccion
PAYPHONE_ENV=production
```

**Obtener credenciales:** https://payphone.app → Registrarse como comercio

---

## 🔑 Login con Redes Sociales (Facebook/Google)

### ⚠️ NO ESTÁ IMPLEMENTADO

El sistema actualmente **no tiene** login con Facebook o Google. El login es solo con email/contraseña.

Si necesitas agregarlo en el futuro:
1. Instala Laravel Socialite: `composer require laravel/socialite`
2. Crea una app en Facebook Developers o Google Cloud Console
3. Configura las credenciales OAuth

**Para una tienda básica, el login tradicional es suficiente.**

---

## 📁 Estructura del Proyecto

```
threadly/
├── app/
│   ├── Http/Controllers/     # Controladores
│   ├── Models/               # Modelos Eloquent
│   └── Mail/                 # Plantillas de correo
├── database/
│   ├── migrations/           # Estructura de BD
│   └── seeders/              # Datos iniciales
├── resources/views/          # Vistas Blade
├── routes/web.php            # Rutas de la app
├── public/                   # Archivos públicos
└── storage/                  # Uploads y logs
```

---

## 🛠️ Comandos Útiles

```bash
# Limpiar toda la cache
php artisan optimize:clear

# Ver todas las rutas
php artisan route:list

# Crear admin manualmente
php artisan tinker
>>> \App\Models\User::create(['name'=>'Admin','email'=>'admin@threadly.com','password'=>bcrypt('Admin123!'),'is_admin'=>true])

# Ejecutar migraciones pendientes
php artisan migrate

# Resetear BD completamente (¡BORRA TODO!)
php artisan migrate:fresh

# Resetear BD y crear admin
php artisan migrate:fresh --seed
```

---

## 🐛 Solución de Problemas

### Error: "SQLSTATE[HY000] Access denied"
- Verifica usuario y contraseña en `.env`
- Asegúrate que MySQL/MariaDB esté corriendo

### Error: "Class not found"
```bash
composer dump-autoload
php artisan optimize:clear
```

### Error: "View not found"
```bash
php artisan view:clear
```

### Página en blanco
```bash
php artisan config:clear
php artisan cache:clear
```

### Los correos no llegan
1. Verifica configuración SMTP en `.env`
2. Revisa `storage/logs/laravel.log` para errores
3. Usa `MAIL_MAILER=log` para probar sin SMTP

---

## 📄 Licencia

Proyecto privado. Todos los derechos reservados.
