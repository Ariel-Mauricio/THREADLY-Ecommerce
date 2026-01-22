@extends('layouts.admin')

@section('title', 'Gestión de Productos')

@section('content')
<div class="admin-content">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-white fw-bold">
                <i class="bi bi-box-seam me-2" style="color: var(--accent);"></i>Productos
            </h1>
            <p class="text-white-50 mb-0">Gestiona tu catálogo de productos • {{ $products->total() ?? 0 }} productos</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Nuevo Producto
        </a>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card-glass p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-purple-subtle me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-box-seam text-purple"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-white-50 small">Total Productos</p>
                        <h5 class="mb-0 text-white fw-bold">{{ $products->total() ?? 0 }}</h5>
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
                        <p class="mb-0 text-white-50 small">En Stock</p>
                        <h5 class="mb-0 text-success fw-bold">{{ ($products ?? collect())->where('stock', '>', 0)->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card-glass p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-orange-subtle me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-exclamation-triangle text-warning"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-white-50 small">Stock Bajo</p>
                        <h5 class="mb-0 text-warning fw-bold">{{ ($products ?? collect())->where('stock', '<=', 5)->where('stock', '>', 0)->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card-glass p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-orange-subtle me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-lightning-charge text-warning"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-white-50 small">En Promoción</p>
                        <h5 class="mb-0 text-warning fw-bold">{{ ($products ?? collect())->whereNotNull('discount_percent')->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card-glass p-4 mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" style="background: rgba(255,255,255,0.05); border-color: var(--border-color);">
                        <i class="bi bi-search text-white-50"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Buscar productos..." id="searchProduct">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterCategory">
                    <option value="">Todas las categorías</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterStock">
                    <option value="">Todo Stock</option>
                    <option value="in">En stock</option>
                    <option value="low">Stock bajo</option>
                    <option value="out">Sin stock</option>
                </select>
            </div>
            <div class="col-md-3 text-md-end">
                <button class="btn btn-outline-light btn-sm me-2" id="exportBtn">
                    <i class="bi bi-download me-1"></i>Exportar
                </button>
                <button class="btn btn-outline-light btn-sm" onclick="window.location.reload()">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card-glass p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 70px;">Imagen</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th class="text-center" style="width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products ?? [] as $product)
                        <tr class="product-row" data-name="{{ strtolower($product->name) }}" 
                            data-category="{{ $product->category_id }}"
                            data-stock="{{ $product->stock }}">
                            <td class="ps-4">
                                <div class="product-img-wrapper">
                                    <img src="{{ $product->image ?? 'https://via.placeholder.com/60x60/1a1a2e/a855f7?text=P' }}" 
                                         alt="{{ $product->name }}" class="product-img">
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong class="text-white d-block">{{ $product->name }}</strong>
                                    <small class="text-white-50">SKU: {{ $product->sku ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background: rgba(168, 85, 247, 0.2); color: #a855f7;">
                                    {{ $product->category->name ?? 'Sin categoría' }}
                                </span>
                            </td>
                            <td>
                                <div>
                                    @if($product->discount_percent)
                                        <strong class="text-success">${{ number_format($product->price, 2) }}</strong>
                                        <br>
                                        <small class="text-white-50 text-decoration-line-through">${{ number_format($product->original_price ?? $product->price, 2) }}</small>
                                        <span class="badge bg-danger ms-1">-{{ $product->discount_percent }}%</span>
                                    @else
                                        <strong class="text-white">${{ number_format($product->price, 2) }}</strong>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if(($product->stock ?? 0) > 10)
                                    <span class="badge bg-success">{{ $product->stock }} uds</span>
                                @elseif(($product->stock ?? 0) > 0)
                                    <span class="badge bg-warning text-dark">{{ $product->stock }} uds</span>
                                @else
                                    <span class="badge bg-danger">Agotado</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @if($product->is_active ?? true)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Inactivo</span>
                                    @endif
                                    @if($product->is_new)
                                        <span class="badge bg-info">Nuevo</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="action-btn view" target="_blank" title="Ver en tienda">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="action-btn edit" title="Editar producto">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Editar</span>
                                    </a>
                                    <button type="button" class="action-btn delete" 
                                            onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')" 
                                            title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $product->id }}" 
                                      action="{{ route('admin.products.destroy', $product->id) }}" 
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-box-seam"></i>
                                    <p class="mb-2">No hay productos registrados</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-lg me-2"></i>Crear primer producto
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($products) && $products->hasPages())
            <div class="p-4 border-top" style="border-color: var(--border-color) !important;">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-dark); border: 1px solid var(--border-color);">
            <div class="modal-header" style="border-color: var(--border-color);">
                <h5 class="modal-title text-white">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Eliminar Producto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-white">¿Estás seguro de que deseas eliminar <strong class="text-danger" id="productName"></strong>?</p>
                <p class="text-white-50 small mb-0">Esta acción no se puede deshacer y se eliminarán todos los datos asociados al producto.</p>
            </div>
            <div class="modal-footer" style="border-color: var(--border-color);">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="bi bi-trash me-2"></i>Eliminar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .product-img-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid var(--border-color);
        transition: all 0.3s ease;
    }
    
    .product-row:hover .product-img-wrapper {
        border-color: var(--accent);
        transform: scale(1.05);
    }
    
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .action-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        background: rgba(255,255,255,0.05);
        color: rgba(255,255,255,0.7);
        cursor: pointer;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
    }
    
    .action-btn.view:hover {
        background: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.3);
        color: #3b82f6;
    }
    
    .action-btn.edit {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.2) 0%, rgba(99, 102, 241, 0.1) 100%);
        border-color: rgba(168, 85, 247, 0.3);
        color: #a855f7;
    }
    
    .action-btn.edit:hover {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.4) 0%, rgba(99, 102, 241, 0.3) 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(168, 85, 247, 0.3);
    }
    
    .action-btn.delete:hover {
        background: rgba(239, 68, 68, 0.2);
        border-color: rgba(239, 68, 68, 0.3);
        color: #ef4444;
    }
    
    .product-row {
        transition: all 0.3s ease;
    }
    
    .product-row:hover {
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
    let productIdToDelete = null;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    
    function confirmDelete(id, name) {
        productIdToDelete = id;
        document.getElementById('productName').textContent = name;
        deleteModal.show();
    }
    
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (productIdToDelete) {
            document.getElementById('delete-form-' + productIdToDelete).submit();
        }
    });
    
    // Search functionality
    document.getElementById('searchProduct').addEventListener('input', function() {
        const search = this.value.toLowerCase();
        document.querySelectorAll('.product-row').forEach(row => {
            const name = row.dataset.name;
            row.style.display = name.includes(search) ? '' : 'none';
        });
    });
    
    // Category filter
    document.getElementById('filterCategory').addEventListener('change', function() {
        const category = this.value;
        document.querySelectorAll('.product-row').forEach(row => {
            if (!category || row.dataset.category == category) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Stock filter
    document.getElementById('filterStock').addEventListener('change', function() {
        const filter = this.value;
        document.querySelectorAll('.product-row').forEach(row => {
            const stock = parseInt(row.dataset.stock);
            let show = true;
            if (filter === 'in') show = stock > 5;
            else if (filter === 'low') show = stock > 0 && stock <= 5;
            else if (filter === 'out') show = stock === 0;
            row.style.display = show ? '' : 'none';
        });
    });
</script>
@endpush
