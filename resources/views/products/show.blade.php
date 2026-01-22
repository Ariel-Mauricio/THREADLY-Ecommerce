@extends('layouts.app')

@section('title', $product->name . ' - THREADLY')

@section('content')
<!-- Product Detail Section -->
<section style="padding-top: 120px; background: var(--light); min-height: 100vh;">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4" data-aos="fade-up">
            <ol class="breadcrumb" style="background: transparent; padding: 0;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Colección</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active text-muted">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Product Images -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-sticky" style="top: 120px;">
                    <div class="card-premium overflow-hidden mb-3">
                        @php
                            $imageUrl = $product->image && str_starts_with($product->image, 'http') 
                                ? $product->image 
                                : ($product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800');
                        @endphp
                        <div class="position-relative">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-100" id="main-image" style="aspect-ratio: 1; object-fit: cover;">
                            
                            <div class="product-badges position-absolute" style="top: 1rem; left: 1rem;">
                                @if($product->sale_price)
                                    <span class="badge-premium badge-sale">-{{ $product->discount_percent }}%</span>
                                @endif
                                @if($product->created_at->diffInDays(now()) < 7)
                                    <span class="badge-premium badge-new">Nuevo</span>
                                @endif
                            </div>

                            <!-- Zoom button -->
                            <button class="btn position-absolute" style="bottom: 1rem; right: 1rem; background: white; border-radius: 50%; width: 50px; height: 50px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);" data-bs-toggle="modal" data-bs-target="#imageModal">
                                <i class="bi bi-zoom-in"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Thumbnail Gallery -->
                    <div class="d-flex gap-2">
                        <div class="thumbnail-item active" style="width: 80px; height: 80px; border-radius: 15px; overflow: hidden; border: 3px solid var(--primary); cursor: pointer;">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <!-- Add more thumbnails here if you have multiple images -->
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="product-detail-info">
                    <!-- Category & Rating -->
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="badge rounded-pill px-3 py-2" style="background: var(--gradient-1); color: white;">
                            {{ $product->category->name ?? 'Sin categoría' }}
                        </span>
                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <span class="ms-2 text-muted small">(24 reseñas)</span>
                        </div>
                    </div>

                    <!-- Title -->
                    <h1 class="mb-3" style="font-size: 2.5rem; font-weight: 800;">{{ $product->name }}</h1>

                    <!-- Price -->
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span style="font-size: 2.5rem; font-weight: 800; color: var(--dark);">
                            ${{ number_format($product->final_price, 2) }}
                        </span>
                        @if($product->sale_price)
                            <span style="font-size: 1.5rem; color: var(--gray); text-decoration: line-through;">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            <span class="badge rounded-pill px-3 py-2" style="background: var(--gradient-2); color: white;">
                                Ahorras ${{ number_format($product->price - $product->sale_price, 2) }}
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    <p class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                        {{ $product->description }}
                    </p>

                    <!-- Divider -->
                    <hr class="my-4">

                    <!-- Product Form -->
                    <form id="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Colors -->
                        @if($product->colors && is_array($product->colors) && count($product->colors) > 0)
                            @php
                                $colorMap = [
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
                                    'Beige' => '#D4B896',
                                    'Celeste' => '#87CEEB',
                                    'Café' => '#8B4513',
                                    'Turquesa' => '#40E0D0',
                                    'Vino' => '#722F37',
                                    'Coral' => '#FF7F50',
                                    'Oliva' => '#808000',
                                    'Dorado' => '#FFD700',
                                    'Plateado' => '#C0C0C0'
                                ];
                            @endphp
                            <div class="mb-4">
                                <label class="form-label-premium d-flex align-items-center gap-2">
                                    <span>Color:</span>
                                    <span id="selected-color-name" class="text-muted">{{ $product->colors[0] ?? 'Selecciona un color' }}</span>
                                </label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach($product->colors as $index => $color)
                                        @php
                                            $colorHex = $colorMap[$color] ?? '#CCCCCC';
                                            $borderStyle = ($color === 'Blanco') ? 'border: 2px solid #ccc;' : '';
                                        @endphp
                                        <label class="color-option">
                                            <input type="radio" name="color" value="{{ $color }}" class="d-none" {{ $index === 0 ? 'checked' : '' }}>
                                            <span class="color-circle {{ $index === 0 ? 'active' : '' }}" 
                                                  style="background: {{ $colorHex }}; {{ $borderStyle }}" 
                                                  data-color="{{ $color }}" 
                                                  data-hex="{{ $colorHex }}"
                                                  title="{{ $color }}"></span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Sizes -->
                        @if($product->sizes && is_array($product->sizes) && count($product->sizes) > 0)
                            <div class="mb-4">
                                <label class="form-label-premium d-flex align-items-center justify-content-between">
                                    <span>Talla:</span>
                                    <a href="#" class="text-decoration-none small" data-bs-toggle="modal" data-bs-target="#sizeGuide">
                                        <i class="bi bi-rulers me-1"></i>Guía de tallas
                                    </a>
                                </label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach($product->sizes as $index => $size)
                                        <label class="size-option">
                                            <input type="radio" name="size" value="{{ $size }}" class="d-none" {{ $index === 0 ? 'checked' : '' }}>
                                            <span class="size-box {{ $index === 0 ? 'active' : '' }}">{{ $size }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Quantity -->
                        <div class="mb-4">
                            <label class="form-label-premium">Cantidad:</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="quantity-selector d-flex align-items-center">
                                    <button type="button" class="qty-btn-detail" onclick="changeQuantity(-1)">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="quantity-input">
                                    <button type="button" class="qty-btn-detail" onclick="changeQuantity(1)">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                <span class="text-muted small">
                                    <i class="bi bi-box-seam me-1"></i>
                                    {{ $product->stock }} disponibles
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 mb-4">
                            <button type="submit" class="btn btn-premium btn-primary-premium flex-grow-1" style="padding: 1.2rem 2rem;">
                                <i class="bi bi-bag-plus me-2"></i>Agregar al Carrito
                            </button>
                            <button type="button" class="btn btn-premium btn-outline-premium" style="border-color: #e2e8f0; padding: 1.2rem;">
                                <i class="bi bi-heart"></i>
                            </button>
                            <button type="button" class="btn btn-premium btn-outline-premium" style="border-color: #e2e8f0; padding: 1.2rem;">
                                <i class="bi bi-share"></i>
                            </button>
                        </div>

                        <!-- Buy Now -->
                        <button type="button" class="btn btn-premium w-100 mb-4" style="background: var(--dark); color: white; padding: 1.2rem 2rem;" onclick="buyNow()">
                            <i class="bi bi-lightning-fill me-2"></i>Comprar Ahora
                        </button>
                    </form>

                    <!-- Trust Badges -->
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background: #f1f5f9;">
                                <i class="bi bi-truck fs-4" style="color: var(--primary);"></i>
                                <div>
                                    <small class="d-block fw-bold">Envío Express</small>
                                    <small class="text-muted">2-3 días hábiles</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background: #f1f5f9;">
                                <i class="bi bi-shield-check fs-4" style="color: var(--accent);"></i>
                                <div>
                                    <small class="d-block fw-bold">Garantía</small>
                                    <small class="text-muted">30 días</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background: #f1f5f9;">
                                <i class="bi bi-credit-card fs-4" style="color: var(--secondary);"></i>
                                <div>
                                    <small class="d-block fw-bold">Pago Seguro</small>
                                    <small class="text-muted">SSL 256-bit</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="row mt-5">
            <div class="col-12" data-aos="fade-up">
                <div class="card-premium p-4">
                    <ul class="nav nav-pills mb-4" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill px-4" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button">
                                Descripción
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill px-4" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button">
                                Detalles
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill px-4" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button">
                                Reseñas (24)
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="productTabsContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <p class="text-muted" style="line-height: 2;">
                                {{ $product->description }}
                            </p>
                            <ul class="list-unstyled mt-4">
                                <li class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    100% Algodón peinado de alta calidad
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    Costuras reforzadas para mayor durabilidad
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    Estampado de alta definición que no se destiñe
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    Corte moderno y cómodo
                                </li>
                                <li class="d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    Hecho en Ecuador 🇪🇨
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="details" role="tabpanel">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Material</th>
                                        <td>100% Algodón Peinado</td>
                                    </tr>
                                    <tr>
                                        <th>Gramaje</th>
                                        <td>180 g/m²</td>
                                    </tr>
                                    <tr>
                                        <th>Tallas disponibles</th>
                                        <td>{{ is_array($product->sizes) ? implode(', ', $product->sizes) : $product->sizes }}</td>
                                    </tr>
                                    <tr>
                                        <th>Colores</th>
                                        <td>{{ is_array($product->colors) ? count($product->colors) : 1 }} opciones</td>
                                    </tr>
                                    <tr>
                                        <th>Cuidados</th>
                                        <td>Lavar a máquina en frío. No usar blanqueador. Secar a temperatura baja.</td>
                                    </tr>
                                    <tr>
                                        <th>Origen</th>
                                        <td>Ecuador 🇪🇨</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <!-- Review Summary -->
                            <div class="row align-items-center mb-4">
                                <div class="col-md-4 text-center border-end">
                                    <div class="display-3 fw-bold">4.9</div>
                                    <div class="d-flex justify-content-center gap-1 mb-2">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </div>
                                    <small class="text-muted">Basado en 24 reseñas</small>
                                </div>
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span style="width: 30px;">5★</span>
                                        <div class="progress flex-grow-1" style="height: 10px; border-radius: 5px;">
                                            <div class="progress-bar" style="width: 85%; background: var(--gradient-4);"></div>
                                        </div>
                                        <span class="text-muted small">20</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span style="width: 30px;">4★</span>
                                        <div class="progress flex-grow-1" style="height: 10px; border-radius: 5px;">
                                            <div class="progress-bar" style="width: 12%; background: var(--gradient-3);"></div>
                                        </div>
                                        <span class="text-muted small">3</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span style="width: 30px;">3★</span>
                                        <div class="progress flex-grow-1" style="height: 10px; border-radius: 5px;">
                                            <div class="progress-bar" style="width: 4%; background: var(--gradient-1);"></div>
                                        </div>
                                        <span class="text-muted small">1</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Sample Reviews -->
                            <div class="border-top pt-4">
                                <div class="d-flex gap-3 mb-4 pb-4 border-bottom">
                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="User" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <strong>María López</strong>
                                            <div class="d-flex gap-1">
                                                <i class="bi bi-star-fill text-warning small"></i>
                                                <i class="bi bi-star-fill text-warning small"></i>
                                                <i class="bi bi-star-fill text-warning small"></i>
                                                <i class="bi bi-star-fill text-warning small"></i>
                                                <i class="bi bi-star-fill text-warning small"></i>
                                            </div>
                                            <small class="text-muted">hace 2 días</small>
                                        </div>
                                        <p class="text-muted mb-0">Excelente calidad! La tela es muy suave y el estampado quedó perfecto. Ya es mi segunda compra.</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-3">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt="User" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <strong>Carlos Pérez</strong>
                                            <div class="d-flex gap-1">
                                                <i class="bi bi-star-fill text-warning small"></i>
                                                <i class="bi bi-star-fill text-warning small"></i>
                                                <i class="bi bi-star-fill text-warning small"></i>
                                                <i class="bi bi-star-fill text-warning small"></i>
                                                <i class="bi bi-star-fill text-warning small"></i>
                                            </div>
                                            <small class="text-muted">hace 1 semana</small>
                                        </div>
                                        <p class="text-muted mb-0">Muy buena camiseta, el envío fue rápido y llegó bien empacada. La recomiendo!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <div class="section-header text-start" data-aos="fade-up">
                        <span class="section-badge">También te puede gustar</span>
                        <h2 class="section-title">Productos Relacionados</h2>
                    </div>
                </div>
                @foreach($relatedProducts as $index => $related)
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                        <div class="product-premium">
                            <div class="product-image-container">
                                @php
                                    $relatedImageUrl = $related->image && str_starts_with($related->image, 'http') 
                                        ? $related->image 
                                        : ($related->image ? asset('storage/' . $related->image) : 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500');
                                @endphp
                                <img src="{{ $relatedImageUrl }}" alt="{{ $related->name }}">
                                <div class="product-badges">
                                    @if($related->sale_price)
                                        <span class="badge-premium badge-sale">-{{ $related->discount_percent }}%</span>
                                    @endif
                                </div>
                                <div class="product-actions">
                                    <button class="action-btn" onclick="event.preventDefault(); addToCart({{ $related->id }})">
                                        <i class="bi bi-bag-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <span class="product-category">{{ $related->category->name ?? 'Sin categoría' }}</span>
                                <h3 class="product-name">{{ $related->name }}</h3>
                                <div class="product-price-container">
                                    <span class="current-price">${{ number_format($related->final_price, 2) }}</span>
                                    @if($related->sale_price)
                                        <span class="original-price">${{ number_format($related->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('products.show', $related->slug) }}" class="stretched-link"></a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="background: transparent; border: none;">
            <div class="modal-body p-0 text-center">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3 bg-white p-3" data-bs-dismiss="modal" style="z-index: 10; border-radius: 50%;"></button>
                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="img-fluid rounded-4" style="max-height: 90vh;">
            </div>
        </div>
    </div>
</div>

<!-- Size Guide Modal -->
<div class="modal fade" id="sizeGuide" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 25px;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Guía de Tallas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead style="background: var(--gradient-1); color: white;">
                        <tr>
                            <th>Talla</th>
                            <th>Pecho (cm)</th>
                            <th>Largo (cm)</th>
                            <th>Hombro (cm)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>S</strong></td><td>96-100</td><td>68</td><td>42</td></tr>
                        <tr><td><strong>M</strong></td><td>100-104</td><td>70</td><td>44</td></tr>
                        <tr><td><strong>L</strong></td><td>104-108</td><td>72</td><td>46</td></tr>
                        <tr><td><strong>XL</strong></td><td>108-112</td><td>74</td><td>48</td></tr>
                        <tr><td><strong>XXL</strong></td><td>112-116</td><td>76</td><td>50</td></tr>
                    </tbody>
                </table>
                <p class="text-muted small mt-3">
                    <i class="bi bi-info-circle me-1"></i>
                    Las medidas pueden variar ±2cm. Si estás entre dos tallas, te recomendamos elegir la más grande.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .color-circle {
        display: inline-block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        border: 3px solid transparent;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .color-circle:hover,
    .color-circle.active {
        border-color: var(--primary);
        transform: scale(1.1);
    }

    .size-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: #f1f5f9;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .size-box:hover,
    .size-box.active {
        background: var(--dark);
        color: white;
    }

    .quantity-selector {
        background: #f1f5f9;
        border-radius: 15px;
        padding: 0.3rem;
    }

    .qty-btn-detail {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        border: none;
        background: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .qty-btn-detail:hover {
        background: var(--primary);
        color: white;
    }

    .quantity-input {
        width: 60px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .quantity-input:focus {
        outline: none;
    }

    .nav-pills .nav-link {
        color: var(--dark);
        font-weight: 500;
    }

    .nav-pills .nav-link.active {
        background: var(--gradient-1);
    }

    .thumbnail-item {
        opacity: 0.7;
        transition: all 0.3s ease;
    }

    .thumbnail-item.active,
    .thumbnail-item:hover {
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    // Color selection
    document.querySelectorAll('.color-circle').forEach(circle => {
        circle.addEventListener('click', function() {
            document.querySelectorAll('.color-circle').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            this.closest('label').querySelector('input').checked = true;
            
            // Update color name display
            const colorName = this.getAttribute('data-color');
            const colorNameSpan = document.getElementById('selected-color-name');
            if (colorNameSpan && colorName) {
                colorNameSpan.textContent = colorName;
            }
        });
    });

    // Size selection
    document.querySelectorAll('.size-box').forEach(box => {
        box.addEventListener('click', function() {
            document.querySelectorAll('.size-box').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            this.closest('label').querySelector('input').checked = true;
        });
    });

    // Quantity change
    function changeQuantity(delta) {
        const input = document.getElementById('quantity');
        const newValue = parseInt(input.value) + delta;
        const max = parseInt(input.max);
        if (newValue >= 1 && newValue <= max) {
            input.value = newValue;
        }
    }

    // Add to cart form
    document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = {
            product_id: formData.get('product_id'),
            size: formData.get('size'),
            color: formData.get('color'),
            quantity: parseInt(formData.get('quantity'))
        };

        addToCart(data.product_id, data.size, data.color, data.quantity);
    });

    // Buy now
    function buyNow() {
        document.getElementById('add-to-cart-form').dispatchEvent(new Event('submit'));
        setTimeout(() => {
            window.location.href = '{{ route("checkout") }}';
        }, 500);
    }
</script>
@endpush
