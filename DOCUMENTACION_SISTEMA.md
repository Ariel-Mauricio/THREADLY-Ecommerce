# 🛍️ THREADLY - Sistema de E-Commerce
## Documentación Técnica Completa y Exhaustiva del Sistema

**Versión:** 1.0.0  
**Fecha:** Enero 2026  
**Framework:** Laravel 12  
**PHP:** 8.2+  
**Base de Datos:** MySQL 8.0+  
**Frontend:** Bootstrap 5.3, JavaScript ES6+  

---

# 📋 ÍNDICE GENERAL

## PARTE I - VISIÓN GENERAL
1. [Descripción General del Sistema](#1-descripción-general)
2. [Arquitectura del Sistema](#2-arquitectura-del-sistema)
3. [Requisitos del Sistema](#3-requisitos-del-sistema)

## PARTE II - MÓDULO DE CLIENTES (TIENDA)
4. [Página Principal (Home)](#4-página-principal-home)
5. [Catálogo de Productos](#5-catálogo-de-productos)
6. [Detalle de Producto](#6-detalle-de-producto)
7. [Carrito de Compras](#7-carrito-de-compras)
8. [Proceso de Checkout](#8-proceso-de-checkout)
9. [Sistema de Pagos](#9-sistema-de-pagos)

## PARTE III - CUENTA DE USUARIO
10. [Sistema de Autenticación](#10-sistema-de-autenticación)
11. [Perfil de Usuario](#11-perfil-de-usuario)
12. [Gestión de Direcciones](#12-gestión-de-direcciones)
13. [Lista de Deseos (Wishlist)](#13-lista-de-deseos-wishlist)
14. [Historial de Pedidos](#14-historial-de-pedidos)
15. [Sistema de Reseñas](#15-sistema-de-reseñas)

## PARTE IV - PANEL DE ADMINISTRACIÓN
16. [Dashboard Principal](#16-dashboard-principal)
17. [Gestión de Productos](#17-gestión-de-productos)
18. [Gestión de Categorías](#18-gestión-de-categorías)
19. [Gestión de Pedidos](#19-gestión-de-pedidos)
20. [Sistema de Promociones](#20-sistema-de-promociones)
21. [Gestión de Usuarios](#21-gestión-de-usuarios)
22. [Exportación de Datos](#22-exportación-de-datos)

## PARTE V - SISTEMAS TRANSVERSALES
23. [Sistema de Correos Electrónicos](#23-sistema-de-correos-electrónicos)
24. [Sistema de Logs y Actividad](#24-sistema-de-logs-y-actividad)
25. [Base de Datos y Modelos](#25-base-de-datos-y-modelos)
26. [Seguridad del Sistema](#26-seguridad-del-sistema)
27. [SEO y Optimización](#27-seo-y-optimización)
28. [API y Rutas Completas](#28-api-y-rutas-completas)

## PARTE VI - GUÍAS TÉCNICAS
29. [Instalación y Configuración](#29-instalación-y-configuración)
30. [Variables de Entorno](#30-variables-de-entorno)
31. [Mantenimiento y Comandos](#31-mantenimiento-y-comandos)

---

# PARTE I - VISIÓN GENERAL

---

# 1. DESCRIPCIÓN GENERAL

## 1.1 ¿Qué es THREADLY?

**THREADLY** es una plataforma de comercio electrónico completa y profesional especializada en la venta de ropa online. El sistema ha sido desarrollado utilizando el framework **Laravel 12** con **PHP 8.2+**, siguiendo las mejores prácticas de desarrollo y patrones de diseño MVC (Modelo-Vista-Controlador).

El sistema está específicamente diseñado y optimizado para el **mercado ecuatoriano**, incluyendo:
- Integración nativa con la pasarela de pagos **PayPhone** (la más utilizada en Ecuador)
- Cálculo automático del IVA del 12%
- Soporte para provincias y ciudades de Ecuador
- Moneda USD (dólar estadounidense)

## 1.2 Características Principales del Sistema

### 🛒 Sistema de E-Commerce Completo
| Funcionalidad | Descripción Detallada |
|---------------|----------------------|
| **Catálogo de Productos** | Sistema completo de gestión de productos con categorías, búsqueda avanzada, filtros múltiples (precio, categoría, disponibilidad), ordenamiento flexible y paginación optimizada |
| **Carrito de Compras** | Carrito persistente que funciona tanto para usuarios anónimos como autenticados, con migración automática del carrito de sesión al usuario al hacer login |
| **Proceso de Checkout** | Flujo de compra optimizado en una sola página con validación en tiempo real, cálculo automático de impuestos y envío |
| **Múltiples Métodos de Pago** | Soporte para tarjetas de crédito/débito (PayPhone), transferencia bancaria con upload de comprobante |

### 👤 Gestión Completa de Usuarios
| Funcionalidad | Descripción Detallada |
|---------------|----------------------|
| **Registro e Inicio de Sesión** | Sistema de autenticación seguro con validación de email, contraseñas hasheadas y protección contra ataques de fuerza bruta |
| **Perfiles de Usuario** | Gestión completa del perfil con avatar, datos personales, fecha de nacimiento y preferencias |
| **Múltiples Direcciones** | Sistema de gestión de direcciones de envío con soporte para múltiples direcciones y dirección predeterminada |
| **Recuperación de Contraseña** | Sistema completo de recuperación mediante email con tokens seguros y expiración |

### 📦 Gestión de Pedidos
| Funcionalidad | Descripción Detallada |
|---------------|----------------------|
| **Ciclo de Vida Completo** | Seguimiento de pedidos desde la creación hasta la entrega con 9 estados diferentes |
| **Notificaciones por Email** | Emails automáticos en cada cambio de estado del pedido |
| **Historial de Pedidos** | Los clientes pueden ver todo su historial de compras con detalles completos |

### 📊 Panel de Administración Avanzado
| Funcionalidad | Descripción Detallada |
|---------------|----------------------|
| **Dashboard con Métricas** | Panel principal con KPIs, gráficos interactivos (Chart.js) y alertas importantes |
| **CRUD de Productos** | Gestión completa de productos con imágenes, variantes (tallas/colores), promociones y SEO |
| **Gestión de Usuarios** | Administración de clientes con suspensión, roles y reset de contraseña |
| **Exportaciones** | Generación de reportes en CSV para pedidos, productos, usuarios y ventas |

### ⭐ Funcionalidades Adicionales
| Funcionalidad | Descripción Detallada |
|---------------|----------------------|
| **Sistema de Reseñas** | Clientes pueden dejar reseñas con calificación de 1-5 estrellas, verificación de compra |
| **Lista de Deseos** | Wishlist para guardar productos favoritos con opción de mover al carrito |
| **Promociones Programables** | Sistema de descuentos con fechas de inicio/fin, etiquetas personalizadas |
| **SEO Optimizado** | Meta tags dinámicos, Open Graph, Twitter Cards, sitemap.xml automático |
| **Rate Limiting** | Protección contra abuso en endpoints sensibles |

## 1.3 Público Objetivo

El sistema está diseñado para:

1. **Tiendas de Ropa Pequeñas y Medianas** que necesitan presencia online profesional
2. **Emprendedores de Moda** que inician su negocio de venta de ropa
3. **Boutiques** que desean expandir su alcance con ventas online
4. **Marcas de Ropa Locales** en Ecuador que necesitan integración con métodos de pago locales

## 1.4 Flujo General del Sistema

```
┌─────────────────────────────────────────────────────────────────────────┐
│                           FLUJO DEL CLIENTE                              │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐          │
│  │  Visita  │───▶│ Navega   │───▶│ Agrega   │───▶│ Inicia   │          │
│  │   Home   │    │ Catálogo │    │ Carrito  │    │  Sesión  │          │
│  └──────────┘    └──────────┘    └──────────┘    └──────────┘          │
│                                                         │                │
│                                                         ▼                │
│  ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐          │
│  │ Recibe   │◀───│ Realiza  │◀───│ Completa │◀───│ Procede  │          │
│  │ Producto │    │  Pago    │    │ Checkout │    │  Compra  │          │
│  └──────────┘    └──────────┘    └──────────┘    └──────────┘          │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────┐
│                        FLUJO DEL ADMINISTRADOR                           │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐          │
│  │  Login   │───▶│Dashboard │───▶│ Gestiona │───▶│ Procesa  │          │
│  │  Admin   │    │ Métricas │    │ Productos│    │ Pedidos  │          │
│  └──────────┘    └──────────┘    └──────────┘    └──────────┘          │
│                                                         │                │
│                                                         ▼                │
│  ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐          │
│  │ Exporta  │◀───│ Gestiona │◀───│  Aplica  │◀───│ Actualiza│          │
│  │ Reportes │    │ Usuarios │    │ Promos   │    │ Estados  │          │
│  └──────────┘    └──────────┘    └──────────┘    └──────────┘          │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

# 2. ARQUITECTURA DEL SISTEMA

## Stack Tecnológico

```
┌─────────────────────────────────────────────────────────────┐
│                      FRONTEND                                │
│  Bootstrap 5 │ Blade Templates │ JavaScript │ CSS           │
├─────────────────────────────────────────────────────────────┤
│                      BACKEND                                 │
│  Laravel 12 │ PHP 8.2+ │ Eloquent ORM                       │
├─────────────────────────────────────────────────────────────┤
│                      DATABASE                                │
│  MySQL / MariaDB                                            │
├─────────────────────────────────────────────────────────────┤
│                   SERVICIOS EXTERNOS                         │
│  PayPhone (Pagos) │ SMTP (Correos) │ Storage (Archivos)     │
└─────────────────────────────────────────────────────────────┘
```

## Estructura de Archivos

```
ecomers/
├── app/
│   ├── Http/
│   │   ├── Controllers/         # Controladores
│   │   │   ├── Admin/           # Controladores del panel admin
│   │   │   ├── Auth/            # Autenticación
│   │   │   ├── CartController   # Carrito
│   │   │   ├── CheckoutController # Proceso de compra
│   │   │   ├── PaymentController  # Pagos
│   │   │   └── ...
│   │   ├── Middleware/          # Middlewares personalizados
│   │   └── Requests/            # Form Requests
│   ├── Models/                  # Modelos Eloquent
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── Cart.php
│   │   └── ...
│   ├── Services/                # Servicios
│   │   └── SeoService.php
│   └── Providers/               # Service Providers
├── database/
│   ├── migrations/              # Migraciones de BD
│   ├── seeders/                 # Seeders
│   └── factories/               # Factories para testing
├── resources/
│   ├── views/                   # Vistas Blade
│   │   ├── admin/               # Panel de administración
│   │   ├── auth/                # Login, registro, etc.
│   │   ├── emails/              # Plantillas de correo
│   │   ├── layouts/             # Layouts base
│   │   └── ...
│   └── css/js                   # Assets
├── routes/
│   └── web.php                  # Definición de rutas
└── config/                      # Configuraciones
```

---

# 3. MÓDULO DE CLIENTES (FRONTEND)

## 3.1 Página Principal (Home)

**Ruta:** `/` | **Controlador:** `HomeController@index`

### Secciones:
- **Hero Banner:** Slider principal con promociones
- **Productos Destacados:** Productos marcados como `is_featured`
- **Productos Nuevos:** Productos recientes (últimos 7 días)
- **Categorías:** Grid de categorías disponibles
- **Testimonios:** Sección de opiniones de clientes
- **Newsletter:** Formulario de suscripción

### Funcionalidades:
```php
// Datos que recibe la vista
$featuredProducts   // Productos destacados (6)
$newProducts        // Productos nuevos (8)
$categories         // Categorías activas
$promotionProducts  // Productos en promoción
```

## 3.2 Catálogo de Productos

**Ruta:** `/productos` | **Controlador:** `ProductController@index`

### Filtros Disponibles:
| Filtro | Parámetro | Ejemplo |
|--------|-----------|---------|
| Categoría | `category` | `/productos?category=camisetas` |
| Búsqueda | `search` | `/productos?search=azul` |
| Precio mínimo | `min_price` | `/productos?min_price=10` |
| Precio máximo | `max_price` | `/productos?max_price=50` |
| Ordenar | `sort` | `newest`, `price_asc`, `price_desc`, `name` |

### Paginación:
- 12 productos por página por defecto
- Paginación con enlaces

## 3.3 Detalle de Producto

**Ruta:** `/productos/{slug}` | **Controlador:** `ProductController@show`

### Información Mostrada:
- Nombre, descripción, precio
- Galería de imágenes
- Selector de tallas (si aplica)
- Selector de colores (si aplica)
- Stock disponible
- Botón agregar al carrito
- Botón agregar a favoritos
- Reseñas de clientes
- Productos relacionados

### Atributos del Producto:
```php
$product->name              // Nombre
$product->slug              // URL amigable
$product->description       // Descripción
$product->price             // Precio actual
$product->original_price    // Precio original (sin descuento)
$product->final_price       // Precio final calculado
$product->discount_percent  // % de descuento
$product->stock             // Unidades disponibles
$product->sizes             // Array de tallas ['S','M','L','XL']
$product->colors            // Array de colores ['#000','#fff']
$product->image             // Imagen principal
$product->gallery           // Array de imágenes adicionales
$product->is_featured       // Destacado
$product->is_active         // Activo/visible
$product->average_rating    // Calificación promedio
$product->reviews_count     // Total de reseñas
```

## 3.4 Perfil de Usuario

**Ruta:** `/perfil` | **Controlador:** `ProfileController`

### Secciones del Perfil:

#### a) Información Personal (`/perfil`)
- Ver datos del usuario
- Pedidos recientes
- Direcciones guardadas

#### b) Editar Perfil (`/perfil/editar`)
- Cambiar nombre
- Cambiar teléfono
- Cambiar fecha de nacimiento
- Cambiar género
- Subir avatar

#### c) Cambiar Contraseña (`/perfil/cambiar-password`)
- Contraseña actual
- Nueva contraseña (min 8 chars, mayúsculas, minúsculas, números)
- Confirmar contraseña

#### d) Direcciones (`/perfil/direcciones`)
- Listar direcciones guardadas
- Agregar nueva dirección
- Editar dirección existente
- Eliminar dirección
- Marcar como predeterminada

### Campos de Dirección:
```php
$address->name              // Nombre (ej: "Casa", "Oficina")
$address->recipient_name    // Nombre del destinatario
$address->phone             // Teléfono de contacto
$address->address           // Dirección completa
$address->address_reference // Referencia
$address->city              // Ciudad
$address->province          // Provincia
$address->postal_code       // Código postal
$address->is_default        // Es predeterminada
```

## 3.5 Lista de Deseos (Wishlist)

**Ruta:** `/wishlist` | **Controlador:** `WishlistController`

### Funcionalidades:
| Acción | Ruta | Método |
|--------|------|--------|
| Ver wishlist | `/wishlist` | GET |
| Agregar/quitar (toggle) | `/wishlist/toggle/{product}` | POST |
| Agregar | `/wishlist/add/{product}` | POST |
| Eliminar | `/wishlist/remove/{product}` | DELETE |
| Vaciar todo | `/wishlist/clear` | DELETE |
| Contar items | `/wishlist/count` | GET |
| Mover al carrito | `/wishlist/move-to-cart/{product}` | POST |

### Respuesta AJAX:
```json
{
    "success": true,
    "in_wishlist": true,
    "message": "Producto agregado a favoritos",
    "count": 5
}
```

## 3.6 Mis Pedidos

**Ruta:** `/mis-pedidos` | **Vista:** `orders.index`

### Información por Pedido:
- Número de orden
- Fecha de compra
- Estado actual (con color)
- Total
- Método de pago
- Acciones (ver detalle, cancelar)

### Estados de Pedido:
| Estado | Etiqueta | Color |
|--------|----------|-------|
| `pending` | Pendiente | Amarillo |
| `pending_verification` | Verificando Pago | Azul |
| `processing` | Procesando | Azul |
| `paid` | Pagado | Verde |
| `shipped` | Enviado | Primario |
| `delivered` | Entregado | Verde |
| `cancelled` | Cancelado | Rojo |
| `payment_failed` | Pago Fallido | Rojo |
| `refunded` | Reembolsado | Gris |

---

# 4. PANEL DE ADMINISTRACIÓN

## Acceso
**Ruta:** `/admin` | **Middleware:** `auth`, `admin`

Solo usuarios con `is_admin = true` pueden acceder.

## 4.1 Dashboard Principal

**Ruta:** `/admin` | **Controlador:** `Admin\DashboardController@index`

### Métricas Mostradas:

#### Tarjetas de Resumen:
| Métrica | Descripción |
|---------|-------------|
| 💰 Ventas Totales | Suma de pedidos completados |
| 📦 Total Pedidos | Cantidad de órdenes |
| 🛍️ Total Productos | Productos en catálogo |
| 👥 Total Clientes | Usuarios registrados (no admin) |
| 📈 Crecimiento | % comparado con mes anterior |
| 📅 Pedidos Semana | Órdenes de los últimos 7 días |

#### Gráficos Interactivos (Chart.js):

1. **Gráfico de Ventas** (`/admin/charts/sales`)
   - Períodos: 7 días, 30 días, 12 meses
   - Muestra: Ventas ($) y cantidad de pedidos

2. **Gráfico de Estados** (`/admin/charts/orders-status`)
   - Tipo: Dona/Pie
   - Muestra: Distribución de pedidos por estado

3. **Gráfico de Categorías** (`/admin/charts/categories`)
   - Tipo: Barras
   - Muestra: Ventas por categoría

#### Tablas del Dashboard:
- **Pedidos Recientes:** Últimos 5 pedidos
- **Productos Top:** 5 productos más vendidos
- **Stock Bajo:** Productos con stock ≤ 5
- **Promociones Activas:** Productos con descuento

## 4.2 Gestión de Productos

**Ruta:** `/admin/products` | **Controlador:** `Admin\ProductController`

### CRUD Completo:

| Acción | Ruta | Método |
|--------|------|--------|
| Listar | `/admin/products` | GET |
| Crear (form) | `/admin/products/create` | GET |
| Guardar | `/admin/products` | POST |
| Ver | `/admin/products/{id}` | GET |
| Editar (form) | `/admin/products/{id}/edit` | GET |
| Actualizar | `/admin/products/{id}` | PUT |
| Eliminar | `/admin/products/{id}` | DELETE |

### Campos del Producto:
```php
// Información básica
'name'              // Nombre del producto
'slug'              // URL amigable (auto-generado)
'description'       // Descripción completa
'category_id'       // Categoría

// Precios
'price'             // Precio de venta
'original_price'    // Precio original

// Promociones
'discount_percent'  // % de descuento
'promotion_starts'  // Fecha inicio promoción
'promotion_ends'    // Fecha fin promoción
'promotion_label'   // Etiqueta (ej: "OFERTA")

// Inventario
'stock'             // Unidades disponibles
'sku'               // Código único

// Variantes
'sizes'             // Array de tallas
'colors'            // Array de colores

// Imágenes
'image'             // Imagen principal
'gallery'           // Galería de imágenes

// Flags
'is_active'         // Visible en tienda
'is_featured'       // Mostrar en destacados
'is_new'            // Marcar como nuevo
```

### Filtros en Listado:
- Por categoría
- Por estado (activo/inactivo)
- Por stock (bajo stock)
- Búsqueda por nombre/SKU

## 4.3 Gestión de Categorías

**Ruta:** `/admin/categories` | **Controlador:** `Admin\CategoryController`

### Campos:
```php
'name'          // Nombre de la categoría
'slug'          // URL amigable
'description'   // Descripción
'image'         // Imagen de la categoría
'is_active'     // Activa/inactiva
```

## 4.4 Gestión de Pedidos

**Ruta:** `/admin/orders` | **Controlador:** `Admin\OrderController`

### Listado de Pedidos:
- Filtrar por estado
- Filtrar por fecha
- Búsqueda por número/cliente
- Ordenar por fecha/total

### Detalle del Pedido:
```php
// Información del cliente
$order->customer_name
$order->customer_email
$order->customer_phone

// Dirección de envío
$order->shipping_address
$order->address_reference
$order->city
$order->province

// Información del pedido
$order->order_number
$order->status
$order->payment_method
$order->payment_id
$order->payment_voucher    // Comprobante de pago (transferencia)

// Totales
$order->subtotal
$order->shipping_cost
$order->tax
$order->total

// Items del pedido
$order->items              // Colección de OrderItem
```

### Cambio de Estado:
El admin puede cambiar el estado del pedido:
- De `pending_verification` → `paid` (verificar pago)
- De `paid` → `processing` (comenzar preparación)
- De `processing` → `shipped` (enviar)
- De `shipped` → `delivered` (marcar entregado)
- Cualquier estado → `cancelled` (cancelar)

**Al cambiar estado se envía email automático al cliente.**

## 4.5 Sistema de Promociones

**Ruta:** `/admin/promotions` | **Controlador:** `Admin\PromotionController`

### Funcionalidades:

#### Aplicar Descuento Masivo:
```php
POST /admin/promotions/bulk-apply
{
    "product_ids": [1, 2, 3],
    "discount_percent": 20,
    "promotion_starts": "2026-01-15",
    "promotion_ends": "2026-01-31",
    "promotion_label": "OFERTA DE ENERO"
}
```

#### Remover Descuento Masivo:
```php
POST /admin/promotions/bulk-remove
{
    "product_ids": [1, 2, 3]
}
```

#### Estados de Promoción:
| Estado | Descripción |
|--------|-------------|
| `none` | Sin promoción |
| `permanent` | Descuento sin fecha límite |
| `scheduled` | Programada (aún no inicia) |
| `active` | Activa actualmente |
| `expired` | Expirada |

## 4.6 Gestión de Usuarios

**Ruta:** `/admin/users` | **Controlador:** `Admin\UserController`

### CRUD de Usuarios:

| Acción | Ruta | Método |
|--------|------|--------|
| Listar | `/admin/users` | GET |
| Crear | `/admin/users/create` | GET/POST |
| Ver | `/admin/users/{id}` | GET |
| Editar | `/admin/users/{id}/edit` | GET/PUT |
| Eliminar | `/admin/users/{id}` | DELETE |

### Acciones Especiales:

#### Resetear Contraseña:
```php
POST /admin/users/{id}/reset-password
{
    "password": "nuevaPassword123",
    "password_confirmation": "nuevaPassword123"
}
```

#### Suspender Usuario:
```php
POST /admin/users/{id}/suspend
// Establece suspended_at = now()
// Usuario no puede hacer login
```

#### Restaurar Usuario:
```php
POST /admin/users/{id}/restore
// Establece suspended_at = null
```

#### Cambiar Rol Admin:
```php
POST /admin/users/{id}/toggle-admin
// Alterna is_admin entre true/false
```

### Filtros del Listado:
- Por rol (admin/cliente)
- Por estado (activo/suspendido)
- Búsqueda por nombre/email

## 4.7 Exportaciones

**Ruta:** `/admin/export/*` | **Controlador:** `Admin\ExportController`

### Exportaciones Disponibles (CSV):

| Reporte | Ruta | Contenido |
|---------|------|-----------|
| Pedidos | `/admin/export/orders` | Todos los pedidos |
| Productos | `/admin/export/products` | Inventario completo |
| Usuarios | `/admin/export/users` | Lista de usuarios |
| Ventas | `/admin/export/sales-report` | Reporte de ventas |

### Parámetros de Filtro:
```
/admin/export/orders?start_date=2026-01-01&end_date=2026-01-31&status=delivered
```

---

# 5. SISTEMA DE AUTENTICACIÓN

## 5.1 Registro de Usuarios

**Ruta:** `/register` | **Controlador:** `Auth\RegisterController`

### Validaciones:
```php
'name'     => 'required|string|max:255'
'email'    => 'required|email|unique:users'
'password' => 'required|min:8|confirmed'
```

### Proceso:
1. Usuario llena formulario
2. Se validan datos
3. Se hashea contraseña
4. Se crea usuario en BD
5. Se loguea automáticamente
6. Redirección a home

## 5.2 Login

**Ruta:** `/login` | **Controlador:** `Auth\LoginController`

### Características:
- **Rate Limiting:** 5 intentos por minuto
- **Remember Me:** Cookie de sesión persistente
- **Detección de suspensión:** No permite login si `suspended_at` está establecido
- **Registro de actividad:** Guarda `last_login_at` y crea log

### Proceso:
```php
1. Validar email y password
2. Verificar rate limit
3. Intentar autenticación
4. Verificar si usuario está suspendido
5. Regenerar sesión
6. Actualizar last_login_at
7. Registrar ActivityLog
8. Redirigir según rol (admin → dashboard, user → home)
```

## 5.3 Recuperación de Contraseña

**Ruta:** `/forgot-password` | **Controlador:** `Auth\ForgotPasswordController`

### Flujo:
1. **Solicitar reset** (`/forgot-password`)
   - Usuario ingresa email
   - Se genera token único
   - Se envía email con enlace

2. **Formulario de reset** (`/reset-password/{token}`)
   - Usuario hace clic en enlace del email
   - Ingresa nueva contraseña

3. **Procesar reset** (POST `/reset-password`)
   - Se valida token
   - Se actualiza contraseña
   - Se loguea automáticamente

---

# 6. GESTIÓN DE PRODUCTOS

## 6.1 Modelo Product

### Atributos:
```php
protected $fillable = [
    'category_id',      // FK a categories
    'name',             // Nombre
    'slug',             // URL amigable
    'description',      // Descripción HTML
    'price',            // Precio actual
    'original_price',   // Precio sin descuento
    'discount_percent', // % de descuento
    'promotion_starts', // Inicio de promoción
    'promotion_ends',   // Fin de promoción
    'promotion_label',  // Etiqueta de promo
    'image',            // Imagen principal
    'gallery',          // Array de imágenes
    'sizes',            // Array de tallas
    'colors',           // Array de colores
    'stock',            // Unidades disponibles
    'sku',              // Código único
    'is_featured',      // Destacado
    'is_active',        // Visible
    'is_new'            // Nuevo
];
```

### Accessors (Propiedades Calculadas):
```php
$product->final_price       // Precio con descuento aplicado
$product->discount_percentage // % de descuento calculado
$product->promotion_status  // Estado de la promoción
$product->average_rating    // Calificación promedio
$product->reviews_count     // Total de reseñas
$product->rating_distribution // Distribución por estrellas
```

### Relaciones:
```php
$product->category          // Categoría (belongsTo)
$product->orderItems        // Items de órdenes (hasMany)
$product->cartItems         // Items de carritos (hasMany)
$product->reviews           // Todas las reseñas (hasMany)
$product->approvedReviews   // Solo reseñas aprobadas
$product->wishlistedBy      // Usuarios que lo tienen en wishlist
```

### Métodos:
```php
$product->isOnPromotion()   // ¿Está en promoción activa?
```

## 6.2 Sistema de Reseñas

**Modelo:** `Review`

### Campos:
```php
'user_id'               // Usuario que reseña
'product_id'            // Producto reseñado
'rating'                // 1-5 estrellas
'title'                 // Título de la reseña
'comment'               // Comentario
'is_verified_purchase'  // Compra verificada
'is_approved'           // Aprobada por admin
```

### Reglas:
- Solo usuarios autenticados pueden reseñar
- Un usuario = una reseña por producto
- Se verifica automáticamente si el usuario compró el producto
- Las reseñas se aprueban automáticamente (configurable)

---

# 7. CARRITO DE COMPRAS

## 7.1 Funcionamiento

**Controlador:** `CartController`

### Características:
- Funciona para usuarios **autenticados y anónimos**
- Se guarda en base de datos (no en sesión)
- Se identifica por `user_id` o `session_id`
- Al hacer login, se migra el carrito de sesión al usuario

### Endpoints (AJAX):

| Acción | Ruta | Método | Datos |
|--------|------|--------|-------|
| Obtener | `/cart` | GET | - |
| Agregar | `/cart/add` | POST | `product_id, quantity, size?, color?` |
| Actualizar | `/cart/update` | POST | `item_id, quantity` |
| Eliminar | `/cart/remove` | POST | `item_id` |
| Vaciar | `/cart/clear` | POST | - |

### Respuesta JSON:
```json
{
    "success": true,
    "message": "Producto agregado al carrito",
    "cart": {
        "items": [...],
        "subtotal": 150.00,
        "total": 150.00,
        "count": 3
    }
}
```

## 7.2 Modelos

### Cart (Carrito)
```php
'user_id'       // Usuario (nullable para anónimos)
'session_id'    // ID de sesión
```

### CartItem (Item del carrito)
```php
'cart_id'       // FK al carrito
'product_id'    // FK al producto
'quantity'      // Cantidad
'price'         // Precio al momento de agregar
'size'          // Talla seleccionada
'color'         // Color seleccionado
'subtotal'      // Calculado: quantity * price
```

## 7.3 Validaciones

Al agregar al carrito se valida:
- Producto existe y está activo
- Hay stock suficiente
- Talla/color válidos (si aplica)
- Cantidad positiva

---

# 8. PROCESO DE CHECKOUT

## 8.1 Flujo Completo

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│   Carrito   │ ──▶ │  Checkout   │ ──▶ │    Pago     │ ──▶ │   Éxito     │
│  (/cart)    │     │ (/checkout) │     │  (PayPhone  │     │  (Orden)    │
│             │     │             │     │   o Trans)  │     │             │
└─────────────┘     └─────────────┘     └─────────────┘     └─────────────┘
```

## 8.2 Página de Checkout

**Ruta:** `/checkout` | **Controlador:** `CheckoutController`

### Datos Requeridos:
```php
// Información personal
'first_name'        // Nombre
'last_name'         // Apellido
'email'             // Correo electrónico
'phone'             // Teléfono

// Dirección de envío
'address'           // Dirección completa
'address_reference' // Referencia (opcional)
'city'              // Ciudad
'province'          // Provincia

// Pago
'payment_method'    // 'card' o 'transfer'
'payment_voucher'   // Comprobante (solo transfer)

// Adicional
'notes'             // Notas del pedido (opcional)
```

### Proceso:
1. Validar datos del formulario
2. Validar items del carrito (stock, precios)
3. Calcular totales (subtotal, envío, impuestos)
4. Crear orden en BD
5. Crear items de la orden
6. Actualizar stock de productos
7. Vaciar carrito
8. Enviar email de confirmación
9. Redirigir según método de pago

### Cálculo de Totales:
```php
$subtotal = sum(item->price * item->quantity)
$shipping = $subtotal >= 50 ? 0 : 5.99    // Envío gratis sobre $50
$tax = $subtotal * 0.12                    // IVA 12%
$total = $subtotal + $shipping + $tax
```

---

# 9. SISTEMA DE PAGOS

## 9.1 Métodos Disponibles

### a) Tarjeta de Crédito/Débito (PayPhone)

**Pasarela:** PayPhone (Ecuador)
**Ruta:** `/payment/card/{order}`

#### Flujo:
1. Usuario selecciona "Tarjeta" en checkout
2. Se crea orden con estado `pending`
3. Redirección a página de PayPhone
4. Usuario ingresa datos de tarjeta
5. PayPhone procesa el pago
6. Callback a `/payment/callback`
7. Si éxito: estado → `paid`, enviar email
8. Si fallo: estado → `payment_failed`

#### Configuración (.env):
```env
PAYPHONE_TOKEN=tu_token_aqui
PAYPHONE_STORE_ID=tu_store_id
PAYPHONE_ENV=sandbox  # o production
```

### b) Transferencia Bancaria

**Flujo:**
1. Usuario selecciona "Transferencia"
2. Sube comprobante de pago (imagen)
3. Se crea orden con estado `pending_verification`
4. Admin verifica el pago manualmente
5. Admin cambia estado a `paid`
6. Se envía email de confirmación

## 9.2 Webhook de PayPhone

**Ruta:** `/payment/webhook` (POST)

Endpoint para recibir notificaciones de PayPhone sobre el estado del pago. Excluido de verificación CSRF.

---

# 10. GESTIÓN DE PEDIDOS

## 10.1 Ciclo de Vida

```
                    ┌──────────────────┐
                    │     PENDING      │
                    │   (Pendiente)    │
                    └────────┬─────────┘
                             │
            ┌────────────────┼────────────────┐
            │                │                │
            ▼                ▼                ▼
   ┌────────────────┐ ┌─────────────┐ ┌────────────────┐
   │   PENDING_     │ │    PAID     │ │   CANCELLED    │
   │ VERIFICATION   │ │  (Pagado)   │ │  (Cancelado)   │
   └───────┬────────┘ └──────┬──────┘ └────────────────┘
           │                 │
           └────────┬────────┘
                    ▼
           ┌────────────────┐
           │  PROCESSING    │
           │ (Procesando)   │
           └───────┬────────┘
                   │
                   ▼
           ┌────────────────┐
           │    SHIPPED     │
           │   (Enviado)    │
           └───────┬────────┘
                   │
                   ▼
           ┌────────────────┐
           │   DELIVERED    │
           │  (Entregado)   │
           └────────────────┘
```

## 10.2 Modelo Order

### Campos Principales:
```php
'order_number'      // Número único (ORD-XXXXXXXX-timestamp)
'user_id'           // Usuario (nullable para invitados)
'customer_name'     // Nombre completo
'customer_email'    // Email
'customer_phone'    // Teléfono
'shipping_address'  // Dirección
'address_reference' // Referencia
'city'              // Ciudad
'province'          // Provincia
'subtotal'          // Subtotal
'shipping_cost'     // Costo de envío
'tax'               // Impuestos
'total'             // Total
'status'            // Estado actual
'payment_method'    // Método de pago
'payment_id'        // ID de transacción (PayPhone)
'payment_voucher'   // Comprobante (transferencia)
'notes'             // Notas del cliente
'ip_address'        // IP del cliente
'user_agent'        // Navegador
'shipped_at'        // Fecha de envío
'delivered_at'      // Fecha de entrega
'paid_at'           // Fecha de pago
```

## 10.3 OrderItem

```php
'order_id'          // FK a la orden
'product_id'        // FK al producto
'product_name'      // Nombre (snapshot)
'product_sku'       // SKU (snapshot)
'quantity'          // Cantidad
'price'             // Precio unitario
'size'              // Talla
'color'             // Color
'total'             // Subtotal del item
```

---

# 11. SISTEMA DE CORREOS

## 11.1 Emails Automáticos

### a) Confirmación de Pedido
**Trigger:** Al crear una orden exitosamente
**Plantilla:** `emails/orders/confirmation.blade.php`

**Contenido:**
- Número de orden
- Resumen de productos
- Totales
- Dirección de envío
- Método de pago
- Botón para ver estado

### b) Actualización de Estado
**Trigger:** Al cambiar estado de orden (desde admin)
**Plantilla:** `emails/orders/status-updated.blade.php`

**Contenido:**
- Icono según estado (emojis)
- Mensaje personalizado por estado
- Número de orden
- Nuevo estado
- Total
- Botón para ver detalle

### c) Restablecimiento de Contraseña
**Trigger:** Al solicitar reset de password
**Plantilla:** `emails/auth/reset-password.blade.php`

**Contenido:**
- Enlace con token único
- Expiración del enlace (60 minutos)
- Instrucciones

## 11.2 Configuración SMTP

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@threadly.com
MAIL_FROM_NAME="THREADLY"
```

## 11.3 Envío de Emails

```php
// En CheckoutController
Mail::to($order->customer_email)->send(new OrderConfirmation($order));

// En OrderController (admin)
Mail::to($order->customer_email)->send(new OrderStatusUpdated($order));
```

---

# 12. FUNCIONALIDADES ADICIONALES

## 12.1 Sistema de Actividad (Activity Logs)

**Modelo:** `ActivityLog`

### Eventos Registrados:
- Login de usuario
- Logout de usuario
- Actualización de perfil
- Cambio de contraseña
- Creación de reseña
- Acciones de admin (CRUD usuarios, cambios de estado)

### Campos:
```php
'user_id'       // Usuario que realizó la acción
'action'        // Tipo de acción
'model_type'    // Modelo afectado (ej: User::class)
'model_id'      // ID del modelo
'description'   // Descripción legible
'old_values'    // Valores anteriores (JSON)
'new_values'    // Valores nuevos (JSON)
'ip_address'    // IP del usuario
'user_agent'    // Navegador
```

### Uso:
```php
ActivityLog::log('login', $user);
ActivityLog::log('profile_updated', 'Usuario actualizó su perfil');
ActivityLog::log('user_suspended', $user, null, ['suspended_at' => now()]);
```

## 12.2 Rate Limiting

### Configuración en `AppServiceProvider`:

```php
// Carrito: 30 requests por minuto
RateLimiter::for('cart', function (Request $request) {
    return Limit::perMinute(30)->by($request->ip());
});

// Login: 5 intentos por minuto
// (implementado en LoginController)
```

## 12.3 Páginas Estáticas

| Página | Ruta | Controlador |
|--------|------|-------------|
| Términos | `/terminos-y-condiciones` | `PageController@terms` |
| Privacidad | `/politica-de-privacidad` | `PageController@privacy` |
| Sobre nosotros | `/sobre-nosotros` | `PageController@about` |
| Contacto | `/contacto` | `PageController@contact` |

### Formulario de Contacto:
- Nombre
- Email
- Asunto
- Mensaje
- Rate limiting aplicado

---

# 13. BASE DE DATOS

## 13.1 Diagrama de Tablas

```
┌─────────────┐       ┌─────────────┐       ┌─────────────┐
│   users     │       │  products   │       │ categories  │
├─────────────┤       ├─────────────┤       ├─────────────┤
│ id          │       │ id          │       │ id          │
│ name        │       │ category_id │◄──────│ name        │
│ email       │       │ name        │       │ slug        │
│ password    │       │ slug        │       │ description │
│ phone       │       │ description │       │ image       │
│ avatar      │       │ price       │       │ is_active   │
│ birth_date  │       │ stock       │       └─────────────┘
│ is_admin    │       │ image       │
│ suspended_at│       │ is_active   │
└──────┬──────┘       └──────┬──────┘
       │                     │
       │    ┌────────────────┼────────────────┐
       │    │                │                │
       ▼    ▼                ▼                ▼
┌─────────────┐       ┌─────────────┐  ┌─────────────┐
│   orders    │       │   reviews   │  │  wishlists  │
├─────────────┤       ├─────────────┤  ├─────────────┤
│ id          │       │ id          │  │ id          │
│ user_id     │◄──────│ user_id     │  │ user_id     │
│ order_number│       │ product_id  │  │ product_id  │
│ status      │       │ rating      │  │ created_at  │
│ total       │       │ comment     │  └─────────────┘
│ ...         │       │ is_approved │
└──────┬──────┘       └─────────────┘
       │
       ▼
┌─────────────┐       ┌─────────────┐
│ order_items │       │    carts    │
├─────────────┤       ├─────────────┤
│ id          │       │ id          │
│ order_id    │       │ user_id     │
│ product_id  │       │ session_id  │
│ quantity    │       └──────┬──────┘
│ price       │              │
└─────────────┘              ▼
                      ┌─────────────┐
                      │ cart_items  │
                      ├─────────────┤
                      │ id          │
                      │ cart_id     │
                      │ product_id  │
                      │ quantity    │
                      └─────────────┘

┌─────────────┐       ┌───────────────┐
│  addresses  │       │ activity_logs │
├─────────────┤       ├───────────────┤
│ id          │       │ id            │
│ user_id     │       │ user_id       │
│ name        │       │ action        │
│ address     │       │ model_type    │
│ city        │       │ model_id      │
│ province    │       │ old_values    │
│ is_default  │       │ new_values    │
└─────────────┘       └───────────────┘
```

## 13.2 Migraciones

```
database/migrations/
├── 0001_01_01_000000_create_users_table.php
├── 0001_01_01_000001_create_cache_table.php
├── 0001_01_01_000002_create_jobs_table.php
├── 2025_12_12_194914_create_categories_table.php
├── 2025_12_12_194915_create_products_table.php
├── 2025_12_12_194916_create_orders_table.php
├── 2025_12_12_194917_create_carts_table.php
├── 2025_12_12_194918_create_order_items_table.php
├── 2025_12_12_194919_create_cart_items_table.php
├── 2025_12_12_200632_add_is_admin_to_users_table.php
├── 2025_12_12_212412_add_promotion_fields_to_products_table.php
├── 2026_01_03_000001_update_orders_table_add_fields.php
├── 2026_01_03_000002_add_product_sku_to_order_items_table.php
├── 2026_01_03_000003_add_payment_voucher_to_orders_table.php
├── 2026_01_15_000001_create_wishlists_table.php
├── 2026_01_15_000002_create_addresses_table.php
├── 2026_01_15_000003_create_reviews_table.php
├── 2026_01_15_000004_create_activity_logs_table.php
├── 2026_01_15_000005_add_profile_fields_to_users_table.php
└── 2026_01_15_000006_add_suspended_at_to_users_table.php
```

---

# 14. SEGURIDAD

## 14.1 Medidas Implementadas

### Autenticación:
- ✅ Contraseñas hasheadas (bcrypt)
- ✅ Rate limiting en login (5 intentos/minuto)
- ✅ Tokens CSRF en formularios
- ✅ Regeneración de sesión al login
- ✅ Sistema de suspensión de usuarios

### Autorización:
- ✅ Middleware `auth` para rutas protegidas
- ✅ Middleware `admin` para panel de administración
- ✅ Verificación de propiedad en recursos (orders, addresses, reviews)

### Validación:
- ✅ Validación de inputs en todos los formularios
- ✅ Sanitización de datos
- ✅ Tipos de archivo permitidos para uploads

### Protección de Rutas:
```php
// Rutas públicas (sin auth)
Route::get('/productos', ...)

// Rutas para invitados (sin login)
Route::middleware('guest')->group(...)

// Rutas autenticadas
Route::middleware('auth')->group(...)

// Rutas de admin
Route::middleware(['auth', 'admin'])->group(...)
```

## 14.2 Middleware AdminMiddleware

```php
class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if (!Auth::check() || !$user || !$user->is_admin) {
            abort(403, 'Acceso no autorizado');
        }

        return $next($request);
    }
}
```

---

# 15. SEO Y MARKETING

## 15.1 SeoService

**Ubicación:** `app/Services/SeoService.php`

### Uso:
```php
$seo = new SeoService();
$seo->setTitle('Camisetas de Algodón')
    ->setDescription('Las mejores camisetas...')
    ->setImage('images/camisetas.jpg')
    ->setKeywords(['camisetas', 'ropa', 'moda']);
```

### Meta Tags Generados:
- Title
- Description
- Keywords
- Open Graph (Facebook)
- Twitter Cards
- Canonical URL
- Robots directives

## 15.2 Sitemap Dinámico

**Ruta:** `/sitemap.xml` | **Controlador:** `SitemapController`

### Contenido:
- Página principal
- Listado de productos
- Páginas de productos individuales
- Categorías
- Páginas estáticas (términos, privacidad, etc.)

### Formato:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://threadly.com/</loc>
        <lastmod>2026-01-15T00:00:00+00:00</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    ...
</urlset>
```

---

# 16. API Y RUTAS

## 16.1 Resumen de Rutas

### Rutas Públicas:
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/` | Página principal |
| GET | `/productos` | Catálogo |
| GET | `/productos/{slug}` | Detalle producto |
| GET | `/sitemap.xml` | Sitemap SEO |
| GET | `/terminos-y-condiciones` | Términos |
| GET | `/politica-de-privacidad` | Privacidad |
| GET | `/sobre-nosotros` | Sobre nosotros |
| GET | `/contacto` | Contacto |
| POST | `/contacto` | Enviar contacto |

### Rutas del Carrito (públicas):
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/cart` | Obtener carrito |
| POST | `/cart/add` | Agregar producto |
| POST | `/cart/update` | Actualizar cantidad |
| POST | `/cart/remove` | Eliminar item |
| POST | `/cart/clear` | Vaciar carrito |

### Rutas de Checkout:
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/checkout` | Página de checkout |
| POST | `/checkout` | Procesar compra |
| GET | `/pedido/{order}/exito` | Orden exitosa |

### Rutas de Pago:
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/payment/card/{order}` | Pago con tarjeta |
| POST | `/payment/card/{order}` | Procesar pago |
| GET | `/payment/callback` | Callback PayPhone |
| GET | `/payment/cancel` | Cancelar pago |
| POST | `/payment/webhook` | Webhook PayPhone |

### Rutas de Autenticación:
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/login` | Formulario login |
| POST | `/login` | Procesar login |
| GET | `/register` | Formulario registro |
| POST | `/register` | Procesar registro |
| POST | `/logout` | Cerrar sesión |
| GET | `/forgot-password` | Olvidé contraseña |
| POST | `/forgot-password` | Enviar email reset |
| GET | `/reset-password/{token}` | Form reset |
| POST | `/reset-password` | Procesar reset |

### Rutas de Perfil (auth):
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/perfil` | Ver perfil |
| GET | `/perfil/editar` | Editar perfil |
| PUT | `/perfil/editar` | Guardar cambios |
| GET | `/perfil/cambiar-password` | Cambiar password |
| PUT | `/perfil/cambiar-password` | Guardar password |
| GET | `/perfil/direcciones` | Ver direcciones |
| POST | `/perfil/direcciones` | Agregar dirección |
| PUT | `/perfil/direcciones/{id}` | Editar dirección |
| DELETE | `/perfil/direcciones/{id}` | Eliminar dirección |
| POST | `/perfil/direcciones/{id}/default` | Predeterminar |

### Rutas de Wishlist (auth):
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/wishlist` | Ver wishlist |
| POST | `/wishlist/toggle/{product}` | Agregar/quitar |
| POST | `/wishlist/add/{product}` | Agregar |
| DELETE | `/wishlist/remove/{product}` | Eliminar |
| DELETE | `/wishlist/clear` | Vaciar |
| GET | `/wishlist/count` | Contar items |

### Rutas de Pedidos (auth):
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/mis-pedidos` | Listar pedidos |
| GET | `/mis-pedidos/{order}` | Ver pedido |
| PUT | `/mis-pedidos/{order}/cancelar` | Cancelar |

### Rutas de Admin:
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/admin` | Dashboard |
| GET | `/admin/charts/*` | Datos de gráficos |
| CRUD | `/admin/products` | Productos |
| CRUD | `/admin/categories` | Categorías |
| GET/PUT | `/admin/orders` | Pedidos |
| * | `/admin/promotions` | Promociones |
| CRUD | `/admin/users` | Usuarios |
| GET | `/admin/export/*` | Exportaciones |

---

# 📝 NOTAS FINALES

## Comandos Útiles

```bash
# Instalar dependencias
composer install
npm install

# Migraciones
php artisan migrate

# Seeders
php artisan db:seed

# Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Desarrollo
php artisan serve
npm run dev

# Producción
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Variables de Entorno Requeridas

```env
APP_NAME=THREADLY
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=threadly
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@threadly.com
MAIL_FROM_NAME="${APP_NAME}"

PAYPHONE_TOKEN=
PAYPHONE_STORE_ID=
PAYPHONE_ENV=production
```

---

**Documentación generada el:** 15 de Enero de 2026
**Versión del sistema:** 1.0.0
**Framework:** Laravel 12
**PHP:** 8.2+
