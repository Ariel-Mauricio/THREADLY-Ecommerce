@extends('layouts.app')

@section('title', 'Mis Pedidos - THREADLY')

@push('styles')
<style>
    .profile-section {
        min-height: 100vh;
        background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #0f0f1a 100%);
        padding-top: 120px !important;
    }
    .profile-sidebar {
        background: rgba(255,255,255,0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        overflow: hidden;
    }
    .profile-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    .profile-nav-item:hover {
        background: rgba(168, 85, 247, 0.1);
        color: #a855f7;
        border-left-color: #a855f7;
    }
    .profile-nav-item.active {
        background: rgba(168, 85, 247, 0.15);
        color: #a855f7;
        border-left-color: #a855f7;
    }
    .profile-nav-item.logout-btn:hover {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border-left-color: #ef4444;
    }
    .profile-card {
        background: rgba(255,255,255,0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        overflow: hidden;
    }
    .profile-card-header {
        background: rgba(255,255,255,0.05);
        padding: 20px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .order-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    .order-card:hover {
        border-color: rgba(168, 85, 247, 0.3);
        background: rgba(255,255,255,0.05);
    }
    .order-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 16px;
        margin-bottom: 16px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .order-number {
        color: #fff;
        font-weight: 600;
        font-size: 1.1rem;
    }
    .order-date {
        color: rgba(255,255,255,0.5);
        font-size: 0.875rem;
    }
    .order-total {
        font-size: 1.25rem;
        font-weight: 700;
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .badge-status {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .badge-pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; }
    .badge-processing { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .badge-shipped { background: rgba(168, 85, 247, 0.15); color: #a855f7; }
    .badge-delivered { background: rgba(34, 197, 94, 0.15); color: #22c55e; }
    .badge-cancelled { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
    
    .product-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 12px 0;
    }
    .product-item:not(:last-child) {
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .product-image {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
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
    .shipping-box {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px;
        padding: 16px;
    }
    .shipping-box h6 {
        color: rgba(255,255,255,0.5);
        font-size: 0.8rem;
        margin-bottom: 8px;
    }
    .shipping-box p {
        color: rgba(255,255,255,0.8);
        margin: 0;
        font-size: 0.9rem;
    }
    .btn-view {
        background: rgba(168, 85, 247, 0.15);
        border: 1px solid rgba(168, 85, 247, 0.3);
        color: #a855f7;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-view:hover {
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        border-color: transparent;
        color: #fff;
    }
    .btn-track {
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
    }
    .btn-track:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(168, 85, 247, 0.3);
        color: #fff;
    }
    /* Timeline */
    .order-timeline {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.1);
        position: relative;
    }
    .timeline-line {
        position: absolute;
        top: 35px;
        left: 40px;
        right: 40px;
        height: 2px;
        background: rgba(255,255,255,0.1);
    }
    .timeline-step {
        text-align: center;
        position: relative;
        z-index: 1;
    }
    .timeline-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-size: 0.8rem;
    }
    .timeline-icon.active {
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        color: #fff;
    }
    .timeline-icon.inactive {
        background: rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.3);
    }
    .timeline-label {
        font-size: 0.75rem;
    }
    .timeline-label.active { color: #fff; }
    .timeline-label.inactive { color: rgba(255,255,255,0.4); }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state i {
        font-size: 4rem;
        color: rgba(168, 85, 247, 0.3);
        margin-bottom: 20px;
    }
    .help-box {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 24px;
        margin-top: 30px;
    }
    .btn-whatsapp {
        background: #25d366;
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 500;
    }
    .btn-whatsapp:hover {
        background: #1da851;
        color: #fff;
    }
    .btn-outline-light-custom {
        border: 1px solid rgba(255,255,255,0.2);
        color: rgba(255,255,255,0.7);
        padding: 10px 20px;
        border-radius: 10px;
    }
    .btn-outline-light-custom:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
    }
</style>
@endpush

@section('content')
<section class="profile-section py-5">
    <div class="container">
        @include('partials.user-nav', ['pageTitle' => 'Mis Pedidos'])
        
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                @include('profile.partials.sidebar')
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="profile-card">
                    <div class="profile-card-header">
                        <h4 class="mb-0 text-white">
                            <i class="bi bi-bag-fill me-2 text-purple"></i>Mis Pedidos
                        </h4>
                        <p class="text-white-50 mb-0 mt-1">Historial y seguimiento de tus compras</p>
                    </div>
                    <div class="p-4">
                        @if(isset($orders) && $orders->count() > 0)
                            @foreach($orders as $order)
                                <div class="order-card">
                                    <!-- Header del pedido -->
                                    <div class="order-header">
                                        <div>
                                            <div class="order-number">
                                                Pedido {{ $order->order_number ?? '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                            </div>
                                            <div class="order-date">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ $order->created_at->format('d M, Y - H:i') }}
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            @php
                                                $statusClass = match($order->status) {
                                                    'pending' => 'badge-pending',
                                                    'processing' => 'badge-processing',
                                                    'shipped' => 'badge-shipped',
                                                    'delivered' => 'badge-delivered',
                                                    'cancelled' => 'badge-cancelled',
                                                    default => 'badge-pending'
                                                };
                                                $statusLabel = match($order->status) {
                                                    'pending' => 'Pendiente',
                                                    'processing' => 'Procesando',
                                                    'shipped' => 'Enviado',
                                                    'delivered' => 'Entregado',
                                                    'cancelled' => 'Cancelado',
                                                    default => ucfirst($order->status)
                                                };
                                            @endphp
                                            <span class="badge-status {{ $statusClass }} d-block mb-2">
                                                {{ $statusLabel }}
                                            </span>
                                            <div class="order-total">${{ number_format($order->total ?? 0, 2) }}</div>
                                        </div>
                                    </div>

                                    <!-- Items del pedido -->
                                    <div class="row">
                                        <div class="col-lg-8">
                                            @foreach($order->items->take(3) as $item)
                                                <div class="product-item">
                                                    <div class="product-image">
                                                        @if($item->product && $item->product->image)
                                                            <img src="{{ Storage::url($item->product->image) }}" 
                                                                 alt="{{ $item->product->name ?? 'Producto' }}">
                                                        @else
                                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                                <i class="bi bi-image text-white-50"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="product-info">
                                                        <h6>{{ $item->product->name ?? $item->product_name ?? 'Producto' }}</h6>
                                                        <small>
                                                            Cantidad: {{ $item->quantity }} · ${{ number_format($item->price, 2) }} c/u
                                                        </small>
                                                    </div>
                                                </div>
                                            @endforeach
                                            
                                            @if($order->items->count() > 3)
                                                <div class="text-white-50 small mt-2">
                                                    <i class="bi bi-plus-circle me-1"></i>
                                                    {{ $order->items->count() - 3 }} producto(s) más
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Información de envío y acciones -->
                                        <div class="col-lg-4 mt-3 mt-lg-0">
                                            <div class="shipping-box mb-3">
                                                <h6><i class="bi bi-geo-alt me-1"></i>Envío a:</h6>
                                                <p>
                                                    {{ $order->shipping_address ?? $order->address ?? 'Dirección no especificada' }}<br>
                                                    {{ $order->city ?? '' }}{{ $order->province ? ', ' . $order->province : '' }}
                                                </p>
                                            </div>
                                            
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-view">
                                                    <i class="bi bi-eye me-2"></i>Ver Detalles
                                                </a>
                                                @if($order->status === 'shipped')
                                                    <button class="btn btn-track">
                                                        <i class="bi bi-truck me-2"></i>Rastrear Envío
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Timeline del pedido -->
                                    @if($order->status !== 'cancelled')
                                        <div class="order-timeline">
                                            <div class="timeline-line"></div>
                                            
                                            @php
                                                $steps = ['pending', 'processing', 'shipped', 'delivered'];
                                                $currentStep = array_search($order->status, $steps);
                                                if ($currentStep === false) $currentStep = 0;
                                            @endphp
                                            
                                            @foreach([
                                                ['icon' => 'check-circle', 'label' => 'Confirmado'],
                                                ['icon' => 'box-seam', 'label' => 'Preparando'],
                                                ['icon' => 'truck', 'label' => 'En camino'],
                                                ['icon' => 'house-check', 'label' => 'Entregado']
                                            ] as $index => $step)
                                                <div class="timeline-step">
                                                    <div class="timeline-icon {{ $index <= $currentStep ? 'active' : 'inactive' }}">
                                                        <i class="bi bi-{{ $step['icon'] }}"></i>
                                                    </div>
                                                    <div class="timeline-label {{ $index <= $currentStep ? 'active' : 'inactive' }} d-none d-sm-block">
                                                        {{ $step['label'] }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <!-- Paginación -->
                            @if($orders->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $orders->links() }}
                                </div>
                            @endif
                        @else
                            <!-- Sin pedidos -->
                            <div class="empty-state">
                                <i class="bi bi-bag-x"></i>
                                <h5 class="text-white mt-3">No tienes pedidos todavía</h5>
                                <p class="text-white-50">¡Explora nuestra colección y realiza tu primera compra!</p>
                                <a href="{{ route('products.index') }}" class="btn btn-track mt-2">
                                    <i class="bi bi-shop me-2"></i>Ir a la Tienda
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Ayuda -->
                <div class="help-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="text-white mb-2">¿Necesitas ayuda con tu pedido?</h5>
                            <p class="text-white-50 mb-0">Nuestro equipo de soporte está disponible para ayudarte</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="#" class="btn btn-outline-light-custom me-2">
                                <i class="bi bi-chat-dots me-2"></i>Chat
                            </a>
                            <a href="https://wa.me/593999999999" class="btn btn-whatsapp">
                                <i class="bi bi-whatsapp me-2"></i>WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
