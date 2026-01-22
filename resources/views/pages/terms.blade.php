@extends('layouts.app')

@section('title', 'Términos y Condiciones - THREADLY')

@section('content')
<section class="page-header" style="padding: 140px 0 60px;">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="hero-title text-white" style="font-size: 2.5rem;">
            <i class="bi bi-file-earmark-text me-3"></i>Términos y Condiciones
        </h1>
        <p class="text-white-50">Última actualización: {{ now()->format('d/m/Y') }}</p>
    </div>
</section>

<section class="section-premium" style="background: var(--light);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card-premium p-5">
                    <h2 class="mb-4">1. Aceptación de los Términos</h2>
                    <p>Al acceder y utilizar el sitio web de THREADLY, usted acepta estar sujeto a estos términos y condiciones de uso, todas las leyes y regulaciones aplicables, y acepta que es responsable del cumplimiento de las leyes locales aplicables.</p>

                    <h2 class="mb-4 mt-5">2. Uso del Sitio</h2>
                    <p>Se le concede permiso para descargar temporalmente una copia de los materiales (información o software) en el sitio web de THREADLY para visualización transitoria personal y no comercial únicamente. Esta es la concesión de una licencia, no una transferencia de título.</p>
                    <p>Bajo esta licencia usted no puede:</p>
                    <ul>
                        <li>Modificar o copiar los materiales</li>
                        <li>Usar los materiales para cualquier propósito comercial</li>
                        <li>Intentar descompilar o realizar ingeniería inversa de cualquier software contenido en el sitio</li>
                        <li>Eliminar cualquier derecho de autor u otras notaciones de propiedad de los materiales</li>
                    </ul>

                    <h2 class="mb-4 mt-5">3. Productos y Precios</h2>
                    <p>Todos los productos mostrados en nuestro sitio web están sujetos a disponibilidad. Los precios están expresados en dólares estadounidenses (USD) e incluyen IVA (12%).</p>
                    <p>THREADLY se reserva el derecho de modificar los precios sin previo aviso. Sin embargo, los pedidos confirmados mantendrán el precio acordado al momento de la compra.</p>

                    <h2 class="mb-4 mt-5">4. Proceso de Compra</h2>
                    <p>Para realizar una compra en THREADLY, deberá:</p>
                    <ul>
                        <li>Seleccionar los productos deseados y agregarlos al carrito</li>
                        <li>Proporcionar información de envío válida y completa</li>
                        <li>Seleccionar un método de pago y completar la transacción</li>
                        <li>Recibirá una confirmación por correo electrónico una vez procesado el pedido</li>
                    </ul>

                    <h2 class="mb-4 mt-5">5. Envíos</h2>
                    <p>Realizamos envíos a todo Ecuador. Los tiempos de entrega estimados son:</p>
                    <ul>
                        <li><strong>Quito y Guayaquil:</strong> 1-3 días hábiles</li>
                        <li><strong>Otras ciudades principales:</strong> 3-5 días hábiles</li>
                        <li><strong>Zonas rurales:</strong> 5-7 días hábiles</li>
                    </ul>
                    <p>El envío es <strong>GRATIS</strong> en compras mayores a $50.</p>

                    <h2 class="mb-4 mt-5">6. Devoluciones y Cambios</h2>
                    <p>Aceptamos devoluciones y cambios dentro de los 30 días posteriores a la recepción del producto, siempre que:</p>
                    <ul>
                        <li>El producto esté sin usar y en su empaque original</li>
                        <li>Conserve las etiquetas originales</li>
                        <li>Presente el comprobante de compra</li>
                    </ul>

                    <h2 class="mb-4 mt-5">7. Limitación de Responsabilidad</h2>
                    <p>THREADLY no será responsable de ningún daño (incluyendo, sin limitación, daños por pérdida de datos o beneficio, o debido a la interrupción del negocio) que surja del uso o la imposibilidad de usar los materiales en el sitio web de THREADLY.</p>

                    <h2 class="mb-4 mt-5">8. Modificaciones</h2>
                    <p>THREADLY puede revisar estos términos de servicio del sitio web en cualquier momento sin previo aviso. Al usar este sitio web, usted acepta estar sujeto a la versión actual de estos términos y condiciones de uso.</p>

                    <h2 class="mb-4 mt-5">9. Ley Aplicable</h2>
                    <p>Estos términos y condiciones se rigen e interpretan de acuerdo con las leyes de la República del Ecuador y usted se somete irrevocablemente a la jurisdicción exclusiva de los tribunales de dicho país.</p>

                    <h2 class="mb-4 mt-5">10. Contacto</h2>
                    <p>Si tiene preguntas sobre estos Términos y Condiciones, contáctenos:</p>
                    <ul>
                        <li><strong>Email:</strong> legal@threadly.ec</li>
                        <li><strong>Teléfono:</strong> +593 99 123 4567</li>
                        <li><strong>Dirección:</strong> Quito, Ecuador</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
