@extends('layouts.app')

@section('title', 'Colección - THREADLY')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row">
            <div class="col-lg-8" data-aos="fade-up">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="background: transparent; padding: 0;">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white text-decoration-none">Inicio</a></li>
                        <li class="breadcrumb-item active text-white-50">Colección</li>
                    </ol>
                </nav>
                <h1 class="hero-title" style="font-size: clamp(2rem, 5vw, 3.5rem);">
                    Nuestra <span class="highlight">Colección</span>
                </h1>
                <p class="hero-description">
                    Explora todos nuestros diseños y encuentra la camiseta perfecta para ti
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="section-premium" style="background: var(--light);">
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 mb-4 mb-lg-0" data-aos="fade-right">
                <div class="card-premium p-4 sticky-top" style="top: 100px;">
                    <h5 class="mb-4 d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-funnel me-2"></i>Filtros</span>
                        <a href="{{ route('products.index') }}" class="text-decoration-none small text-muted">Limpiar</a>
                    </h5>

                    <!-- Categories -->
                    <div class="mb-4">
                        <h6 class="text-uppercase small fw-bold mb-3" style="letter-spacing: 1px; color: var(--gray);">Categorías</h6>
                        <div class="d-flex flex-column gap-2">
                            @foreach($categories as $category)
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                                   class="d-flex align-items-center justify-content-between text-decoration-none py-2 px-3 rounded-3 {{ request('category') == $category->slug ? 'bg-primary text-white' : 'text-dark' }}"
                                   style="{{ request('category') != $category->slug ? 'background: #f1f5f9;' : '' }} transition: all 0.3s;">
                                    <span>{{ $category->name }}</span>
                                    <span class="badge {{ request('category') == $category->slug ? 'bg-white text-primary' : 'bg-primary' }}">
                                        {{ $category->products_count ?? $category->products()->count() }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-4">
                        <h6 class="text-uppercase small fw-bold mb-3" style="letter-spacing: 1px; color: var(--gray);">Precio</h6>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('products.index', array_merge(request()->query(), ['price' => '0-20'])) }}" 
                               class="text-decoration-none py-2 px-3 rounded-3 {{ request('price') == '0-20' ? 'bg-primary text-white' : 'text-dark' }}"
                               style="{{ request('price') != '0-20' ? 'background: #f1f5f9;' : '' }}">
                                Hasta $20
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->query(), ['price' => '20-35'])) }}" 
                               class="text-decoration-none py-2 px-3 rounded-3 {{ request('price') == '20-35' ? 'bg-primary text-white' : 'text-dark' }}"
                               style="{{ request('price') != '20-35' ? 'background: #f1f5f9;' : '' }}">
                                $20 - $35
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->query(), ['price' => '35-50'])) }}" 
                               class="text-decoration-none py-2 px-3 rounded-3 {{ request('price') == '35-50' ? 'bg-primary text-white' : 'text-dark' }}"
                               style="{{ request('price') != '35-50' ? 'background: #f1f5f9;' : '' }}">
                                $35 - $50
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->query(), ['price' => '50+'])) }}" 
                               class="text-decoration-none py-2 px-3 rounded-3 {{ request('price') == '50+' ? 'bg-primary text-white' : 'text-dark' }}"
                               style="{{ request('price') != '50+' ? 'background: #f1f5f9;' : '' }}">
                                Más de $50
                            </a>
                        </div>
                    </div>

                    <!-- Quick Filters -->
                    <div class="mb-4">
                        <h6 class="text-uppercase small fw-bold mb-3" style="letter-spacing: 1px; color: var(--gray);">Filtros Rápidos</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('products.index', ['sale' => 1]) }}" 
                               class="badge rounded-pill py-2 px-3 text-decoration-none {{ request('sale') ? 'text-white' : 'text-dark' }}"
                               style="background: {{ request('sale') ? 'var(--gradient-2)' : '#f1f5f9' }};">
                                <i class="bi bi-tag me-1"></i>En Oferta
                            </a>
                            <a href="{{ route('products.index', ['featured' => 1]) }}" 
                               class="badge rounded-pill py-2 px-3 text-decoration-none {{ request('featured') ? 'text-white' : 'text-dark' }}"
                               style="background: {{ request('featured') ? 'var(--gradient-1)' : '#f1f5f9' }};">
                                <i class="bi bi-star me-1"></i>Destacados
                            </a>
                            <a href="{{ route('products.index', ['new' => 1]) }}" 
                               class="badge rounded-pill py-2 px-3 text-decoration-none {{ request('new') ? 'text-white' : 'text-dark' }}"
                               style="background: {{ request('new') ? 'var(--gradient-4)' : '#f1f5f9' }};">
                                <i class="bi bi-lightning me-1"></i>Nuevos
                            </a>
                        </div>
                    </div>

                    <!-- Sizes -->
                    <div>
                        <h6 class="text-uppercase small fw-bold mb-3" style="letter-spacing: 1px; color: var(--gray);">Tallas</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                <a href="{{ route('products.index', array_merge(request()->query(), ['size' => $size])) }}" 
                                   class="btn {{ request('size') == $size ? 'btn-dark' : 'btn-outline-dark' }}"
                                   style="min-width: 50px;">
                                    {{ $size }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <!-- Toolbar -->
                <div class="card-premium p-3 mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3" data-aos="fade-up">
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted">
                            <strong>{{ $products->total() }}</strong> productos encontrados
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <select class="form-select form-select-sm rounded-pill" style="min-width: 180px;" onchange="window.location.href=this.value">
                            <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'newest'])) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Más recientes</option>
                            <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                            <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                            <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'name'])) }}" {{ request('sort') == 'name' ? 'selected' : '' }}>Nombre A-Z</option>
                        </select>
                        <div class="btn-group d-none d-md-flex">
                            <button class="btn btn-outline-secondary btn-sm active" data-view="grid">
                                <i class="bi bi-grid-3x3-gap"></i>
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" data-view="list">
                                <i class="bi bi-list"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="row g-4" id="products-grid">
                    @forelse($products as $index => $product)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($index % 6) * 50 }}">
                            <div class="product-premium">
                                <div class="product-image-container">
                                    @php
                                        $imageUrl = $product->image && str_starts_with($product->image, 'http') 
                                            ? $product->image 
                                            : ($product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500');
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                                    <div class="product-badges">
                                        @if($product->sale_price)
                                            <span class="badge-premium badge-sale">-{{ $product->discount_percent }}%</span>
                                        @endif
                                        @if($product->created_at->diffInDays(now()) < 7)
                                            <span class="badge-premium badge-new">Nuevo</span>
                                        @endif
                                    </div>
                                    <div class="product-actions">
                                        <button class="action-btn" onclick="event.preventDefault(); addToCart({{ $product->id }})" title="Agregar al carrito">
                                            <i class="bi bi-bag-plus"></i>
                                        </button>
                                        <button class="action-btn" title="Vista rápida" data-bs-toggle="modal" data-bs-target="#quickView{{ $product->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="action-btn" title="Favorito">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <span class="product-category">{{ $product->category->name ?? 'Sin categoría' }}</span>
                                    <h3 class="product-name">{{ $product->name }}</h3>
                                    <div class="product-price-container">
                                        <span class="current-price">${{ number_format($product->final_price, 2) }}</span>
                                        @if($product->sale_price)
                                            <span class="original-price">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                    @if($product->colors && is_array($product->colors))
                                        <div class="product-colors">
                                            @foreach(array_slice($product->colors, 0, 4) as $color)
                                                <span class="color-dot" style="background: {{ $color }};"></span>
                                            @endforeach
                                            @if(count($product->colors) > 4)
                                                <span class="small text-muted">+{{ count($product->colors) - 4 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}" class="stretched-link"></a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                                <h4>No se encontraron productos</h4>
                                <p class="text-muted">Intenta con otros filtros o <a href="{{ route('products.index') }}">ver todos los productos</a></p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
                        {{ $products->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Quick View Modals -->
@foreach($products as $product)
<div class="modal fade" id="quickView{{ $product->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 25px; border: none;">
            <div class="modal-body p-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" style="z-index: 10;"></button>
                <div class="row g-0">
                    <div class="col-md-6">
                        @php
                            $imageUrl = $product->image && str_starts_with($product->image, 'http') 
                                ? $product->image 
                                : ($product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500');
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-100 h-100" style="object-fit: cover; border-radius: 25px 0 0 25px; min-height: 400px;">
                    </div>
                    <div class="col-md-6 p-4 d-flex flex-column justify-content-center">
                        <span class="product-category">{{ $product->category->name ?? 'Sin categoría' }}</span>
                        <h3 class="mb-3">{{ $product->name }}</h3>
                        <div class="product-price-container mb-3">
                            <span class="current-price">${{ number_format($product->final_price, 2) }}</span>
                            @if($product->sale_price)
                                <span class="original-price">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <p class="text-muted mb-4">{{ Str::limit($product->description, 150) }}</p>
                        
                        @if($product->sizes && is_array($product->sizes))
                            <div class="mb-3">
                                <label class="form-label-premium">Talla</label>
                                <div class="d-flex gap-2">
                                    @foreach($product->sizes as $size)
                                        <button class="btn btn-outline-dark size-btn" data-size="{{ $size }}">{{ $size }}</button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="d-flex gap-2 mt-auto">
                            <button class="btn btn-premium btn-primary-premium flex-grow-1" onclick="addToCart({{ $product->id }})">
                                <i class="bi bi-bag-plus me-2"></i>Agregar al Carrito
                            </button>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-premium btn-outline-premium" style="border-color: var(--dark); color: var(--dark);">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('styles')
<style>
    .pagination {
        gap: 0.5rem;
    }
    .pagination .page-link {
        border-radius: 10px;
        border: none;
        padding: 0.75rem 1rem;
        color: var(--dark);
        font-weight: 500;
    }
    .pagination .page-item.active .page-link {
        background: var(--gradient-1);
    }
    .size-btn.active {
        background: var(--dark);
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    // Size selection in quick view
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.d-flex').querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
@endpush
