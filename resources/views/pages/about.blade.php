@extends('layouts.app')

@section('title', 'Sobre Nosotros - THREADLY')

@section('content')
<section class="page-header" style="padding: 140px 0 60px;">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="hero-title text-white" style="font-size: 2.5rem;">
            <i class="bi bi-heart me-3"></i>Sobre Nosotros
        </h1>
        <p class="text-white-50">Conoce la historia detrás de THREADLY</p>
    </div>
</section>

<section class="section-premium" style="background: var(--light);">
    <div class="container">
        <!-- Our Story -->
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-badge">Nuestra Historia</span>
                <h2 class="section-title">Pasión por la moda ecuatoriana</h2>
                <p class="text-muted mb-4">
                    THREADLY nació en 2024 con una visión clara: ofrecer camisetas de calidad premium que reflejen 
                    la identidad y el orgullo ecuatoriano. Desde nuestros inicios, nos hemos dedicado a crear prendas 
                    que combinan diseño moderno con la tradición de nuestra tierra.
                </p>
                <p class="text-muted mb-4">
                    Cada una de nuestras camisetas está confeccionada con los mejores materiales, 
                    principalmente algodón peinado 100%, garantizando comodidad, durabilidad y un estilo único.
                </p>
                <div class="d-flex gap-4">
                    <div class="text-center">
                        <h3 class="fw-bold text-primary mb-0">2K+</h3>
                        <small class="text-muted">Clientes felices</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold text-primary mb-0">500+</h3>
                        <small class="text-muted">Diseños únicos</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold text-primary mb-0">24</h3>
                        <small class="text-muted">Provincias</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=600" 
                     alt="Nuestro equipo" class="img-fluid rounded-4 shadow-lg">
            </div>
        </div>

        <!-- Values -->
        <div class="row g-4 mb-5">
            <div class="col-12 text-center mb-4" data-aos="fade-up">
                <span class="section-badge">Nuestros Valores</span>
                <h2 class="section-title">Lo que nos define</h2>
            </div>
            <div class="col-md-4" data-aos="fade-up">
                <div class="card-premium p-4 text-center h-100">
                    <div class="feature-icon mx-auto mb-4" style="background: var(--gradient-1);">
                        <i class="bi bi-gem"></i>
                    </div>
                    <h4>Calidad Premium</h4>
                    <p class="text-muted">Utilizamos solo los mejores materiales para garantizar prendas duraderas y cómodas.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-premium p-4 text-center h-100">
                    <div class="feature-icon mx-auto mb-4" style="background: var(--gradient-2);">
                        <i class="bi bi-flag"></i>
                    </div>
                    <h4>Orgullo Ecuatoriano</h4>
                    <p class="text-muted">Nuestros diseños celebran la cultura, paisajes y tradiciones de Ecuador.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-premium p-4 text-center h-100">
                    <div class="feature-icon mx-auto mb-4" style="background: var(--gradient-3);">
                        <i class="bi bi-recycle"></i>
                    </div>
                    <h4>Sostenibilidad</h4>
                    <p class="text-muted">Comprometidos con prácticas responsables y respetuosas con el medio ambiente.</p>
                </div>
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                <span class="section-badge">¿Por qué elegirnos?</span>
                <h2 class="section-title">La diferencia THREADLY</h2>
                <div class="d-flex gap-3 mb-4">
                    <div class="flex-shrink-0">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-success text-white" 
                             style="width: 30px; height: 30px;">
                            <i class="bi bi-check"></i>
                        </div>
                    </div>
                    <div>
                        <h5>Envío gratis en compras +$50</h5>
                        <p class="text-muted mb-0">A todo Ecuador, sin costo adicional.</p>
                    </div>
                </div>
                <div class="d-flex gap-3 mb-4">
                    <div class="flex-shrink-0">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-success text-white" 
                             style="width: 30px; height: 30px;">
                            <i class="bi bi-check"></i>
                        </div>
                    </div>
                    <div>
                        <h5>Garantía de 30 días</h5>
                        <p class="text-muted mb-0">Devolución sin preguntas si no estás satisfecho.</p>
                    </div>
                </div>
                <div class="d-flex gap-3 mb-4">
                    <div class="flex-shrink-0">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-success text-white" 
                             style="width: 30px; height: 30px;">
                            <i class="bi bi-check"></i>
                        </div>
                    </div>
                    <div>
                        <h5>Atención personalizada</h5>
                        <p class="text-muted mb-0">Soporte por WhatsApp, email y teléfono.</p>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-success text-white" 
                             style="width: 30px; height: 30px;">
                            <i class="bi bi-check"></i>
                        </div>
                    </div>
                    <div>
                        <h5>Pago seguro</h5>
                        <p class="text-muted mb-0">Múltiples opciones de pago con total seguridad.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                <img src="https://images.unsplash.com/photo-1558171813-4c088753af8f?w=600" 
                     alt="Calidad THREADLY" class="img-fluid rounded-4 shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5" style="background: var(--gradient-hero);">
    <div class="container text-center py-5">
        <h2 class="display-5 fw-bold text-white mb-4">¿Listo para vestir con estilo?</h2>
        <p class="lead text-white-50 mb-4">Descubre nuestra colección de camisetas premium</p>
        <a href="{{ route('products.index') }}" class="btn btn-premium btn-primary-premium btn-lg">
            <i class="bi bi-bag me-2"></i>Ver Colección
        </a>
    </div>
</section>
@endsection
