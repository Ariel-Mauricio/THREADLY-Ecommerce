@extends('layouts.app')

@section('title', 'Pedido ' . ($order->order_number ?? '#' . str_pad($order->id ?? 1, 6, '0', STR_PAD_LEFT)) . ' - THREADLY')

@push('styles')
<style>
    .profile-section {
        min-height: 100vh;
        background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #0f0f1a 100%);
        padding-top: 120px !important;
    }
    .order-card {
        background: rgba(255,255,255,0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
    }
    .breadcrumb {
        background: transparent;
        padding: 0;
    }
    .breadcrumb-item a {
        color: #a855f7;
    }
    .breadcrumb-item.active {
        color: rgba(255,255,255,0.5);
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.3);
    }
    .badge-status {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    .badge-pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; }
    .badge-processing { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .badge-shipped { background: rgba(168, 85, 247, 0.15); color: #a855f7; }
    .badge-delivered { background: rgba(34, 197, 94, 0.15); color: #22c55e; }
    .badge-cancelled { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
    
    .section-title {
        color: #fff;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }
    .section-title i {
        color: #a855f7;
    }
    .text-gradient {
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: rgba(255,255,255,0.1);
    }
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    .timeline-marker {
        position: absolute;
        left: -30px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: rgba(255,255,255,0.3);
    }
    .timeline-item.active .timeline-marker {
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        color: white;
    }
    .timeline-item.active .timeline-content h6 {
        color: white;
    }
    .timeline-content h6 {
        color: rgba(255,255,255,0.5);
        margin-bottom: 4px;
    }
    .timeline-content p {
        color: rgba(255,255,255,0.4);
        font-size: 0.85rem;
    }
    /* Product items */
    .product-item {
        display: flex;
        align-items: center;
        padding: 16px 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .product-item:last-child {
        border-bottom: none;
    }
    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        margin-right: 16px;
        background: rgba(255,255,255,0.05);
    }
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-info h6 {
        color: #fff;
        margin-bottom: 4px;
    }
    .product-info small {
        color: rgba(255,255,255,0.5);
    }
    .product-price {
        text-align: right;
    }
    .product-price .unit {
        color: rgba(255,255,255,0.5);
        font-size: 0.85rem;
    }
    .product-price .total {
        color: #fff;
        font-weight: 600;
    }
    /* Summary */
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        color: rgba(255,255,255,0.7);
    }
    .summary-row.total {
        padding-top: 16px;
        margin-top: 8px;
        border-top: 1px solid rgba(255,255,255,0.1);
        font-size: 1.1rem;
        font-weight: 600;
    }
    .summary-row.total span:last-child {
        color: #a855f7;
    }
    /* Buttons */
    .btn-primary-custom {
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        border: none;
        color: #fff;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        width: 100%;
    }
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(168, 85, 247, 0.3);
        color: #fff;
    }
    .btn-outline-custom {
        background: transparent;
        border: 1px solid rgba(255,255,255,0.2);
        color: rgba(255,255,255,0.7);
        padding: 12px 20px;
        border-radius: 10px;
        width: 100%;
    }
    .btn-outline-custom:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
    }
    .btn-danger-custom {
        background: transparent;
        border: 1px solid rgba(239, 68, 68, 0.5);
        color: #ef4444;
        padding: 12px 20px;
        border-radius: 10px;
        width: 100%;
    }
    .btn-danger-custom:hover {
        background: rgba(239, 68, 68, 0.15);
        border-color: #ef4444;
    }
    .btn-whatsapp {
        background: #25d366;
        border: none;
        color: #fff;
        padding: 12px 20px;
        border-radius: 10px;
        width: 100%;
        font-weight: 500;
    }
    .btn-whatsapp:hover {
        background: #1da851;
        color: #fff;
    }
    /* Modal */
    .modal-content {
        background: #1a1a2e;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
    }
    .modal-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 20px 24px;
    }
    .modal-title {
        color: #fff;
    }
    .modal-body {
        padding: 24px;
        color: rgba(255,255,255,0.8);
    }
    .modal-footer {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding: 16px 24px;
    }
    .btn-close {
        filter: invert(1);
    }
    @media print {
        .btn, .modal, nav { display: none !important; }
        .order-card { background: white !important; color: black !important; }
    }
</style>
@endpush

@section('content')
<section class="profile-section py-5">
    <div class="container">
        @include('partials.user-nav', ['pageTitle' => 'Detalle del Pedido'])
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Mis Pedidos</a></li>
                <li class="breadcrumb-item active">{{ $order->order_number ?? '#' . str_pad($order->id ?? 1, 6, '0', STR_PAD_LEFT) }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- Columna principal -->
            <div class="col-lg-8">
                <!-- Header del pedido -->
                <div class="order-card">
                    <div class="d-flex flex-wrap justify-content-between align-items-start">
                        <div>
                            <h2 class="text-white mb-2">
                                Pedido {{ $order->order_number ?? '#' . str_pad($order->id ?? 1, 6, '0', STR_PAD_LEFT) }}
                            </h2>
                            <p class="text-white-50 mb-0">
                                <i class="bi bi-calendar3 me-2"></i>
                                Realizado el {{ $order->created_at->format('d \\d\\e F, Y') ?? now()->format('d \\d\\e F, Y') }} 
                                a las {{ $order->created_at->format('H:i') ?? now()->format('H:i') }}
                            </p>
                        </div>
                        @php
                            $statusClass = match($order->status ?? 'pending') {
                                'pending' => 'badge-pending',
                                'processing' => 'badge-processing',
                                'shipped' => 'badge-shipped',
                                'delivered' => 'badge-delivered',
                                'cancelled' => 'badge-cancelled',
                                default => 'badge-pending'
                            };
                            $statusLabel = match($order->status ?? 'pending') {
                                'pending' => 'Pendiente',
                                'processing' => 'Procesando',
                                'shipped' => 'Enviado',
                                'delivered' => 'Entregado',
                                'cancelled' => 'Cancelado',
                                default => 'Pendiente'
                            };
                        @endphp
                        <span class="badge-status {{ $statusClass }}">{{ $statusLabel }}</span>
                    </div>
                </div>

                <!-- Timeline del pedido -->
                <div class="order-card">
                    <h5 class="section-title"><i class="bi bi-clock-history me-2"></i>Estado del Pedido</h5>
                    
                    @php
                        $steps = [
                            ['status' => 'pending', 'icon' => 'check-circle', 'label' => 'Pedido Confirmado', 'desc' => 'Tu pedido ha sido recibido'],
                            ['status' => 'processing', 'icon' => 'box-seam', 'label' => 'En Preparación', 'desc' => 'Estamos preparando tu pedido'],
                            ['status' => 'shipped', 'icon' => 'truck', 'label' => 'Enviado', 'desc' => 'Tu pedido está en camino'],
                            ['status' => 'delivered', 'icon' => 'house-check', 'label' => 'Entregado', 'desc' => 'Pedido entregado exitosamente']
                        ];
                        $currentStep = array_search($order->status ?? 'pending', array_column($steps, 'status'));
                        if ($currentStep === false) $currentStep = 0;
                    @endphp
                    
                    <div class="timeline">
                        @foreach($steps as $index => $step)
                            <div class="timeline-item {{ $index <= $currentStep ? 'active' : '' }}">
                                <div class="timeline-marker">
                                    <i class="bi bi-{{ $step['icon'] }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>{{ $step['label'] }}</h6>
                                    <p class="mb-0">{{ $step['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Productos -->
                <div class="order-card">
                    <h5 class="section-title"><i class="bi bi-bag me-2"></i>Productos ({{ $order->items->count() ?? 0 }})</h5>
                    
                    @if(isset($order) && $order->items)
                        @foreach($order->items as $item)
                            <div class="product-item">
                                <div class="product-image">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}" 
                                             alt="{{ $item->product->name ?? 'Producto' }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="bi bi-image text-white-50" style="font-size: 1.5rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="product-info flex-grow-1">
                                    <h6>{{ $item->product->name ?? $item->product_name ?? 'Producto' }}</h6>
                                    <small>
                                        @if($item->size)Talla: {{ $item->size }} · @endif
                                        @if($item->color)Color: {{ $item->color }} · @endif
                                        Cantidad: {{ $item->quantity }}
                                    </small>
                                </div>
                                <div class="product-price">
                                    <div class="unit">${{ number_format($item->price, 2) }} c/u</div>
                                    <div class="total">${{ number_format($item->quantity * $item->price, 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Columna lateral -->
            <div class="col-lg-4">
                <!-- Resumen del pago -->
                <div class="order-card">
                    <h5 class="section-title"><i class="bi bi-receipt me-2"></i>Resumen</h5>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->subtotal ?? 0, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Envío</span>
                        <span class="{{ ($order->shipping_cost ?? 0) > 0 ? '' : 'text-success' }}">
                            {{ ($order->shipping_cost ?? 0) > 0 ? '$' . number_format($order->shipping_cost, 2) : 'Gratis' }}
                        </span>
                    </div>
                    <div class="summary-row">
                        <span>IVA (12%)</span>
                        <span>${{ number_format($order->tax ?? 0, 2) }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>${{ number_format($order->total ?? 0, 2) }}</span>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
                        <small class="text-white-50">
                            <i class="bi bi-credit-card me-2"></i>{{ $order->payment_method_label ?? 'Método no especificado' }}
                        </small>
                    </div>
                </div>

                <!-- Dirección de envío -->
                <div class="order-card">
                    <h5 class="section-title"><i class="bi bi-geo-alt me-2"></i>Dirección de Envío</h5>
                    
                    <div class="mb-3">
                        <strong class="text-white">{{ $order->customer_name ?? auth()->user()->name ?? 'Cliente' }}</strong>
                    </div>
                    @if($order->customer_email)
                        <div class="mb-2 text-white-50">
                            <i class="bi bi-envelope me-1"></i>{{ $order->customer_email }}
                        </div>
                    @endif
                    <p class="text-white-50 mb-2">
                        {{ $order->shipping_address ?? $order->address ?? 'Dirección no especificada' }}
                        @if($order->address_reference)
                            <br><small>Ref: {{ $order->address_reference }}</small>
                        @endif
                    </p>
                    <p class="text-white-50 mb-2">
                        {{ $order->city ?? 'Ciudad' }}{{ $order->province ? ', ' . $order->province : '' }}, Ecuador
                    </p>
                    @if($order->customer_phone)
                        <p class="text-white-50 mb-0">
                            <i class="bi bi-telephone me-1"></i>{{ $order->customer_phone }}
                        </p>
                    @endif
                </div>

                <!-- Acciones -->
                <div class="order-card">
                    <h5 class="section-title"><i class="bi bi-gear me-2"></i>Acciones</h5>
                    
                    <div class="d-grid gap-2">
                        @if(($order->status ?? '') === 'shipped')
                            <button class="btn-primary-custom">
                                <i class="bi bi-truck me-2"></i>Rastrear Envío
                            </button>
                        @endif
                        
                        <button class="btn-outline-custom" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i>Imprimir Pedido
                        </button>
                        
                        <a href="#" class="btn-outline-custom text-center text-decoration-none">
                            <i class="bi bi-download me-2"></i>Descargar Factura
                        </a>
                        
                        @if(in_array($order->status ?? '', ['pending', 'processing']))
                            <button class="btn-danger-custom" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                <i class="bi bi-x-circle me-2"></i>Cancelar Pedido
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Ayuda -->
                <div class="order-card">
                    <h5 class="section-title"><i class="bi bi-headset me-2"></i>¿Necesitas ayuda?</h5>
                    <p class="text-white-50 small mb-3">Contáctanos si tienes alguna pregunta sobre tu pedido</p>
                    <a href="https://wa.me/593999999999?text=Hola, tengo una consulta sobre mi pedido %23{{ str_pad($order->id ?? 1, 6, '0', STR_PAD_LEFT) }}" 
                       class="btn-whatsapp d-block text-center text-decoration-none">
                        <i class="bi bi-whatsapp me-2"></i>Escribir por WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- Volver -->
        <div class="mt-4">
            <a href="{{ route('orders.index') }}" class="btn-outline-custom d-inline-block text-decoration-none px-4">
                <i class="bi bi-arrow-left me-2"></i>Volver a Mis Pedidos
            </a>
        </div>
    </div>
</section>

<!-- Modal Cancelar -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancelar Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas cancelar este pedido?</p>
                <p class="text-white-50 small">Esta acción no se puede deshacer. Si ya realizaste el pago, el reembolso se procesará en 5-10 días hábiles.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, mantener</button>
                <form action="{{ route('orders.cancel', $order->id ?? 1) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Sí, cancelar pedido</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
