@extends('layouts.admin')

@section('title', 'Gestión de Pedidos')

@section('content')
<div class="admin-content">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-white fw-bold">
                <i class="bi bi-bag-check me-2" style="color: var(--accent);"></i>Pedidos
            </h1>
            <p class="text-white-50 mb-0">Gestiona los pedidos de tus clientes</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.exports.orders') }}" class="btn btn-outline-light">
                <i class="bi bi-download me-2"></i>Exportar
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card-glass p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-orange-subtle me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-hourglass-split text-warning"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-white-50 small">Pendientes</p>
                        <h5 class="mb-0 text-warning fw-bold">{{ $orders->where('status', 'pending')->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card-glass p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-blue-subtle me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-arrow-repeat text-primary"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-white-50 small">Procesando</p>
                        <h5 class="mb-0 text-primary fw-bold">{{ $orders->whereIn('status', ['processing', 'pending_verification'])->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card-glass p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-green-subtle me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-check-circle text-success"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-white-50 small">Completados</p>
                        <h5 class="mb-0 text-success fw-bold">{{ $orders->whereIn('status', ['delivered', 'paid'])->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card-glass p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-green-subtle me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-currency-dollar text-success"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-white-50 small">Ventas Totales</p>
                        <h5 class="mb-0 text-success fw-bold">${{ number_format($orders->whereNotIn('status', ['cancelled', 'payment_failed'])->sum('total'), 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card-glass p-4 mb-4">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" style="background: rgba(255,255,255,0.05); border-color: var(--border-color);">
                        <i class="bi bi-search text-white-50"></i>
                    </span>
                    <input type="text" name="search" class="form-control" placeholder="Buscar orden, cliente..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Todos los estados</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="pending_verification" {{ request('status') == 'pending_verification' ? 'selected' : '' }}>Verificando</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Procesando</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Pagado</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Enviado</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Entregado</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-3 text-md-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-funnel me-1"></i>Filtrar
                </button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="card-glass p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                <thead>
                    <tr>
                        <th class="ps-4">Orden</th>
                        <th>Cliente</th>
                        <th>Productos</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Pago</th>
                        <th>Fecha</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders ?? [] as $order)
                        <tr class="order-row">
                            <td class="ps-4">
                                <strong class="text-white">#{{ $order->order_number ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        {{ strtoupper(substr($order->customer_name ?? $order->user->name ?? 'C', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong class="text-white d-block">{{ $order->customer_name ?? $order->user->name ?? 'Cliente' }}</strong>
                                        <small class="text-white-50">{{ $order->customer_email ?? $order->user->email ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $order->items->count() }} items</span>
                            </td>
                            <td>
                                <strong class="text-success">${{ number_format($order->total, 2) }}</strong>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'pending_verification' => 'info',
                                        'processing' => 'primary',
                                        'paid' => 'success',
                                        'shipped' => 'info',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                        'payment_failed' => 'danger',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Pendiente',
                                        'pending_verification' => 'Verificando',
                                        'processing' => 'Procesando',
                                        'paid' => 'Pagado',
                                        'shipped' => 'Enviado',
                                        'delivered' => 'Entregado',
                                        'cancelled' => 'Cancelado',
                                        'payment_failed' => 'Pago Fallido',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td>
                                @if($order->payment_method)
                                    <span class="badge bg-dark">{{ ucfirst($order->payment_method) }}</span>
                                @else
                                    <span class="text-white-50">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-white-50">{{ $order->created_at->format('d/m/Y') }}</span>
                                <br>
                                <small class="text-white-50">{{ $order->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="btn btn-sm btn-outline-light" title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="showStatusModal({{ $order->id }}, '{{ $order->status }}')"
                                            title="Cambiar estado">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-bag"></i>
                                    <p class="mb-2">No hay pedidos</p>
                                    <small class="text-white-50">Los nuevos pedidos aparecerán aquí</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($orders) && $orders->hasPages())
            <div class="p-4 border-top" style="border-color: var(--border-color) !important;">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Status Change Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-dark); border: 1px solid var(--border-color);">
            <div class="modal-header" style="border-color: var(--border-color);">
                <h5 class="modal-title text-white">
                    <i class="bi bi-arrow-repeat me-2" style="color: var(--accent);"></i>Cambiar Estado
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nuevo Estado</label>
                        <select name="status" class="form-select" id="statusSelect">
                            <option value="pending">Pendiente</option>
                            <option value="pending_verification">Verificando Pago</option>
                            <option value="processing">Procesando</option>
                            <option value="paid">Pagado</option>
                            <option value="shipped">Enviado</option>
                            <option value="delivered">Entregado</option>
                            <option value="cancelled">Cancelado</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Notas (opcional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Notas internas sobre este cambio..."></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-color: var(--border-color);">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .order-row {
        transition: all 0.3s ease;
    }
    
    .order-row:hover {
        background: rgba(168, 85, 247, 0.05) !important;
    }
    
    .table th {
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.5);
        font-weight: 600;
        padding: 16px;
        border-bottom: 1px solid var(--border-color);
    }
    
    .table td {
        padding: 16px;
        border-bottom: 1px solid var(--border-color);
    }
</style>
@endpush

@push('scripts')
<script>
    const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
    
    function showStatusModal(orderId, currentStatus) {
        document.getElementById('statusForm').action = `/admin/orders/${orderId}/status`;
        document.getElementById('statusSelect').value = currentStatus;
        statusModal.show();
    }
</script>
@endpush
