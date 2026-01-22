<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

<h1 align="center">👕 THREADLY</h1>
<h3 align="center">E-commerce Premium de Camisetas</h3>

<p align="center">
  <strong>Sistema completo de tienda online desarrollado con Laravel 12</strong><br>
  Diseñado para Ecuador 🇪🇨 con integración de pagos PayPhone
</p>

<p align="center">
  <a href="#-características">Características</a> •
  <a href="#-capturas">Capturas</a> •
  <a href="#-instalación">Instalación</a> •
  <a href="#-tecnologías">Tecnologías</a> •
  <a href="#-estructura">Estructura</a>
</p>

---

## ✨ Características

### 🛒 Tienda
- ✅ Catálogo de productos con filtros avanzados
- ✅ Carrito de compras dinámico (AJAX)
- ✅ Sistema de wishlist (lista de deseos)
- ✅ Búsqueda en tiempo real
- ✅ Reseñas y calificaciones de productos
- ✅ Múltiples tallas y colores por producto

### 👤 Usuarios
- ✅ Registro y login de usuarios
- ✅ Perfil de usuario editable
- ✅ Gestión de direcciones de envío
- ✅ Historial de pedidos
- ✅ Cambio de contraseña seguro

### 💳 Checkout
- ✅ Proceso de pago en 3 pasos
- ✅ Integración con PayPhone (Ecuador)
- ✅ Comprobante de pago por imagen
- ✅ Pago contra entrega
- ✅ Confirmación por email

### 🔐 Panel de Administración
- ✅ Dashboard con estadísticas en tiempo real
- ✅ Gestión completa de productos (CRUD)
- ✅ Gestión de categorías
- ✅ Sistema de promociones y descuentos
- ✅ Gestión de pedidos con estados
- ✅ Administración de usuarios
- ✅ Moderación de reseñas
- ✅ Reportes de ventas
- ✅ Registro de actividad del sistema

### 📱 Responsive
- ✅ Diseño 100% responsive
- ✅ Optimizado para móviles
- ✅ Interfaz moderna con glassmorphism

---

## 📸 Capturas

<details>
<summary>🏠 <strong>Página Principal</strong></summary>
<br>
<p>Hero section con animaciones, productos destacados y categorías</p>
</details>

<details>
<summary>🛍️ <strong>Catálogo de Productos</strong></summary>
<br>
<p>Filtros por categoría, precio, talla. Vista rápida de productos</p>
</details>

<details>
<summary>📊 <strong>Panel de Administración</strong></summary>
<br>
<p>Dashboard oscuro con métricas, gráficos y accesos rápidos</p>
</details>

---

## 🚀 Instalación

### Requisitos Previos
- PHP 8.2 o superior
- MySQL 5.7+ o MariaDB 10.3+
- Composer 2.x
- Node.js 18+ (opcional, para compilar assets)
- XAMPP, WAMP, Laragon o similar

### ⚡ Inicio Rápido (Windows)

```bash
# 1. Clonar el repositorio
git clone https://github.com/Ariel-Mauricio/THREADLY-Ecommerce.git

# 2. Entrar a la carpeta
cd THREADLY-Ecommerce

# 3. Ejecutar el instalador automático
start.bat
```

El script automáticamente:
- ✅ Verifica PHP
- ✅ Crea archivo `.env`
- ✅ Genera APP_KEY
- ✅ Limpia caché
- ✅ Ejecuta migraciones
- ✅ Ejecuta seeders
- ✅ Crea enlace simbólico de storage
- ✅ Inicia el servidor

### 🐧 Linux / Mac

```bash
chmod +x start.sh
./start.sh
```

### 🔧 Instalación Manual

```bash
# 1. Instalar dependencias
composer install

# 2. Configurar entorno
cp .env.example .env
php artisan key:generate

# 3. Configurar base de datos en .env
# DB_DATABASE=threadly
# DB_USERNAME=root
# DB_PASSWORD=

# 4. Ejecutar migraciones y seeders
php artisan migrate --seed

# 5. Crear enlace de storage
php artisan storage:link

# 6. Iniciar servidor
php artisan serve
```

---

## 🔑 Accesos por Defecto

| Rol | Email | Contraseña |
|-----|-------|------------|
| 👨‍💼 **Admin** | `admin@threadly.com` | `Admin123!` |
| 👤 **Usuario** | Crear cuenta en registro | - |

**URLs:**
- 🏠 Tienda: `http://127.0.0.1:8000`
- 🔐 Admin: `http://127.0.0.1:8000/admin`

---

## 🛠️ Tecnologías

### Backend
| Tecnología | Versión | Uso |
|------------|---------|-----|
| Laravel | 12.x | Framework principal |
| PHP | 8.2+ | Lenguaje backend |
| MySQL | 8.0 | Base de datos |
| Eloquent ORM | - | Gestión de datos |

### Frontend
| Tecnología | Versión | Uso |
|------------|---------|-----|
| Bootstrap | 5.3 | Framework CSS |
| Bootstrap Icons | 1.11 | Iconografía |
| AOS | 2.3 | Animaciones scroll |
| Vanilla JS | ES6+ | Interactividad |

### Herramientas
| Herramienta | Uso |
|-------------|-----|
| Composer | Gestión de dependencias PHP |
| Artisan | CLI de Laravel |
| Git | Control de versiones |

---

## 📁 Estructura del Proyecto

```
THREADLY-Ecommerce/
├── 📂 app/
│   ├── 📂 Http/
│   │   ├── 📂 Controllers/     # Controladores
│   │   ├── 📂 Middleware/      # Middleware personalizado
│   │   └── 📂 Requests/        # Form Requests
│   ├── 📂 Mail/                # Clases de correo
│   ├── 📂 Models/              # Modelos Eloquent
│   └── 📂 Services/            # Servicios (SEO, etc)
├── 📂 config/                  # Configuraciones
├── 📂 database/
│   ├── 📂 migrations/          # Migraciones de BD
│   └── 📂 seeders/             # Seeders
├── 📂 public/                  # Archivos públicos
├── 📂 resources/
│   ├── 📂 css/                 # Estilos
│   ├── 📂 js/                  # JavaScript
│   └── 📂 views/               # Vistas Blade
│       ├── 📂 admin/           # Panel admin
│       ├── 📂 auth/            # Login/Registro
│       ├── 📂 layouts/         # Plantillas
│       ├── 📂 orders/          # Pedidos
│       ├── 📂 products/        # Productos
│       └── 📂 profile/         # Perfil usuario
├── 📂 routes/
│   └── 📄 web.php              # Rutas web
├── 📄 .env.example             # Ejemplo de configuración
├── 📄 composer.json            # Dependencias PHP
├── 📄 start.bat                # Instalador Windows
└── 📄 start.sh                 # Instalador Linux/Mac
```

---

## 📊 Modelos de Datos

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│    User     │────<│    Order    │────<│  OrderItem  │
└─────────────┘     └─────────────┘     └─────────────┘
       │                                       │
       │            ┌─────────────┐            │
       └───────────>│   Review    │<───────────┘
                    └─────────────┘
                           │
┌─────────────┐     ┌─────────────┐
│  Category   │────<│   Product   │
└─────────────┘     └─────────────┘
                           │
┌─────────────┐     ┌─────────────┐
│    Cart     │────<│  CartItem   │
└─────────────┘     └─────────────┘
```

---

## 🔒 Seguridad

- ✅ Autenticación con Laravel Breeze
- ✅ Middleware de admin personalizado
- ✅ Protección CSRF en formularios
- ✅ Validación de datos en servidor
- ✅ Hash de contraseñas con bcrypt
- ✅ Rate limiting en API

---

## 📧 Contacto

**Desarrollado por:** Ariel Mauricio

**GitHub:** [@Ariel-Mauricio](https://github.com/Ariel-Mauricio)

---

<p align="center">
  <strong>⭐ Si te gustó el proyecto, dale una estrella ⭐</strong>
</p>

<p align="center">
  Hecho con ❤️ en Ecuador 🇪🇨
</p>
