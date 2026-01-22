@extends('layouts.app')

@section('title', 'THREADLY - Camisetas Premium Ecuador')

@section('content')
<!-- Hero Section -->
<section class="hero-premium">
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6 hero-content" data-aos="fade-right">
                <div class="hero-badge">
                    <i class="bi bi-lightning-fill"></i>
                    Nueva Colección 2025
                </div>
                <h1 class="hero-title">
                    Camisetas que <span class="highlight">Definen</span> tu Estilo
                </h1>
                <p class="hero-description">
                    Descubre diseños exclusivos, calidad premium y el espíritu ecuatoriano en cada prenda. Envíos a todo el país.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('products.index') }}" class="btn btn-premium btn-primary-premium">
                        <i class="bi bi-bag"></i> Ver Colección
                    </a>
                    <a href="#featured" class="btn btn-premium btn-outline-premium">
                        <i class="bi bi-play-circle"></i> Explorar
                    </a>
                </div>

                <div class="d-flex align-items-center gap-4 mt-5">
                    <div class="d-flex">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt="Customer" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 3px solid white;">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="Customer" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 3px solid white; margin-left: -15px;">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100" alt="Customer" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 3px solid white; margin-left: -15px;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: var(--gradient-2); border: 3px solid white; margin-left: -15px; color: white; font-size: 0.8rem; font-weight: 700;">
                            +2k
                        </div>
                    </div>
                    <div class="text-white">
                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <small style="color: rgba(255,255,255,0.7);">+2,000 clientes felices</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 hero-image-container" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=800" alt="Camisetas Premium" class="hero-image">
                    
                    <div class="floating-card floating-card-1">
                        <div class="icon" style="background: var(--gradient-4);">
                            <i class="bi bi-truck text-dark"></i>
                        </div>
                        <div class="text">
                            <h5>Envío Express</h5>
                            <p>A todo Ecuador</p>
                        </div>
                    </div>
                    
                    <div class="floating-card floating-card-2">
                        <div class="icon" style="background: var(--gradient-2);">
                            <i class="bi bi-shield-check text-white"></i>
                        </div>
                        <div class="text">
                            <h5>100% Algodón</h5>
                            <p>Calidad Premium</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section-premium features-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up">
                <div class="feature-card">
                    <div class="feature-icon" style="background: var(--gradient-1);">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h4>Envío Gratis</h4>
                    <p>En compras mayores a $50 a todo Ecuador</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon" style="background: var(--gradient-2);">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <h4>Pago Seguro</h4>
                    <p>Todas las tarjetas de crédito y débito</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon" style="background: var(--gradient-3);">
                        <i class="bi bi-award"></i>
                    </div>
                    <h4>Calidad Premium</h4>
                    <p>100% algodón peinado de la mejor calidad</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon" style="background: var(--gradient-4);">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <h4>Devoluciones</h4>
                    <p>30 días de garantía en todos los productos</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="section-premium" style="background: var(--light);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Categorías</span>
            <h2 class="section-title">Explora Nuestra Colección</h2>
            <p class="section-subtitle">Encuentra el estilo perfecto para cada ocasión</p>
        </div>

        <div class="row g-4">
            @php
                $categoryImages = [
                    'Camisetas Básicas' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600',
                    'Camisetas Estampadas' => 'https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?w=600',
                    'Camisetas Deportivas' => 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?w=600',
                    'Camisetas Polo' => 'https://images.unsplash.com/photo-1625910513413-5fc42f18b35d?w=600',
                    'Camisetas Manga Larga' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=600',
                ];
            @endphp
            @foreach($categories->take(3) as $index => $category)
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                        <div class="category-premium">
                            <img src="{{ $categoryImages[$category->name] ?? 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600' }}" alt="{{ $category->name }}">
                            <div class="category-overlay">
                                <h3>{{ $category->name }}</h3>
                                <p>{{ $category->products_count ?? $category->products()->count() }} productos</p>
                                <span class="category-btn">
                                    Ver colección <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="section-premium" id="featured" style="background: white;">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Lo Más Vendido</span>
            <h2 class="section-title">Productos Destacados</h2>
            <p class="section-subtitle">Los favoritos de nuestros clientes</p>
        </div>

        <div class="row g-4">
            @forelse($featuredProducts as $index => $product)
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
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
                                <button class="action-btn add-to-cart-btn" data-product-id="{{ $product->id }}" title="Agregar al carrito">
                                    <i class="bi bi-bag-plus"></i>
                                </button>
                                <button class="action-btn" title="Vista rápida">
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
                                        <span class="color-dot" data-color="{{ $color }}"></span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="stretched-link"></a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                    <p class="text-muted">No hay productos destacados disponibles</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('products.index') }}" class="btn btn-premium btn-primary-premium">
                Ver Todos los Productos <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Promo Banner -->
<section class="section-premium" style="background: var(--gradient-hero); position: relative; overflow: hidden;">
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="hero-badge">
                    <i class="bi bi-percent"></i>
                    Oferta Especial
                </span>
                <h2 class="hero-title" style="font-size: clamp(2rem, 4vw, 3.5rem);">
                    Hasta <span class="highlight">30% OFF</span> en Toda la Colección
                </h2>
                <p class="hero-description">
                    Aprovecha nuestros descuentos exclusivos. Oferta válida por tiempo limitado.
                </p>
                <a href="{{ route('products.index', ['sale' => 1]) }}" class="btn btn-premium btn-primary-premium">
                    <i class="bi bi-tag"></i> Ver Ofertas
                </a>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1562157873-818bc0726f68?w=600" alt="Ofertas" class="img-fluid rounded-4 shadow-lg" style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- New Products Section -->
<section class="section-premium" style="background: var(--light);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge" style="background: var(--gradient-4);">Recién Llegados</span>
            <h2 class="section-title">Nuevos Productos</h2>
            <p class="section-subtitle">Los últimos diseños que acabamos de añadir</p>
        </div>

        <div class="row g-4">
            @forelse($newProducts as $index => $product)
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <div class="product-premium">
                        <div class="product-image-container">
                            @php
                                $imageUrl = $product->image && str_starts_with($product->image, 'http') 
                                    ? $product->image 
                                    : ($product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500');
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                            <div class="product-badges">
                                <span class="badge-premium badge-new">Nuevo</span>
                                @if($product->sale_price)
                                    <span class="badge-premium badge-sale">-{{ $product->discount_percent }}%</span>
                                @endif
                            </div>
                            <div class="product-actions">
                                <button class="action-btn add-to-cart-btn" data-product-id="{{ $product->id }}" title="Agregar al carrito">
                                    <i class="bi bi-bag-plus"></i>
                                </button>
                                <button class="action-btn" title="Vista rápida">
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
                                        <span class="color-dot" data-color="{{ $color }}"></span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="stretched-link"></a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                    <p class="text-muted">No hay productos nuevos disponibles</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section-premium" style="background: white;" id="about">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge" style="background: var(--gradient-2);">Testimonios</span>
            <h2 class="section-title">Lo que Dicen Nuestros Clientes</h2>
            <p class="section-subtitle">Miles de clientes felices en todo Ecuador</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="testimonial-text">"Increíble calidad! Las camisetas son súper cómodas y los diseños son únicos. Ya he comprado 5 veces y siempre quedo satisfecha."</p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="María García" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h5>María García</h5>
                            <p>Quito, Ecuador</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="testimonial-text">"El envío fue súper rápido y la atención al cliente excelente. Las camisetas tienen muy buena tela y los colores no se destiñen."</p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt="Carlos Mendoza" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h5>Carlos Mendoza</h5>
                            <p>Guayaquil, Ecuador</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="testimonial-text">"Me encanta que tengan diseños ecuatorianos! Compré la camiseta de Galápagos y es hermosa. 100% recomendado."</p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100" alt="Luis Paredes" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h5>Luis Paredes</h5>
                            <p>Cuenca, Ecuador</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Instagram Feed Section -->
<section class="section-premium" style="background: var(--light);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge" style="background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);">@threadly.ec</span>
            <h2 class="section-title">Síguenos en Instagram</h2>
            <p class="section-subtitle">Comparte tu estilo usando #ThreadlyEC</p>
        </div>

        <div class="row g-3">
            @php
                $instagramImages = [
                    'https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=400',
                    'https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?w=400',
                    'https://images.unsplash.com/photo-1562157873-818bc0726f68?w=400',
                    'https://images.unsplash.com/photo-1571945153237-4929e783af4a?w=400',
                    'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=400',
                    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400',
                ];
            @endphp
            @foreach($instagramImages as $index => $image)
                <div class="col-lg-2 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="{{ $index * 50 }}">
                    <a href="#" class="d-block position-relative overflow-hidden rounded-4" style="aspect-ratio: 1;">
                        <img src="{{ $image }}" alt="Instagram" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s;">
                        <div class="position-absolute inset-0 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s; top: 0; left: 0; right: 0; bottom: 0;">
                            <i class="bi bi-instagram text-white fs-2"></i>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="section-premium newsletter-section">
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>
    <div class="container newsletter-content">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <span class="hero-badge">
                    <i class="bi bi-envelope"></i>
                    Newsletter
                </span>
                <h2 class="hero-title" style="font-size: clamp(1.8rem, 4vw, 2.5rem);">
                    Suscríbete y Obtén <span class="highlight">10% OFF</span>
                </h2>
                <p class="hero-description mx-auto text-center" style="max-width: 100%;">
                    Recibe ofertas exclusivas, novedades y descuentos especiales directamente en tu correo.
                </p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Tu correo electrónico" required>
                    <button type="submit">
                        Suscribirme <i class="bi bi-send ms-2"></i>
                    </button>
                </form>
                <p class="mt-3" style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">
                    <i class="bi bi-shield-check me-1"></i>
                    No spam, solo ofertas increíbles. Puedes cancelar cuando quieras.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Instagram hover effect */
    .col-lg-2 a:hover img {
        transform: scale(1.1);
    }
    .col-lg-2 a:hover > div {
        opacity: 1 !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Apply background colors from data-color attributes
    document.querySelectorAll('.color-dot[data-color]').forEach(function(el) {
        el.style.backgroundColor = el.dataset.color;
    });
    
    // Handle add to cart buttons
    document.querySelectorAll('.add-to-cart-btn[data-product-id]').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            addToCart(this.dataset.productId);
        });
    });
});
</script>
@endpush
