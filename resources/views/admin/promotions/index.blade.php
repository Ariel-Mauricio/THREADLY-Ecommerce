@extends('layouts.admin')

@section('title', 'Gestión de Promociones')

@section('content')
<div class="admin-content">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-white fw-bold">
                <i class="bi bi-lightning-charge me-2" style="color: #f59e0b;"></i>Promociones
            </h1>
            <p class="text-white-50 mb-0">Gestiona descuentos y ofertas especiales</p>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card-glass p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-green-subtle me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-lightning-charge text-success"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-white-50 small">Promociones Activas</p>
                        <h5 class="mb-0 text-success fw-bold">{{ ($activePromotions ?? collect())->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card-glass p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-blue-subtle me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-clock text-primary"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-white-50 small">Programadas</p>
                        <h5 class="mb-0 text-primary fw-bold">{{ ($scheduledPromotions ?? collect())->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card-glass p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-orange-subtle me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-percent text-warning"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-white-50 small">Descuento Promedio</p>
                        <h5 class="mb-0 text-warning fw-bold">{{ round(($products ?? collect())->avg('discount_percent') ?? 0) }}%</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card-glass p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-purple-subtle me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-box-seam text-purple"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-white-50 small">Productos en Oferta</p>
                        <h5 class="mb-0 text-white fw-bold">{{ ($products ?? collect())->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products with Promotions Table -->
    <div class="card-glass p-0 overflow-hidden">
        <div class="p-4 border-bottom" style="border-color: var(--border-color) !important;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="text-white mb-0">
                        <i class="bi bi-tag me-2" style="color: var(--accent);"></i>Productos con Descuento
                    </h5>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-plus-lg me-1"></i>Añadir Promoción
                    </a>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 70px;">Imagen</th>
                        <th>Producto</th>
                        <th>Precio Original</th>
                        <th>Precio Final</th>
                        <th>Descuento</th>
                        <th>Estado</th>
                        <th>Vigencia</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products ?? [] as $product)
                        <tr class="product-row">
                            <td class="ps-4">
                                <div class="product-img-wrapper">
                                    <img src="{{ $product->image ?? 'https://via.placeholder.com/60' }}" 
                                         alt="{{ $product->name }}" class="product-img">
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong class="text-white d-block">{{ Str::limit($product->name, 30) }}</strong>
                                    <small class="text-white-50">{{ $product->category->name ?? 'Sin categoría' }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="text-white-50 text-decoration-line-through">${{ number_format($product->original_price ?? $product->price / (1 - $product->discount_percent/100), 2) }}</span>
                            </td>
                            <td>
                                <strong class="text-success">${{ number_format($product->price, 2) }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-danger">-{{ $product->discount_percent }}%</span>
                            </td>
                            <td>
                                @php
                                    $status = $product->promotion_status ?? 'permanent';
                                    $statusConfig = [
                                        'active' => ['class' => 'success', 'icon' => 'check-circle', 'label' => 'Activa'],
                                        'scheduled' => ['class' => 'info', 'icon' => 'clock', 'label' => 'Programada'],
                                        'expired' => ['class' => 'danger', 'icon' => 'x-circle', 'label' => 'Expirada'],
                                        'permanent' => ['class' => 'purple', 'icon' => 'infinity', 'label' => 'Permanente'],
                                    ];
                                    $config = $statusConfig[$status] ?? $statusConfig['permanent'];
                                @endphp
                                <span class="badge bg-{{ $config['class'] }}">
                                    <i class="bi bi-{{ $config['icon'] }} me-1"></i>{{ $config['label'] }}
                                </span>
                            </td>
                            <td>
                                @if($product->promotion_starts || $product->promotion_ends)
                                    <small class="text-white-50">
                                        @if($product->promotion_starts)
                                            {{ $product->promotion_starts->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                        →
                                        @if($product->promotion_ends)
                                            {{ $product->promotion_ends->format('d/m/Y') }}
                                        @else
                                            ∞
                                        @endif
                                    </small>
                                @else
                                    <span class="text-white-50">Sin límite</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="btn btn-sm btn-outline-light" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="removePromotion({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                            title="Quitar promoción">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-lightning-charge" style="color: #f59e0b;"></i>
                                    <p class="mb-2">No hay productos en promoción</p>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-warning">
                                        <i class="bi bi-plus-lg me-2"></i>Añadir promoción a un producto
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($products) && method_exists($products, 'hasPages') && $products->hasPages())
            <div class="p-4 border-top" style="border-color: var(--border-color) !important;">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- Quick Tips -->
    <div class="card-glass p-4 mt-4">
        <h5 class="text-white mb-3">
            <i class="bi bi-lightbulb me-2 text-warning"></i>Consejos para Promociones
        </h5>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="p-3 rounded" style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2);">
                    <h6 class="text-warning mb-2"><i class="bi bi-calendar-event me-2"></i>Programar Ofertas</h6>
                    <p class="small text-white-50 mb-0">Configura fechas de inicio y fin para promociones temporales como Black Friday o Navidad.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 rounded" style="background: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2);">
                    <h6 class="text-purple mb-2"><i class="bi bi-tag me-2"></i>Etiquetas Llamativas</h6>
                    <p class="small text-white-50 mb-0">Usa etiquetas como "¡Última oportunidad!" o "Solo hoy" para crear urgencia.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 rounded" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2);">
                    <h6 class="text-success mb-2"><i class="bi bi-graph-up-arrow me-2"></i>Descuentos Efectivos</h6>
                    <p class="small text-white-50 mb-0">Los descuentos del 15-30% suelen tener mejor conversión que descuentos extremos.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Remove Promotion Modal -->
<div class="modal fade" id="removePromoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-dark); border: 1px solid var(--border-color);">
            <div class="modal-header" style="border-color: var(--border-color);">
                <h5 class="modal-title text-white">
                    <i class="bi bi-x-circle text-warning me-2"></i>Quitar Promoción
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-white">¿Estás seguro de quitar la promoción de <strong id="promoProductName" class="text-warning"></strong>?</p>
                <p class="text-white-50 small mb-0">El producto volverá a su precio normal.</p>
            </div>
            <div class="modal-footer" style="border-color: var(--border-color);">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                <form id="removePromoForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="discount_percent" value="">
                    <input type="hidden" name="promotion_label" value="">
                    <input type="hidden" name="promotion_starts" value="">
                    <input type="hidden" name="promotion_ends" value="">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-x-lg me-2"></i>Quitar Promoción
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .product-img-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid var(--border-color);
    }
    
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-row {
        transition: all 0.3s ease;
    }
    
    .product-row:hover {
        background: rgba(245, 158, 11, 0.05) !important;
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
    
    .bg-purple {
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
    }
</style>
@endpush

@push('scripts')
<script>
    const removePromoModal = new bootstrap.Modal(document.getElementById('removePromoModal'));
    
    function removePromotion(productId, productName) {
        document.getElementById('removePromoForm').action = `/admin/products/${productId}`;
        document.getElementById('promoProductName').textContent = productName;
        removePromoModal.show();
    }
</script>
@endpush
