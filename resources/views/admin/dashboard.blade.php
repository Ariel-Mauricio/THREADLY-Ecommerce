@extends('layouts.admin')

@section('title', 'Dashboard - Panel de Administración')

@section('content')
<div class="admin-content">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-white fw-bold">
                <i class="bi bi-speedometer2 me-2" style="color: var(--accent);"></i>Dashboard
            </h1>
            <p class="text-white-50 mb-0">Bienvenido de nuevo, {{ Auth::user()->name ?? 'Admin' }} 👋</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-success px-3 py-2 d-flex align-items-center">
                <span class="pulse-dot me-2"></span>Sistema Activo
            </span>
            <span class="badge bg-dark px-3 py-2">
                <i class="bi bi-calendar3 me-1"></i>{{ now()->format('d/m/Y H:i') }}
            </span>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Total Ventas -->
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card stats-card-green">
                <div class="stats-icon">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stats-content">
                    <span class="stats-label">Ventas Totales</span>
                    <h3 class="stats-value">${{ number_format($totalSales ?? 0, 2) }}</h3>
                    <div class="stats-change positive">
                        <i class="bi bi-arrow-up-short"></i>
                        <span>{{ $salesGrowth ?? 0 }}% vs mes anterior</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pedidos -->
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card stats-card-purple">
                <div class="stats-icon">
                    <i class="bi bi-bag-check"></i>
                </div>
                <div class="stats-content">
                    <span class="stats-label">Total Pedidos</span>
                    <h3 class="stats-value">{{ $totalOrders ?? 0 }}</h3>
                    <div class="stats-change">
                        <i class="bi bi-clock"></i>
                        <span>{{ $weeklyOrders ?? 0 }} esta semana</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Productos -->
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card stats-card-blue">
                <div class="stats-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stats-content">
                    <span class="stats-label">Productos</span>
                    <h3 class="stats-value">{{ $totalProducts ?? 0 }}</h3>
                    <div class="stats-change">
                        <i class="bi bi-check-circle"></i>
                        <span>En catálogo activo</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Usuarios -->
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card stats-card-orange">
                <div class="stats-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stats-content">
                    <span class="stats-label">Clientes</span>
                    <h3 class="stats-value">{{ $totalUsers ?? 0 }}</h3>
                    <div class="stats-change">
                        <i class="bi bi-person-plus"></i>
                        <span>Usuarios registrados</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row: Monthly Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card-glass p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-white-50 mb-1 small">Ventas este mes</p>
                        <h4 class="mb-0 text-white">${{ number_format($currentMonthSales ?? 0, 2) }}</h4>
                    </div>
                    <div class="chart-mini bg-success-subtle rounded p-2">
                        <i class="bi bi-graph-up-arrow text-success fs-4"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 6px; background: rgba(255,255,255,0.1);">
                    <div class="progress-bar bg-success" style="width: {{ min(($currentMonthSales ?? 0) / max(($lastMonthSales ?? 1), 1) * 100, 100) }}%;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-glass p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-white-50 mb-1 small">Ventas mes anterior</p>
                        <h4 class="mb-0 text-white">${{ number_format($lastMonthSales ?? 0, 2) }}</h4>
                    </div>
                    <div class="chart-mini bg-info-subtle rounded p-2">
                        <i class="bi bi-calendar-check text-info fs-4"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 6px; background: rgba(255,255,255,0.1);">
                    <div class="progress-bar bg-info" style="width: 75%;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-glass p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-white-50 mb-1 small">Crecimiento</p>
                        <h4 class="mb-0 {{ ($salesGrowth ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ ($salesGrowth ?? 0) >= 0 ? '+' : '' }}{{ $salesGrowth ?? 0 }}%
                        </h4>
                    </div>
                    <div class="chart-mini {{ ($salesGrowth ?? 0) >= 0 ? 'bg-success-subtle' : 'bg-danger-subtle' }} rounded p-2">
                        <i class="bi bi-{{ ($salesGrowth ?? 0) >= 0 ? 'graph-up-arrow' : 'graph-down-arrow' }} {{ ($salesGrowth ?? 0) >= 0 ? 'text-success' : 'text-danger' }} fs-4"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 6px; background: rgba(255,255,255,0.1);">
                    <div class="progress-bar {{ ($salesGrowth ?? 0) >= 0 ? 'bg-success' : 'bg-danger' }}" style="width: {{ min(abs($salesGrowth ?? 0), 100) }}%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4 mb-4">
        <!-- Sales Chart -->
        <div class="col-xl-8">
            <div class="card-glass p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0 text-white">
                        <i class="bi bi-graph-up me-2" style="color: var(--accent);"></i>Análisis de Ventas
                    </h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-light chart-period active" data-period="7days">7 días</button>
                        <button type="button" class="btn btn-sm btn-outline-light chart-period" data-period="30days">30 días</button>
                        <button type="button" class="btn btn-sm btn-outline-light chart-period" data-period="12months">12 meses</button>
                    </div>
                </div>
                <div style="height: 300px;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Orders by Status -->
        <div class="col-xl-4">
            <div class="card-glass p-4 h-100">
                <h5 class="mb-4 text-white">
                    <i class="bi bi-pie-chart me-2" style="color: var(--accent);"></i>Pedidos por Estado
                </h5>
                <div style="height: 250px; display: flex; align-items: center; justify-content: center;">
                    <canvas id="ordersStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Orders -->
    <div class="row g-4 mb-4">
        <!-- Quick Actions -->
        <div class="col-xl-4">
            <div class="card-glass p-4 h-100">
                <h5 class="mb-4 text-white">
                    <i class="bi bi-lightning-charge me-2" style="color: #f59e0b;"></i>Acciones Rápidas
                </h5>
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.products.create') }}" class="quick-action-btn">
                        <div class="qa-icon bg-purple-subtle">
                            <i class="bi bi-plus-circle text-purple"></i>
                        </div>
                        <div>
                            <strong>Nuevo Producto</strong>
                            <small class="d-block text-white-50">Agregar al catálogo</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto"></i>
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="quick-action-btn">
                        <div class="qa-icon bg-cyan-subtle">
                            <i class="bi bi-pencil-square text-info"></i>
                        </div>
                        <div>
                            <strong>Editar Productos</strong>
                            <small class="d-block text-white-50">Modificar existentes</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto"></i>
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="quick-action-btn">
                        <div class="qa-icon bg-blue-subtle">
                            <i class="bi bi-folder-plus text-primary"></i>
                        </div>
                        <div>
                            <strong>Nueva Categoría</strong>
                            <small class="d-block text-white-50">Organizar productos</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto"></i>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="quick-action-btn">
                        <div class="qa-icon bg-green-subtle">
                            <i class="bi bi-truck text-success"></i>
                        </div>
                        <div>
                            <strong>Gestionar Pedidos</strong>
                            <small class="d-block text-white-50">Procesar envíos</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto"></i>
                    </a>
                    <a href="{{ route('admin.promotions.index') }}" class="quick-action-btn">
                        <div class="qa-icon bg-orange-subtle">
                            <i class="bi bi-tag text-warning"></i>
                        </div>
                        <div>
                            <strong>Crear Promoción</strong>
                            <small class="d-block text-white-50">Aplicar descuentos</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto"></i>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="quick-action-btn">
                        <div class="qa-icon bg-pink-subtle">
                            <i class="bi bi-people text-pink"></i>
                        </div>
                        <div>
                            <strong>Usuarios</strong>
                            <small class="d-block text-white-50">Gestionar clientes</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="col-xl-8">
            <div class="card-glass p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0 text-white">
                        <i class="bi bi-clock-history me-2" style="color: var(--accent);"></i>Pedidos Recientes
                    </h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-light">
                        Ver todos <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                        <thead>
                            <tr class="text-white-50 small text-uppercase">
                                <th>Orden</th>
                                <th>Cliente</th>
                                <th>Productos</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-white">#{{ $order->order_number ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                {{ strtoupper(substr($order->customer_name ?? $order->user->name ?? 'C', 0, 1)) }}
                                            </div>
                                            <span>{{ Str::limit($order->customer_name ?? $order->user->name ?? 'Cliente', 15) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $order->items->count() ?? 0 }} items</span>
                                    </td>
                                    <td class="fw-bold text-success">${{ number_format($order->total, 2) }}</td>
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
                                    <td class="text-white-50 small">{{ $order->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-light">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox"></i>
                                            <p>No hay pedidos recientes</p>
                                            <small class="text-white-50">Los nuevos pedidos aparecerán aquí</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Third Row: Products & Alerts -->
    <div class="row g-4">
        <!-- Top Products -->
        <div class="col-xl-4">
            <div class="card-glass p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0 text-white">
                        <i class="bi bi-star me-2" style="color: #f59e0b;"></i>Top Productos
                    </h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-warning">Ver todos</a>
                </div>
                @forelse($topProducts ?? [] as $index => $product)
                    <div class="top-product-item {{ !$loop->last ? 'mb-3' : '' }}">
                        <div class="rank-badge {{ $index < 3 ? 'top-3' : '' }}">
                            {{ $index + 1 }}
                        </div>
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/50' }}" 
                             alt="{{ $product->name }}" class="product-thumb">
                        <div class="product-info">
                            <strong class="d-block text-white">{{ Str::limit($product->name, 20) }}</strong>
                            <small class="text-white-50">{{ $product->order_items_count ?? 0 }} vendidos</small>
                        </div>
                        <div class="text-end">
                            <span class="text-success fw-bold d-block">${{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary mt-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="empty-state py-4">
                        <i class="bi bi-trophy"></i>
                        <p>Sin datos de ventas</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="col-xl-4">
            <div class="card-glass p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0 text-white">
                        <i class="bi bi-exclamation-triangle me-2 text-danger"></i>Stock Bajo
                    </h5>
                    <span class="badge bg-danger">{{ count($lowStockProducts ?? []) }} alertas</span>
                </div>
                @forelse($lowStockProducts ?? [] as $product)
                    <div class="stock-alert-item {{ !$loop->last ? 'mb-3' : '' }}">
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/40' }}" 
                             alt="{{ $product->name }}" class="product-thumb-sm">
                        <div class="flex-grow-1">
                            <strong class="d-block text-white small">{{ Str::limit($product->name, 25) }}</strong>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 4px; background: rgba(255,255,255,0.1);">
                                    <div class="progress-bar bg-{{ $product->stock <= 2 ? 'danger' : 'warning' }}" 
                                         style="width: {{ min($product->stock * 10, 100) }}%;"></div>
                                </div>
                                <span class="badge bg-{{ $product->stock <= 2 ? 'danger' : 'warning' }} small">
                                    {{ $product->stock }} uds
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </div>
                @empty
                    <div class="empty-state py-4">
                        <i class="bi bi-check-circle text-success"></i>
                        <p class="text-success">¡Todo en orden!</p>
                        <small class="text-white-50">No hay productos con stock bajo</small>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Active Promotions -->
        <div class="col-xl-4">
            <div class="card-glass p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0 text-white">
                        <i class="bi bi-lightning-charge me-2" style="color: #f59e0b;"></i>Promociones Activas
                    </h5>
                    <a href="{{ route('admin.promotions.index') }}" class="btn btn-sm btn-outline-warning">Gestionar</a>
                </div>
                @forelse($activePromotions ?? [] as $promo)
                    <div class="promo-item {{ !$loop->last ? 'mb-3' : '' }}">
                        <div class="promo-badge">-{{ $promo->discount_percent }}%</div>
                        <img src="{{ $promo->image ?? 'https://via.placeholder.com/40' }}" 
                             alt="{{ $promo->name }}" class="product-thumb-sm">
                        <div class="flex-grow-1">
                            <strong class="d-block text-white small">{{ Str::limit($promo->name, 20) }}</strong>
                            <small class="text-warning">{{ $promo->promotion_label ?? 'En oferta' }}</small>
                        </div>
                        @if($promo->promotion_ends)
                            <small class="text-white-50">
                                <i class="bi bi-clock me-1"></i>{{ $promo->promotion_ends->diffForHumans() }}
                            </small>
                        @endif
                    </div>
                @empty
                    <div class="empty-state py-4">
                        <i class="bi bi-tag"></i>
                        <p>Sin promociones activas</p>
                        <a href="{{ route('admin.promotions.index') }}" class="btn btn-sm btn-outline-warning mt-2">
                            <i class="bi bi-plus me-1"></i>Crear promoción
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart');
    if (salesCtx) {
        const salesChart = new Chart(salesCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                datasets: [{
                    label: 'Ventas ($)',
                    data: [120, 190, 80, 250, 320, 280, 150],
                    borderColor: '#a855f7',
                    backgroundColor: 'rgba(168, 85, 247, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#a855f7',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: { color: 'rgba(255,255,255,0.5)' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: 'rgba(255,255,255,0.5)' }
                    }
                }
            }
        });

        // Load chart data
        function loadChartData(period) {
            fetch(`/admin/charts/sales?period=${period}`)
                .then(r => r.json())
                .then(data => {
                    salesChart.data.labels = data.labels;
                    salesChart.data.datasets[0].data = data.sales;
                    salesChart.update();
                })
                .catch(err => console.log('Using default chart data'));
        }

        // Period buttons
        document.querySelectorAll('.chart-period').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.chart-period').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                loadChartData(this.dataset.period);
            });
        });
    }

    // Orders Status Chart
    const statusCtx = document.getElementById('ordersStatusChart');
    if (statusCtx) {
        new Chart(statusCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Pendientes', 'Procesando', 'Enviados', 'Entregados', 'Cancelados'],
                datasets: [{
                    data: [5, 3, 8, 25, 2],
                    backgroundColor: ['#f59e0b', '#3b82f6', '#06b6d4', '#22c55e', '#ef4444'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'rgba(255,255,255,0.7)',
                            padding: 15,
                            usePointStyle: true,
                        }
                    }
                },
                cutout: '65%',
            }
        });

        // Try to load real data
        fetch('/admin/charts/orders-status')
            .then(r => r.json())
            .then(data => {
                if (data.labels && data.data) {
                    statusCtx._chart && statusCtx._chart.destroy();
                    new Chart(statusCtx.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.data,
                                backgroundColor: data.colors || ['#f59e0b', '#3b82f6', '#06b6d4', '#22c55e', '#ef4444'],
                                borderWidth: 0,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: { color: 'rgba(255,255,255,0.7)', padding: 15, usePointStyle: true }
                                }
                            },
                            cutout: '65%',
                        }
                    });
                }
            })
            .catch(err => console.log('Using default status data'));
    }
});
</script>
@endpush
