@extends('layouts.app')

@section('title', '¡Pedido Exitoso! - THREADLY')

@section('content')
<section class="py-5" style="min-height: 100vh; background: var(--gradient-hero); position: relative; overflow: hidden; padding-top: 120px !important;">
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <!-- Icono de éxito animado -->
                <div class="success-animation mb-5">
                    <div class="success-checkmark">
                        <div class="check-icon">
                            <span class="icon-line line-tip"></span>
                            <span class="icon-line line-long"></span>
                            <div class="icon-circle"></div>
                            <div class="icon-fix"></div>
                        </div>
                    </div>
                </div>

                <h1 class="display-4 fw-bold text-white mb-3">¡Gracias por tu compra!</h1>
                <p class="lead text-white-50 mb-5">
                    Tu pedido ha sido procesado exitosamente. Recibirás un email de confirmación en breve.
                </p>

                <!-- Detalles del pedido -->
                <div class="card-premium p-4 p-md-5 text-start mb-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <h5 class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-receipt" style="color: var(--accent);"></i>
                                Detalles del Pedido
                            </h5>
                            <div class="mb-2">
                                <span class="text-muted">Número de orden:</span>
                                <span class="fw-bold ms-2">{{ $order->order_number ?? 'N/A' }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Fecha:</span>
                                <span class="ms-2">{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Estado:</span>
                                <span class="badge bg-{{ $order->status_color ?? 'warning' }} ms-2">{{ $order->status_label ?? 'Pendiente' }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Método de pago:</span>
                                <span class="ms-2">{{ $order->payment_method_label ?? 'No especificado' }}</span>
                            </div>
                            <div>
                                <span class="text-muted">Total:</span>
                                <span class="fw-bold text-primary ms-2" style="font-size: 1.25rem;">${{ number_format($order->total ?? 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-truck" style="color: var(--accent);"></i>
                                Información de Envío
                            </h5>
                            <div class="mb-2">
                                <span class="text-muted">Nombre:</span>
                                <span class="ms-2">{{ $order->customer_name ?? 'Cliente' }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Email:</span>
                                <span class="ms-2">{{ $order->customer_email ?? '' }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Teléfono:</span>
                                <span class="ms-2">{{ $order->customer_phone ?? '' }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Dirección:</span>
                                <span class="ms-2">{{ $order->shipping_address ?? 'Por confirmar' }}</span>
                            </div>
                            <div>
                                <span class="text-muted">Ciudad:</span>
                                <span class="ms-2">{{ $order->city ?? '' }}{{ $order->province ? ', ' . $order->province : '' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Items del pedido -->
                    <hr class="my-4">
                    <h5 class="mb-4 d-flex align-items-center gap-2">
                        <i class="bi bi-box" style="color: var(--accent);"></i>
                        Productos ({{ $order->items ? $order->items->count() : 0 }})
                    </h5>
                    
                    @if(isset($order->items) && $order->items->count() > 0)
                        <div style="max-height: 300px; overflow-y: auto;">
                            @foreach($order->items as $item)
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    @php
                                        $imageUrl = null;
                                        if ($item->product && $item->product->image) {
                                            $imageUrl = str_starts_with($item->product->image, 'http') 
                                                ? $item->product->image 
                                                : asset('storage/' . $item->product->image);
                                        }
                                    @endphp
                                    <div class="me-3 flex-shrink-0" style="width: 60px; height: 60px; border-radius: 12px; overflow: hidden; background: #f1f5f9;">
                                        @if($imageUrl)
                                            <img src="{{ $imageUrl }}" 
                                                 alt="{{ $item->product_name ?? 'Producto' }}" 
                                                 class="w-100 h-100" 
                                                 style="object-fit: cover;"
                                                 onerror="this.style.display='none'">
                                        @else
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <h6 class="mb-0 text-truncate">{{ $item->product_name ?? 'Producto' }}</h6>
                                        <small class="text-muted">
                                            @if($item->size) Talla: {{ $item->size }} @endif
                                            @if($item->color) 
                                                @if($item->size) | @endif
                                                <span class="color-indicator" data-color="{{ $item->color }}"></span>
                                            @endif
                                            <br>
                                            Cantidad: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                        </small>
                                    </div>
                                    <div class="fw-bold text-end">
                                        ${{ number_format($item->total ?? ($item->quantity * $item->price), 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Totales -->
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span>${{ number_format($order->subtotal ?? 0, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Envío</span>
                                <span>{{ ($order->shipping_cost ?? 0) > 0 ? '$' . number_format($order->shipping_cost, 2) : 'Gratis' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">IVA (12%)</span>
                                <span>${{ number_format($order->tax ?? 0, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong style="font-size: 1.1rem;">Total</strong>
                                <strong style="font-size: 1.3rem; color: var(--primary);">${{ number_format($order->total ?? 0, 2) }}</strong>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="bi bi-check-circle fs-1 text-success"></i>
                            <p class="mt-2">Tu pedido ha sido registrado correctamente</p>
                        </div>
                    @endif
                </div>

                <!-- Siguiente pasos -->
                <div class="card-premium p-4 p-md-5 mb-5" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="mb-4">¿Qué sigue?</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="text-center">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" 
                                     style="width: 60px; height: 60px; background: rgba(20, 184, 166, 0.2);">
                                    <i class="bi bi-envelope-check fs-4" style="color: var(--accent);"></i>
                                </div>
                                <h6>Email de Confirmación</h6>
                                <p class="text-muted small mb-0">Recibirás los detalles de tu pedido en tu correo</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="text-center">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" 
                                     style="width: 60px; height: 60px; background: rgba(20, 184, 166, 0.2);">
                                    <i class="bi bi-box-seam fs-4" style="color: var(--accent);"></i>
                                </div>
                                <h6>Preparación</h6>
                                <p class="text-muted small mb-0">Empezaremos a preparar tu pedido inmediatamente</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" 
                                     style="width: 60px; height: 60px; background: rgba(20, 184, 166, 0.2);">
                                    <i class="bi bi-truck fs-4" style="color: var(--accent);"></i>
                                </div>
                                <h6>Envío</h6>
                                <p class="text-muted small mb-0">Te notificaremos cuando tu pedido sea enviado</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    @auth
                        <a href="{{ route('orders.index') }}" class="btn btn-premium btn-outline-premium px-4" style="border-color: rgba(255,255,255,0.3); color: white;">
                            <i class="bi bi-list-ul me-2"></i>Ver Mis Pedidos
                        </a>
                    @endauth
                    <a href="{{ route('products.index') }}" class="btn btn-premium btn-primary-premium px-4">
                        <i class="bi bi-bag me-2"></i>Seguir Comprando
                    </a>
                </div>

                <!-- Redes sociales -->
                <div class="mt-5 pt-5 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
                    <p class="text-white-50 mb-3">Síguenos para más novedades</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#" class="btn rounded-circle d-flex align-items-center justify-content-center" 
                           style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); color: white;">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="btn rounded-circle d-flex align-items-center justify-content-center" 
                           style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); color: white;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="btn rounded-circle d-flex align-items-center justify-content-center" 
                           style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); color: white;">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="#" class="btn rounded-circle d-flex align-items-center justify-content-center" 
                           style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); color: white;">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Success Animation */
    .success-animation {
        margin: 0 auto;
    }

    .success-checkmark {
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }

    .success-checkmark .check-icon {
        width: 120px;
        height: 120px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid var(--accent);
        animation: checkmark-circle 0.6s ease-in-out;
    }

    .success-checkmark .check-icon::before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
        border-radius: 100px 0 0 100px;
    }

    .success-checkmark .check-icon::after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
        border-radius: 0 100px 100px 0;
        animation: checkmark-circle-fill 0.4s ease-in-out 0.4s forwards;
    }

    .success-checkmark .check-icon::before,
    .success-checkmark .check-icon::after {
        content: '';
        height: 100px;
        position: absolute;
        background: var(--gradient-hero);
        transform: rotate(-45deg);
    }

    .success-checkmark .check-icon .icon-line {
        height: 5px;
        background-color: var(--accent);
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }

    .success-checkmark .check-icon .icon-line.line-tip {
        top: 62px;
        left: 28px;
        width: 25px;
        transform: rotate(45deg);
        animation: checkmark-line-tip 0.75s forwards;
    }

    .success-checkmark .check-icon .icon-line.line-long {
        top: 54px;
        right: 18px;
        width: 47px;
        transform: rotate(-45deg);
        animation: checkmark-line-long 0.75s forwards;
    }

    .success-checkmark .check-icon .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        position: absolute;
        box-sizing: content-box;
        border: 4px solid rgba(20, 184, 166, 0.3);
    }

    .success-checkmark .check-icon .icon-fix {
        top: 8px;
        width: 5px;
        left: 52px;
        z-index: 1;
        height: 85px;
        position: absolute;
        transform: rotate(-45deg);
        background-color: transparent;
    }

    @keyframes checkmark-line-tip {
        0% { width: 0; left: 1px; top: 19px; }
        54% { width: 0; left: 1px; top: 19px; }
        70% { width: 50px; left: 10px; top: 66px; }
        84% { width: 17px; left: 31px; top: 60px; }
        100% { width: 25px; left: 28px; top: 62px; }
    }

    @keyframes checkmark-line-long {
        0% { width: 0; right: 46px; top: 54px; }
        65% { width: 0; right: 46px; top: 54px; }
        84% { width: 55px; right: 0; top: 45px; }
        100% { width: 47px; right: 18px; top: 54px; }
    }

    @keyframes checkmark-circle {
        0% { stroke-dashoffset: 480; }
        100% { stroke-dashoffset: 960; }
    }

    @keyframes checkmark-circle-fill {
        0% { box-shadow: inset 0 0 0 var(--accent); }
        100% { box-shadow: inset 0 0 0 80px transparent; }
    }

    .min-width-0 {
        min-width: 0;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.color-indicator[data-color]').forEach(function(el) {
        el.style.cssText = 'display:inline-block;width:12px;height:12px;border-radius:50%;background:' + el.dataset.color + ';vertical-align:middle;border:1px solid #ddd;';
    });
});
</script>
@endpush
