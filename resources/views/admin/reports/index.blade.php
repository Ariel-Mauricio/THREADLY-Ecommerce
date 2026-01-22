@extends('layouts.admin')

@section('title', 'Reportes y Estadísticas')

@section('content')
<div class="admin-content">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-white fw-bold">
                <i class="bi bi-file-earmark-bar-graph me-2" style="color: var(--accent);"></i>Reportes
            </h1>
            <p class="text-white-50 mb-0">Estadísticas y análisis de tu tienda</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.exports.sales-report') }}" class="btn btn-outline-light">
                <i class="bi bi-download me-2"></i>Exportar Reporte
            </a>
        </div>
    </div>

    <!-- Sales Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card stats-card-green">
                <div class="stats-icon">
                    <i class="bi bi-calendar-day"></i>
                </div>
                <div class="stats-content">
                    <span class="stats-label">Ventas Hoy</span>
                    <h3 class="stats-value">${{ number_format($todaySales ?? 0, 2) }}</h3>
                    <div class="stats-change">
                        <i class="bi bi-bag"></i>
                        <span>{{ $todayOrders ?? 0 }} pedidos</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card stats-card-blue">
                <div class="stats-icon">
                    <i class="bi bi-calendar-week"></i>
                </div>
                <div class="stats-content">
                    <span class="stats-label">Esta Semana</span>
                    <h3 class="stats-value">${{ number_format($weekSales ?? 0, 2) }}</h3>
                    <div class="stats-change">
                        <i class="bi bi-bag"></i>
                        <span>{{ $weekOrders ?? 0 }} pedidos</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card stats-card-purple">
                <div class="stats-icon">
                    <i class="bi bi-calendar-month"></i>
                </div>
                <div class="stats-content">
                    <span class="stats-label">Este Mes</span>
                    <h3 class="stats-value">${{ number_format($monthSales ?? 0, 2) }}</h3>
                    <div class="stats-change">
                        <i class="bi bi-bag"></i>
                        <span>{{ $monthOrders ?? 0 }} pedidos</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card stats-card-orange">
                <div class="stats-icon">
                    <i class="bi bi-calendar"></i>
                </div>
                <div class="stats-content">
                    <span class="stats-label">Este Año</span>
                    <h3 class="stats-value">${{ number_format($yearSales ?? 0, 2) }}</h3>
                    <div class="stats-change">
                        <i class="bi bi-graph-up-arrow"></i>
                        <span>Total acumulado</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Monthly Sales Chart -->
        <div class="col-lg-8">
            <div class="card-glass p-4 h-100">
                <h5 class="text-white mb-4">
                    <i class="bi bi-graph-up me-2" style="color: var(--accent);"></i>Ventas Mensuales (Últimos 12 meses)
                </h5>
                <div style="height: 300px;">
                    <canvas id="monthlySalesChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Customer Stats -->
        <div class="col-lg-4">
            <div class="card-glass p-4 h-100">
                <h5 class="text-white mb-4">
                    <i class="bi bi-people me-2" style="color: var(--accent);"></i>Clientes
                </h5>
                <div class="text-center py-4">
                    <div class="mb-4">
                        <h2 class="display-4 fw-bold text-white mb-0">{{ $totalCustomers ?? 0 }}</h2>
                        <p class="text-white-50">Clientes totales</p>
                    </div>
                    <div class="p-3 rounded" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2);">
                        <h4 class="text-success mb-0">+{{ $newCustomers ?? 0 }}</h4>
                        <small class="text-white-50">Nuevos este mes</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products & Categories -->
    <div class="row g-4">
        <!-- Top Products -->
        <div class="col-lg-6">
            <div class="card-glass p-4 h-100">
                <h5 class="text-white mb-4">
                    <i class="bi bi-trophy me-2" style="color: #f59e0b;"></i>Top 10 Productos Más Vendidos
                </h5>
                @forelse($topProducts ?? [] as $index => $product)
                    <div class="d-flex align-items-center mb-3 p-2 rounded {{ $index < 3 ? 'bg-gradient-top' : '' }}" 
                         style="background: {{ $index < 3 ? 'rgba(245, 158, 11, 0.1)' : 'rgba(255,255,255,0.02)' }};">
                        <span class="badge {{ $index < 3 ? 'bg-warning text-dark' : 'bg-secondary' }} me-3" 
                              style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
                            {{ $index + 1 }}
                        </span>
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/40' }}" 
                             alt="" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <strong class="text-white d-block small">{{ Str::limit($product->name, 25) }}</strong>
                            <small class="text-white-50">{{ $product->order_items_count ?? 0 }} vendidos</small>
                        </div>
                        <strong class="text-success">${{ number_format($product->price, 2) }}</strong>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <div class="empty-state">
                            <i class="bi bi-box-seam"></i>
                            <p class="mb-0">Sin datos de ventas</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Top Categories -->
        <div class="col-lg-6">
            <div class="card-glass p-4 h-100">
                <h5 class="text-white mb-4">
                    <i class="bi bi-tags me-2" style="color: var(--accent);"></i>Categorías Más Populares
                </h5>
                @forelse($topCategories ?? [] as $category)
                    <div class="category-item mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-white">{{ $category->name }}</span>
                            <span class="badge bg-secondary">{{ $category->products_count ?? 0 }} productos</span>
                        </div>
                        <div class="progress" style="height: 8px; background: rgba(255,255,255,0.1);">
                            @php
                                $maxCount = ($topCategories ?? collect())->max('products_count') ?: 1;
                                $percentage = ($category->products_count / $maxCount) * 100;
                            @endphp
                            <div class="progress-bar" role="progressbar" 
                                 style="width: {{ $percentage }}%; background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);">
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <div class="empty-state">
                            <i class="bi bi-tags"></i>
                            <p class="mb-0">Sin datos de categorías</p>
                        </div>
                    </div>
                @endforelse
                
                <!-- Quick Export Links -->
                <div class="mt-4 pt-4 border-top" style="border-color: var(--border-color) !important;">
                    <h6 class="text-white-50 mb-3">Exportar Datos</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.exports.products') }}" class="btn btn-sm btn-outline-light">
                            <i class="bi bi-box-seam me-1"></i>Productos
                        </a>
                        <a href="{{ route('admin.exports.orders') }}" class="btn btn-sm btn-outline-light">
                            <i class="bi bi-bag me-1"></i>Pedidos
                        </a>
                        <a href="{{ route('admin.exports.users') }}" class="btn btn-sm btn-outline-light">
                            <i class="bi bi-people me-1"></i>Clientes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Sales Chart
    const ctx = document.getElementById('monthlySalesChart');
    if (ctx) {
        const monthlySales = @json($monthlySales ?? []);
        
        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: monthlySales.map(s => {
                    const [year, month] = s.month.split('-');
                    const date = new Date(year, month - 1);
                    return date.toLocaleDateString('es', { month: 'short', year: '2-digit' });
                }),
                datasets: [{
                    label: 'Ventas ($)',
                    data: monthlySales.map(s => parseFloat(s.total)),
                    backgroundColor: 'rgba(168, 85, 247, 0.6)',
                    borderColor: '#a855f7',
                    borderWidth: 1,
                    borderRadius: 8,
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
                        ticks: { 
                            color: 'rgba(255,255,255,0.5)',
                            callback: value => '$' + value
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: 'rgba(255,255,255,0.5)' }
                    }
                }
            }
        });
    }
});
</script>
@endpush
