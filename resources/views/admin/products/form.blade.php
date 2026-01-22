@extends('layouts.admin')

@section('title', (isset($product) ? 'Editar' : 'Nuevo') . ' Producto')

@section('content')
<div class="admin-content">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-white-50">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}" class="text-white-50">Productos</a></li>
                    <li class="breadcrumb-item active text-white">{{ isset($product) ? 'Editar' : 'Nuevo' }}</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-white fw-bold">
                <i class="bi bi-{{ isset($product) ? 'pencil-square' : 'plus-circle' }} me-2" style="color: var(--accent);"></i>
                {{ isset($product) ? 'Editar Producto' : 'Nuevo Producto' }}
            </h1>
        </div>
        @if(isset($product))
            <a href="{{ route('products.show', $product->id) }}" target="_blank" class="btn btn-outline-light">
                <i class="bi bi-eye me-2"></i>Ver en tienda
            </a>
        @endif
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Por favor corrige los siguientes errores:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" 
          method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="row g-4">
            <!-- Columna Principal -->
            <div class="col-lg-8">
                <!-- Información Básica -->
                <div class="card-glass p-4 mb-4">
                    <h5 class="mb-4 text-white">
                        <i class="bi bi-info-circle me-2" style="color: var(--accent);"></i>Información Básica
                    </h5>
                    
                    <div class="mb-4">
                        <label class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" 
                               value="{{ old('name', $product->name ?? '') }}" required
                               placeholder="Ej: Camiseta Premium Abstracta">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Descripción</label>
                        <textarea name="description" class="form-control" rows="4"
                                  placeholder="Describe las características del producto, materiales, cuidados, etc.">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Categoría <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Seleccionar categoría</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SKU (Código)</label>
                            <input type="text" name="sku" class="form-control" 
                                   value="{{ old('sku', $product->sku ?? '') }}"
                                   placeholder="Ej: CAM-001-NEG">
                        </div>
                    </div>
                </div>

                <!-- Imágenes -->
                <div class="card-glass p-4 mb-4">
                    <h5 class="mb-4 text-white">
                        <i class="bi bi-images me-2" style="color: var(--accent);"></i>Imágenes del Producto
                    </h5>
                    
                    <div class="mb-4">
                        <label class="form-label">Imagen Principal (URL)</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: rgba(255,255,255,0.05); border-color: var(--border-color);">
                                <i class="bi bi-link-45deg text-white-50"></i>
                            </span>
                            <input type="url" name="image" class="form-control" 
                                   value="{{ old('image', $product->image ?? '') }}"
                                   placeholder="https://ejemplo.com/imagen.jpg" id="imageUrl">
                        </div>
                        <small class="text-white-50">Puedes usar URLs de Unsplash, Cloudinary, o tu propio servidor</small>
                    </div>

                    <div class="mb-4" id="imagePreviewContainer" style="{{ old('image', $product->image ?? '') ? '' : 'display: none;' }}">
                        <label class="form-label">Vista Previa</label>
                        <div class="image-preview-box">
                            <img src="{{ old('image', $product->image ?? 'https://via.placeholder.com/200') }}" 
                                 alt="Preview" id="imagePreview">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small text-white-50">Imagen 2</label>
                            <input type="url" name="image_2" class="form-control form-control-sm" 
                                   value="{{ old('image_2', $product->image_2 ?? '') }}"
                                   placeholder="URL imagen adicional">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-white-50">Imagen 3</label>
                            <input type="url" name="image_3" class="form-control form-control-sm" 
                                   value="{{ old('image_3', $product->image_3 ?? '') }}"
                                   placeholder="URL imagen adicional">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-white-50">Imagen 4</label>
                            <input type="url" name="image_4" class="form-control form-control-sm" 
                                   value="{{ old('image_4', $product->image_4 ?? '') }}"
                                   placeholder="URL imagen adicional">
                        </div>
                    </div>
                </div>

                <!-- Tallas y Colores -->
                <div class="card-glass p-4">
                    <h5 class="mb-4 text-white">
                        <i class="bi bi-palette me-2" style="color: var(--accent);"></i>Variantes del Producto
                    </h5>
                    
                    <!-- Tallas -->
                    <div class="mb-4">
                        <label class="form-label">Tallas Disponibles</label>
                        <div class="sizes-grid">
                            @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', '2XL', '3XL'] as $size)
                                <label class="size-option {{ in_array($size, old('sizes', $product->sizes ?? ['S', 'M', 'L', 'XL'])) ? 'active' : '' }}">
                                    <input type="checkbox" name="sizes[]" value="{{ $size }}"
                                        {{ in_array($size, old('sizes', $product->sizes ?? ['S', 'M', 'L', 'XL'])) ? 'checked' : '' }}>
                                    <span>{{ $size }}</span>
                                </label>
                            @endforeach
                        </div>
                        <small class="text-white-50">Haz clic para seleccionar/deseleccionar tallas</small>
                    </div>

                    <!-- Colores -->
                    <div>
                        <label class="form-label">Colores Disponibles</label>
                        <div class="colors-grid">
                            @php
                                $availableColors = [
                                    'Negro' => '#000000',
                                    'Blanco' => '#FFFFFF',
                                    'Gris' => '#6B7280',
                                    'Azul Marino' => '#1e3a5f',
                                    'Azul' => '#3B82F6',
                                    'Rojo' => '#EF4444',
                                    'Verde' => '#10B981',
                                    'Amarillo' => '#F59E0B',
                                    'Morado' => '#8B5CF6',
                                    'Rosa' => '#EC4899',
                                    'Naranja' => '#F97316',
                                    'Beige' => '#D4B896'
                                ];
                            @endphp
                            @foreach($availableColors as $colorName => $colorHex)
                                <label class="color-option {{ in_array($colorName, old('colors', $product->colors ?? ['Negro', 'Blanco'])) ? 'active' : '' }}">
                                    <input type="checkbox" name="colors[]" value="{{ $colorName }}"
                                        {{ in_array($colorName, old('colors', $product->colors ?? ['Negro', 'Blanco'])) ? 'checked' : '' }}>
                                    <span class="color-swatch" style="background: {{ $colorHex }};"></span>
                                    <span class="color-name">{{ $colorName }}</span>
                                </label>
                            @endforeach
                        </div>
                        <small class="text-white-50">Selecciona los colores en los que está disponible el producto</small>
                    </div>
                </div>
            </div>

            <!-- Columna Lateral -->
            <div class="col-lg-4">
                <!-- Precios -->
                <div class="card-glass p-4 mb-4">
                    <h5 class="mb-4 text-white">
                        <i class="bi bi-currency-dollar me-2 text-success"></i>Precios
                    </h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Precio de Venta (USD) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: rgba(34,197,94,0.2); border-color: rgba(34,197,94,0.3); color: #22c55e;">$</span>
                            <input type="number" step="0.01" name="price" class="form-control" 
                                   value="{{ old('price', $product->price ?? '') }}" required min="0"
                                   placeholder="29.99" id="priceInput">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Precio Original</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: rgba(255,255,255,0.05); border-color: var(--border-color);">$</span>
                            <input type="number" step="0.01" name="original_price" class="form-control" 
                                   value="{{ old('original_price', $product->original_price ?? '') }}" min="0"
                                   placeholder="39.99" id="originalPriceInput">
                        </div>
                        <small class="text-white-50">Solo si hay descuento. Se mostrará tachado.</small>
                    </div>

                    <!-- Calculador de descuento -->
                    <div class="discount-calculator p-3 rounded" style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2);">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-warning small">Descuento calculado:</span>
                            <span class="badge bg-warning text-dark" id="calculatedDiscount">0%</span>
                        </div>
                    </div>
                </div>

                <!-- Inventario -->
                <div class="card-glass p-4 mb-4">
                    <h5 class="mb-4 text-white">
                        <i class="bi bi-box-seam me-2 text-info"></i>Inventario
                    </h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Stock Disponible <span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control" 
                               value="{{ old('stock', $product->stock ?? 100) }}" required min="0"
                               placeholder="100">
                        <div class="stock-indicator mt-2">
                            @if(isset($product))
                                @if($product->stock > 10)
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Stock disponible</span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>Stock bajo</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Sin stock</span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-check form-switch mb-2">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive"
                            {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label text-white" for="isActive">Producto activo</label>
                    </div>
                    <small class="text-white-50">Los productos inactivos no se mostrarán en la tienda</small>
                </div>

                <!-- Destacar -->
                <div class="card-glass p-4 mb-4">
                    <h5 class="mb-4 text-white">
                        <i class="bi bi-star me-2 text-warning"></i>Destacar
                    </h5>
                    
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="is_featured" value="0">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured"
                            {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label text-white" for="isFeatured">Mostrar en inicio</label>
                    </div>

                    <div class="form-check form-switch">
                        <input type="hidden" name="is_new" value="0">
                        <input class="form-check-input" type="checkbox" name="is_new" value="1" id="isNew"
                            {{ old('is_new', $product->is_new ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label text-white" for="isNew">Marcar como nuevo</label>
                    </div>
                </div>

                <!-- Promoción -->
                <div class="card-glass p-4 mb-4">
                    <h5 class="mb-4 text-white">
                        <i class="bi bi-lightning-charge me-2 text-warning"></i>Promoción
                    </h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Descuento (%)</label>
                        <div class="input-group">
                            <input type="number" name="discount_percent" class="form-control" 
                                   value="{{ old('discount_percent', $product->discount_percent ?? '') }}"
                                   placeholder="20" min="0" max="100">
                            <span class="input-group-text" style="background: rgba(239,68,68,0.2); border-color: rgba(239,68,68,0.3); color: #ef4444;">%</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Etiqueta de Promoción</label>
                        <input type="text" name="promotion_label" class="form-control" 
                               value="{{ old('promotion_label', $product->promotion_label ?? '') }}"
                               placeholder="Ej: ¡Oferta Black Friday!">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small">Fecha Inicio</label>
                            <input type="datetime-local" name="promotion_starts" class="form-control form-control-sm" 
                                   value="{{ old('promotion_starts', isset($product->promotion_starts) ? $product->promotion_starts->format('Y-m-d\TH:i') : '') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">Fecha Fin</label>
                            <input type="datetime-local" name="promotion_ends" class="form-control form-control-sm" 
                                   value="{{ old('promotion_ends', isset($product->promotion_ends) ? $product->promotion_ends->format('Y-m-d\TH:i') : '') }}">
                        </div>
                    </div>

                    @if(isset($product) && $product->discount_percent)
                        @php
                            $statusClass = match($product->promotion_status ?? 'permanent') {
                                'active' => 'success',
                                'scheduled' => 'info',
                                'expired' => 'danger',
                                default => 'secondary'
                            };
                            $statusText = match($product->promotion_status ?? 'permanent') {
                                'active' => 'Activa ahora',
                                'scheduled' => 'Programada',
                                'expired' => 'Expirada',
                                default => 'Permanente'
                            };
                        @endphp
                        <div class="promo-status d-flex align-items-center justify-content-between p-2 rounded" 
                             style="background: rgba(var(--bs-{{ $statusClass }}-rgb), 0.1);">
                            <span class="text-{{ $statusClass }} small">
                                <i class="bi bi-info-circle me-1"></i>{{ $statusText }}
                            </span>
                            <span class="badge bg-{{ $statusClass }}">-{{ $product->discount_percent }}%</span>
                        </div>
                    @endif
                </div>

                <!-- Acciones -->
                <div class="card-glass p-4">
                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-lg me-2"></i>
                            {{ isset($product) ? 'Guardar Cambios' : 'Crear Producto' }}
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light">
                            <i class="bi bi-x-lg me-2"></i>Cancelar
                        </a>
                        @if(isset($product))
                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                <i class="bi bi-trash me-2"></i>Eliminar Producto
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@if(isset($product))
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
                <p class="text-white">¿Estás seguro de que deseas eliminar <strong class="text-danger">{{ $product->name }}</strong>?</p>
                <p class="text-white-50 small mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer" style="border-color: var(--border-color);">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .breadcrumb-item a {
        text-decoration: none;
    }
    .breadcrumb-item a:hover {
        color: var(--accent) !important;
    }
    
    .image-preview-box {
        max-width: 200px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid var(--border-color);
    }
    .image-preview-box img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    /* Sizes Grid */
    .sizes-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 8px;
    }
    
    .size-option {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: rgba(255,255,255,0.05);
        border: 2px solid var(--border-color);
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
    }
    
    .size-option input {
        display: none;
    }
    
    .size-option:hover {
        border-color: rgba(168, 85, 247, 0.5);
    }
    
    .size-option.active {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.3) 0%, rgba(99, 102, 241, 0.2) 100%);
        border-color: var(--accent);
        color: white;
    }
    
    /* Colors Grid */
    .colors-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 8px;
    }
    
    .color-option {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 10px;
        background: rgba(255,255,255,0.05);
        border: 2px solid var(--border-color);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .color-option input {
        display: none;
    }
    
    .color-option:hover {
        border-color: rgba(168, 85, 247, 0.5);
    }
    
    .color-option.active {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.3) 0%, rgba(99, 102, 241, 0.2) 100%);
        border-color: var(--accent);
    }
    
    .color-swatch {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.3);
    }
    
    .color-name {
        font-size: 0.85rem;
    }
    
    /* Form switches */
    .form-switch .form-check-input {
        width: 50px;
        height: 26px;
        cursor: pointer;
    }
    
    .form-switch .form-check-input:checked {
        background-color: var(--accent);
        border-color: var(--accent);
    }
</style>
@endpush

@push('scripts')
<script>
    // Image preview
    document.getElementById('imageUrl').addEventListener('input', function(e) {
        const url = e.target.value;
        const container = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        
        if (url) {
            preview.src = url;
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    });

    // Toggle sizes
    document.querySelectorAll('.size-option').forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('active');
            const checkbox = this.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
        });
    });

    // Toggle colors
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('active');
            const checkbox = this.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
        });
    });

    // Calculate discount
    function calculateDiscount() {
        const price = parseFloat(document.getElementById('priceInput').value) || 0;
        const original = parseFloat(document.getElementById('originalPriceInput').value) || 0;
        const discountBadge = document.getElementById('calculatedDiscount');
        
        if (original > 0 && price > 0 && original > price) {
            const discount = Math.round((1 - price / original) * 100);
            discountBadge.textContent = discount + '%';
        } else {
            discountBadge.textContent = '0%';
        }
    }

    document.getElementById('priceInput').addEventListener('input', calculateDiscount);
    document.getElementById('originalPriceInput').addEventListener('input', calculateDiscount);
    calculateDiscount();

    // Delete confirmation
    @if(isset($product))
    function confirmDelete() {
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
    @endif
</script>
@endpush
