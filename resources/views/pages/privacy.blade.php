@extends('layouts.app')

@section('title', 'Política de Privacidad - THREADLY')

@section('content')
<section class="page-header" style="padding: 140px 0 60px;">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="hero-title text-white" style="font-size: 2.5rem;">
            <i class="bi bi-shield-lock me-3"></i>Política de Privacidad
        </h1>
        <p class="text-white-50">Última actualización: {{ now()->format('d/m/Y') }}</p>
    </div>
</section>

<section class="section-premium" style="background: var(--light);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card-premium p-5">
                    <h2 class="mb-4">1. Información que Recopilamos</h2>
                    <p>En THREADLY recopilamos información que usted nos proporciona directamente cuando:</p>
                    <ul>
                        <li>Crea una cuenta de usuario</li>
                        <li>Realiza una compra</li>
                        <li>Se suscribe a nuestro boletín</li>
                        <li>Se comunica con nosotros</li>
                    </ul>
                    <p>Esta información puede incluir:</p>
                    <ul>
                        <li>Nombre completo</li>
                        <li>Dirección de correo electrónico</li>
                        <li>Número de teléfono</li>
                        <li>Dirección de envío</li>
                        <li>Información de pago (procesada de forma segura por terceros)</li>
                    </ul>

                    <h2 class="mb-4 mt-5">2. Uso de la Información</h2>
                    <p>Utilizamos la información recopilada para:</p>
                    <ul>
                        <li>Procesar y enviar sus pedidos</li>
                        <li>Comunicarnos con usted sobre su pedido</li>
                        <li>Enviar actualizaciones y ofertas promocionales (si lo autoriza)</li>
                        <li>Mejorar nuestros servicios y experiencia de usuario</li>
                        <li>Prevenir fraudes y garantizar la seguridad</li>
                    </ul>

                    <h2 class="mb-4 mt-5">3. Protección de Datos</h2>
                    <p>Implementamos medidas de seguridad técnicas y organizativas para proteger su información personal:</p>
                    <ul>
                        <li>Encriptación SSL en todas las transacciones</li>
                        <li>Almacenamiento seguro de datos</li>
                        <li>Acceso restringido a información personal</li>
                        <li>Auditorías de seguridad regulares</li>
                    </ul>

                    <h2 class="mb-4 mt-5">4. Compartir Información</h2>
                    <p>No vendemos ni alquilamos su información personal a terceros. Solo compartimos información con:</p>
                    <ul>
                        <li><strong>Proveedores de servicios:</strong> Empresas de envío, procesadores de pago</li>
                        <li><strong>Requerimientos legales:</strong> Cuando sea requerido por ley</li>
                    </ul>

                    <h2 class="mb-4 mt-5">5. Cookies</h2>
                    <p>Utilizamos cookies para:</p>
                    <ul>
                        <li>Mantener su sesión activa</li>
                        <li>Recordar su carrito de compras</li>
                        <li>Analizar el tráfico del sitio</li>
                        <li>Personalizar su experiencia</li>
                    </ul>
                    <p>Puede configurar su navegador para rechazar cookies, aunque esto puede afectar la funcionalidad del sitio.</p>

                    <h2 class="mb-4 mt-5">6. Sus Derechos</h2>
                    <p>Usted tiene derecho a:</p>
                    <ul>
                        <li>Acceder a su información personal</li>
                        <li>Rectificar datos incorrectos</li>
                        <li>Solicitar la eliminación de sus datos</li>
                        <li>Oponerse al procesamiento de sus datos</li>
                        <li>Retirar su consentimiento en cualquier momento</li>
                    </ul>

                    <h2 class="mb-4 mt-5">7. Retención de Datos</h2>
                    <p>Conservamos su información personal mientras tenga una cuenta activa o según sea necesario para proporcionarle servicios. También conservamos y usamos su información según sea necesario para cumplir con obligaciones legales.</p>

                    <h2 class="mb-4 mt-5">8. Menores de Edad</h2>
                    <p>Nuestro sitio web no está dirigido a menores de 18 años. No recopilamos intencionalmente información de menores de edad.</p>

                    <h2 class="mb-4 mt-5">9. Cambios en la Política</h2>
                    <p>Podemos actualizar esta política de privacidad periódicamente. Le notificaremos sobre cambios significativos publicando la nueva política en nuestro sitio web.</p>

                    <h2 class="mb-4 mt-5">10. Contacto</h2>
                    <p>Para ejercer sus derechos o consultas sobre privacidad:</p>
                    <ul>
                        <li><strong>Email:</strong> privacidad@threadly.ec</li>
                        <li><strong>Teléfono:</strong> +593 99 123 4567</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
