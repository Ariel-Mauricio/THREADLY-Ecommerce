# 🚀 GUÍA DE DESPLIEGUE - THREADLY

## 📖 PARA PRINCIPIANTES: Explicación Simple

Si nunca has puesto un sistema en producción, aquí te explico todo paso a paso.

---

## 🤔 ¿Qué necesito para poner mi tienda online?

1. **Un dominio** - El nombre de tu tienda (ej: mitienda.com) - Costo: ~$12/año
2. **Un hosting/VPS** - Un servidor donde correrá tu tienda - Costo: ~$5-20/mes
3. **SSL/HTTPS** - Para que sea seguro (gratis con Let's Encrypt)

---

## 🏆 RECOMENDACIÓN: Los VPS más fáciles para empezar

### Opción 1: DigitalOcean (RECOMENDADO para principiantes)
- **Precio:** $6/mes (Droplet básico)
- **Por qué:** Tiene interfaz muy simple y tutoriales en español
- **Link:** https://www.digitalocean.com
- **Bonus:** Pueden darte $200 de crédito gratis al registrarte

### Opción 2: Hostinger VPS
- **Precio:** $5.99/mes
- **Por qué:** Muy barato, soporte en español, panel fácil
- **Link:** https://www.hostinger.es/vps

### Opción 3: Vultr
- **Precio:** $6/mes
- **Por qué:** Buen rendimiento, servidores en Miami (cerca de Ecuador)
- **Link:** https://www.vultr.com

### Opción 4: Railway (MÁS FÁCIL de todos)
- **Precio:** ~$5/mes según uso
- **Por qué:** Solo subes tu código y funciona, sin configurar servidor
- **Link:** https://railway.app
- **Ideal si:** No quieres tocar terminal ni configurar nada

---

## 🎯 OPCIÓN A: Despliegue en Railway (Más Fácil)

Railway es como "magia" - conectas tu GitHub y todo se configura solo.

### Pasos:
1. Sube tu proyecto a GitHub
2. Ve a https://railway.app
3. Crea cuenta con GitHub
4. Click en "New Project" → "Deploy from GitHub repo"
5. Selecciona tu repositorio
6. Railway detecta Laravel automáticamente
7. Agrega una base de datos MySQL:
   - Click en "+ New" → "Database" → "MySQL"
8. Configura las variables de entorno (Settings → Variables):
```
APP_ENV=production
APP_DEBUG=false
APP_KEY=genera_uno_con_artisan
DB_CONNECTION=mysql
(Railway te da las credenciales de la BD automáticamente)
```
9. ¡Listo! Railway te da una URL como `tu-proyecto.up.railway.app`

**Costo:** ~$5-10/mes dependiendo del tráfico

---

## 🎯 OPCIÓN B: Despliegue en DigitalOcean (Recomendado)

### Paso 1: Crear cuenta y Droplet

1. Ve a https://www.digitalocean.com
2. Crea una cuenta (puedes usar Google)
3. Click en "Create" → "Droplets"
4. Selecciona:
   - **Región:** New York o Miami (más cerca de Ecuador)
   - **Image:** Ubuntu 22.04 LTS
   - **Size:** Basic → Regular → $6/mes (1GB RAM, 25GB SSD)
   - **Authentication:** Password (pon una contraseña segura)
5. Click "Create Droplet"
6. Espera 1 minuto, te darán una IP (ej: 164.92.xxx.xxx)

### Paso 2: Conectarte al servidor

**En Windows:**
1. Descarga PuTTY: https://www.putty.org
2. Abre PuTTY
3. En "Host Name" pon la IP de tu droplet
4. Click "Open"
5. Usuario: `root`
6. Password: la que pusiste

**En Mac/Linux:**
```bash
ssh root@TU_IP_DEL_SERVIDOR
```

### Paso 3: Instalar todo (copia y pega estos comandos)

```bash
# 1. Actualizar sistema
apt update && apt upgrade -y

# 2. Instalar PHP 8.2 y extensiones
apt install -y software-properties-common
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath unzip git nginx

# 3. Instalar Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# 4. Instalar MySQL
apt install -y mysql-server
mysql_secure_installation
# Pon una contraseña para root de MySQL cuando pregunte

# 5. Crear base de datos
mysql -u root -p
# Ingresa tu contraseña de MySQL, luego ejecuta:
CREATE DATABASE threadly CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'threadly_user'@'localhost' IDENTIFIED BY 'TuPasswordSegura123!';
GRANT ALL PRIVILEGES ON threadly.* TO 'threadly_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Paso 4: Subir tu proyecto

```bash
# Ir a la carpeta web
cd /var/www

# Clonar tu proyecto (sube primero a GitHub)
git clone https://github.com/TU_USUARIO/TU_REPOSITORIO.git threadly
cd threadly

# Instalar dependencias
composer install --no-dev --optimize-autoloader

# Configurar permisos
chown -R www-data:www-data /var/www/threadly
chmod -R 755 /var/www/threadly
chmod -R 775 storage bootstrap/cache

# Configurar .env
cp .env.example .env
nano .env
# Cambia estos valores:
# APP_ENV=production
# APP_DEBUG=false
# APP_URL=http://TU_IP_O_DOMINIO
# DB_DATABASE=threadly
# DB_USERNAME=threadly_user
# DB_PASSWORD=TuPasswordSegura123!

# Generar key y migrar
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan db:seed
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Paso 5: Configurar Nginx

```bash
nano /etc/nginx/sites-available/threadly
```

Pega esto (cambia `TU_IP_O_DOMINIO`):
```nginx
server {
    listen 80;
    server_name TU_IP_O_DOMINIO;
    root /var/www/threadly/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Guarda con `Ctrl+X`, luego `Y`, luego `Enter`.

```bash
# Activar el sitio
ln -s /etc/nginx/sites-available/threadly /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
nginx -t
systemctl reload nginx
```

### Paso 6: ¡Probar!

Abre tu navegador y ve a: `http://TU_IP_DEL_SERVIDOR`

¡Tu tienda debería estar funcionando!

---

## 🔒 Agregar HTTPS (SSL) - GRATIS

Esto es para que aparezca el candadito verde y sea seguro.

**Requisito:** Necesitas un dominio (ej: mitienda.com) apuntando a tu servidor.

```bash
apt install -y certbot python3-certbot-nginx
certbot --nginx -d tudominio.com -d www.tudominio.com
# Sigue las instrucciones, te pedirá un email
```

¡Listo! Tu sitio ahora es HTTPS.

---

## 📧 CONFIGURACIÓN DE CORREOS

### ¿Cómo funcionan los correos?

Tu tienda necesita enviar emails para:
- Confirmación de pedidos
- Recuperación de contraseña
- Notificaciones

**IMPORTANTE:** Laravel NO envía correos solo, necesita un servicio SMTP.

### Opción 1: Gmail (Gratis, pero tiene límites)

**Límite:** 500 correos/día

1. Ve a tu cuenta de Google → Seguridad
2. Activa "Verificación en 2 pasos"
3. Ve a https://myaccount.google.com/apppasswords
4. Crea una contraseña de aplicación
5. En tu `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=lacontrasenade16caracteres
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="THREADLY"
```

### Opción 2: Brevo (Antes Sendinblue) - RECOMENDADO

**Gratis:** 300 correos/día

1. Registra en https://www.brevo.com
2. Ve a SMTP & API
3. Crea una API Key
4. En tu `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=tu_email_brevo
MAIL_PASSWORD=tu_api_key
MAIL_ENCRYPTION=tls
```

### Opción 3: Amazon SES (Para alto volumen)

**Costo:** $0.10 por cada 1000 correos

Ideal si esperas muchos pedidos.

---

## 💳 CONFIGURACIÓN DE PAYPHONE

### Paso 1: Crear cuenta comercio

1. Ve a https://payphone.app
2. Registra como "Comercio"
3. Completa verificación (RUC, cédula, etc.)
4. Espera aprobación (1-3 días)

### Paso 2: Obtener credenciales

1. En el dashboard de PayPhone
2. Ve a Configuración → API
3. Copia el "Token" y "Store ID"

### Paso 3: Configurar en tu tienda

En tu `.env`:
```env
# Para PRUEBAS
PAYPHONE_ENV=sandbox
PAYPHONE_TOKEN=token_sandbox
PAYPHONE_STORE_ID=store_id_sandbox

# Para PRODUCCIÓN (cuando estés listo)
PAYPHONE_ENV=production
PAYPHONE_TOKEN=token_produccion
PAYPHONE_STORE_ID=store_id_produccion
```

### Paso 4: Configurar Webhook

En PayPhone dashboard:
1. Ve a Webhooks
2. Agrega URL: `https://tudominio.com/payment/webhook`
3. Selecciona eventos: transaction.completed, transaction.failed

---

## ✅ CHECKLIST ANTES DE LANZAR

- [ ] ¿APP_DEBUG=false en .env?
- [ ] ¿APP_ENV=production en .env?
- [ ] ¿Tienes SSL (HTTPS)?
- [ ] ¿PayPhone configurado?
- [ ] ¿Correos funcionando?
- [ ] ¿Creaste el admin?
- [ ] ¿Probaste hacer una compra?
- [ ] ¿El webhook de PayPhone funciona?

---

## 🆘 PROBLEMAS COMUNES

### "500 Internal Server Error"
```bash
cd /var/www/threadly
php artisan config:clear
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
tail -f storage/logs/laravel.log  # Ver errores
```

### "CSRF Token Mismatch"
```bash
php artisan config:clear
php artisan cache:clear
```

### Los correos no llegan
1. Verifica `.env` tiene credenciales SMTP correctas
2. Revisa spam del destinatario
3. Mira logs: `tail -f storage/logs/laravel.log`

### PayPhone no funciona
1. Verifica token y store_id correctos
2. En sandbox usa tarjetas de prueba
3. En producción asegúrate de estar aprobado

---

## 📞 RECURSOS ÚTILES

- **Laravel Docs:** https://laravel.com/docs
- **DigitalOcean Tutoriales:** https://www.digitalocean.com/community/tutorials
- **PayPhone Docs:** https://docs.payphone.app
- **Let's Encrypt:** https://certbot.eff.org

---

## 🔄 ACTUALIZAR TU TIENDA

Cuando hagas cambios:

```bash
cd /var/www/threadly
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl reload nginx
```

---

¡Éxito con tu tienda! 🎉
