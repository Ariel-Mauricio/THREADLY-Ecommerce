@extends('layouts.admin')

@section('title', 'Pedido #' . str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="admin-content">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color: rgba(255,255,255,0.3);">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-white-50">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}" class="text-white-50">Pedidos</a></li>
                    <li class="breadcrumb-item text-white-50">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-white fw-bold">
                <i class="bi bi-receipt me-2" style="color: var(--accent);"></i>Pedido #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
            </h1>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-light btn-sm" onclick="window.print()">
                <i class="bi bi-printer me-2"></i>Imprimir
            </button>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->shipping_phone ?? '593999999999') }}?text=Hola, te escribo sobre tu pedido %23{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} en THREADLY" 
               class="btn btn-success btn-sm" target="_blank">
                <i class="bi bi-whatsapp me-2"></i>Contactar
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4 d-flex align-items-center">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <!-- Columna principal -->
        <div class="col-lg-8">
            <!-- Estado del pedido -->
            <div class="card-glass p-4 mb-4">
                @php
                    $colors = ['pending' => 'warning', 'processing' => 'info', 'shipped' => 'primary', 'delivered' => 'success', 'cancelled' => 'danger', 'payment_failed' => 'danger'];
                    $labels = ['pending' => 'Pendiente', 'processing' => 'Procesando', 'shipped' => 'Enviado', 'delivered' => 'Entregado', 'cancelled' => 'Cancelado', 'payment_failed' => 'Pago Fallido'];
                @endphp
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <h5 class="text-white mb-0"><i class="bi bi-clock-history me-2" style="color: var(--accent);"></i>Estado del Pedido</h5>
                    <span class="badge bg-{{ $colors[$order->status] ?? 'secondary' }} fs-6 px-3 py-2">
                        {{ $labels[$order->status] ?? 'Pendiente' }}
                    </span>
                </div>

                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label text-white-50">Cambiar Estado</label>
                            <select name="status" class="form-select">
                                @foreach($labels as $value => $label)
                                    <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-check-lg me-2"></i>Actualizar
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Timeline visual -->
                <div class="mt-4 pt-4 border-top" style="border-color: var(--border-color) !important;">
                    <div class="d-flex justify-content-between position-relative">
                        <div class="position-absolute" style="top: 17px; left: 50px; right: 50px; height: 3px; background: rgba(255,255,255,0.1); border-radius: 3px;"></div>
                        
                        @php
                            $steps = ['pending', 'processing', 'shipped', 'delivered'];
                            $currentStep = array_search($order->status, $steps);
                            if ($currentStep === false) $currentStep = -1;
                        @endphp
                        
                        @foreach([
                            ['icon' => 'check-circle', 'label' => 'Confirmado'],
                            ['icon' => 'box-seam', 'label' => 'Preparando'],
                            ['icon' => 'truck', 'label' => 'Enviado'],
                            ['icon' => 'house-check', 'label' => 'Entregado']
                        ] as $index => $step)
                            <div class="text-center position-relative" style="z-index: 1;">
                                <div class="d-flex align-items-center justify-content-center rounded-circle mx-auto mb-2"
                                     style="width: 35px; height: 35px; 
                                            background: {{ $index <= $currentStep ? 'linear-gradient(135deg, #a855f7 0%, #6366f1 100%)' : 'rgba(255,255,255,0.1)' }};
                                            box-shadow: {{ $index <= $currentStep ? '0 4px 15px rgba(168, 85, 247, 0.4)' : 'none' }};">
                                    <i class="bi bi-{{ $step['icon'] }}" 
                                       style="color: {{ $index <= $currentStep ? '#fff' : 'rgba(255,255,255,0.3)' }};"></i>
                                </div>
                                <small class="text-{{ $index <= $currentStep ? 'white' : 'muted' }}">
                                    {{ $step['label'] }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Productos -->
            <div class="card-glass p-4 mb-4">
                <h5 class="text-white mb-4"><i class="bi bi-bag me-2" style="color: var(--accent);"></i>Productos del Pedido</h5>
                
                @foreach($order->items as $item)
                    <div class="d-flex align-items-center py-3 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: var(--border-color) !important;">
                        <div class="me-3" style="width: 70px; height: 70px; border-radius: 12px; overflow: hidden; flex-shrink: 0; background: rgba(255,255,255,0.05);">
                            <img src="{{ $item->product->image ?? 'https://via.placeholder.com/70' }}" 
                                 alt="{{ $item->product->name ?? 'Producto' }}" 
                                 class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-white mb-1">{{ $item->product->name ?? 'Producto eliminado' }}</h6>
                            <small class="text-white-50">
                                @if($item->size) <span class="badge bg-secondary me-1">Talla: {{ $item->size }}</span> @endif
                                @if($item->color) <span class="badge bg-secondary me-1">Color: {{ $item->color }}</span> @endif
                                <span class="badge bg-secondary">Cantidad: {{ $item->quantity }}</span>
                            </small>
                        </div>
                        <div class="text-end">
                            <small class="text-white-50">${{ number_format($item->price, 2) }} c/u</small>
                            <br>
                            <strong class="text-success">${{ number_format($item->quantity * $item->price, 2) }}</strong>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Notas -->
            <div class="card-glass p-4">
                <h5 class="text-white mb-4"><i class="bi bi-chat-left-text me-2" style="color: var(--accent);"></i>Notas del Pedido</h5>
                
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ $order->status }}">
                    <div class="mb-3">
                        <textarea name="notes" class="form-control" rows="3"
                                  placeholder="Agregar notas internas sobre este pedido...">{{ $order->notes ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-save me-2"></i>Guardar Notas
                    </button>
                </form>

                @if($order->customer_notes)
                    <div class="mt-4 pt-4 border-top" style="border-color: var(--border-color) !important;">
                        <h6 class="text-white-50 mb-2">Notas del Cliente:</h6>
                        <p class="text-white mb-0">{{ $order->customer_notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Columna lateral -->
        <div class="col-lg-4">
            <!-- Resumen -->
            <div class="card-glass p-4 mb-4">
                <h5 class="text-white mb-4"><i class="bi bi-receipt me-2" style="color: var(--accent);"></i>Resumen</h5>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-white-50">Subtotal</span>
                    <span class="text-white">${{ number_format($order->total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-white-50">Envío</span>
                    <span class="text-success">Gratis</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-white-50">IVA (12%)</span>
                    <span class="text-white">${{ number_format($order->total * 0.12, 2) }}</span>
                </div>
                <hr style="border-color: var(--border-color);">
                <div class="d-flex justify-content-between fs-5 fw-bold">
                    <span class="text-white">Total</span>
                    <span style="color: var(--accent);">${{ number_format($order->total * 1.12, 2) }}</span>
                </div>
                
                <div class="mt-4 pt-3 border-top" style="border-color: var(--border-color) !important;">
                    <small class="text-white-50 d-block mb-1">
                        <i class="bi bi-credit-card me-2"></i>Método de pago
                    </small>
                    <span class="text-white">{{ ucfirst($order->payment_method ?? 'Tarjeta de crédito') }}</span>
                </div>
            </div>

            <!-- Cliente -->
            <div class="card-glass p-4 mb-4">
                <h5 class="text-white mb-4"><i class="bi bi-person me-2" style="color: var(--accent);"></i>Cliente</h5>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width: 50px; height: 50px; background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);">
                        <span class="text-white fs-5 fw-bold">{{ substr($order->user->name ?? 'C', 0, 1) }}</span>
                    </div>
                    <div>
                        <strong class="text-white d-block">{{ $order->user->name ?? 'Cliente' }}</strong>
                        <small class="text-white-50">{{ $order->user->email ?? '' }}</small>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="mailto:{{ $order->user->email ?? '' }}" class="btn btn-outline-light btn-sm flex-grow-1">
                        <i class="bi bi-envelope me-1"></i>Email
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->shipping_phone ?? '593999999999') }}" 
                       class="btn btn-success btn-sm flex-grow-1" target="_blank">
                        <i class="bi bi-whatsapp me-1"></i>WhatsApp
                    </a>
                </div>
            </div>

            <!-- Dirección de envío -->
            <div class="card-glass p-4 mb-4">
                <h5 class="text-white mb-4"><i class="bi bi-geo-alt me-2" style="color: var(--accent);"></i>Envío</h5>
                
                <p class="text-white mb-1"><strong>{{ $order->shipping_name ?? $order->user->name ?? 'Cliente' }}</strong></p>
                <p class="text-white-50 mb-1">{{ $order->shipping_address ?? 'Dirección no especificada' }}</p>
                <p class="text-white-50 mb-1">{{ $order->shipping_city ?? 'Ciudad' }}, Ecuador</p>
                <p class="text-white-50 mb-0"><i class="bi bi-telephone me-1"></i>{{ $order->shipping_phone ?? 'Sin teléfono' }}</p>
            </div>

            <!-- Fechas -->
            <div class="card-glass p-4">
                <h5 class="text-white mb-4"><i class="bi bi-calendar3 me-2" style="color: var(--accent);"></i>Fechas</h5>
                
                <div class="mb-3">
                    <small class="text-white-50 d-block">Fecha del pedido</small>
                    <span class="text-white">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($order->shipped_at)
                    <div class="mb-3">
                        <small class="text-white-50 d-block">Fecha de envío</small>
                        <span class="text-white">{{ $order->shipped_at->format('d/m/Y H:i') }}</span>
                    </div>
                @endif
                @if($order->delivered_at)
                    <div>
                        <small class="text-white-50 d-block">Fecha de entrega</small>
                        <span class="text-white">{{ $order->delivered_at->format('d/m/Y H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Volver -->
    <div class="mt-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light">
            <i class="bi bi-arrow-left me-2"></i>Volver a Pedidos
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .btn, .sidebar, nav {
            display: none !important;
        }
        .admin-content {
            background: white !important;
            color: black !important;
        }
        .card-glass {
            background: white !important;
            border: 1px solid #ddd !important;
        }
        .text-white, .text-white-50 {
            color: black !important;
        }
    }
</style>
@endpush
