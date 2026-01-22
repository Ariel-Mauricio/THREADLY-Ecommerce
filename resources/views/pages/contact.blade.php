@extends('layouts.app')

@section('title', 'Contacto - THREADLY')

@section('content')
<section class="page-header" style="padding: 140px 0 60px;">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="hero-title text-white" style="font-size: 2.5rem;">
            <i class="bi bi-envelope me-3"></i>Contáctanos
        </h1>
        <p class="text-white-50">Estamos aquí para ayudarte</p>
    </div>
</section>

<section class="section-premium" style="background: var(--light);">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-7" data-aos="fade-right">
                <div class="card-premium p-5">
                    <h3 class="mb-4">Envíanos un mensaje</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success border-0 rounded-3 mb-4">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 mb-4">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-premium">Nombre completo <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-premium" 
                                       value="{{ old('name') }}" required maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-premium">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-premium" 
                                       value="{{ old('email') }}" required maxlength="255">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-premium">Teléfono</label>
                                <input type="tel" name="phone" class="form-control form-control-premium" 
                                       value="{{ old('phone') }}" maxlength="20">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-premium">Asunto <span class="text-danger">*</span></label>
                                <select name="subject" class="form-select form-control-premium" required>
                                    <option value="">Selecciona un asunto</option>
                                    <option value="consulta" {{ old('subject') == 'consulta' ? 'selected' : '' }}>Consulta general</option>
                                    <option value="pedido" {{ old('subject') == 'pedido' ? 'selected' : '' }}>Sobre mi pedido</option>
                                    <option value="devolucion" {{ old('subject') == 'devolucion' ? 'selected' : '' }}>Devolución o cambio</option>
                                    <option value="mayorista" {{ old('subject') == 'mayorista' ? 'selected' : '' }}>Ventas mayoristas</option>
                                    <option value="otro" {{ old('subject') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label-premium">Número de pedido (si aplica)</label>
                                <input type="text" name="order_number" class="form-control form-control-premium" 
                                       value="{{ old('order_number') }}" placeholder="ORD-XXXXXXXX">
                            </div>
                            <div class="col-12">
                                <label class="form-label-premium">Mensaje <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control form-control-premium" rows="5" 
                                          required maxlength="2000" placeholder="¿En qué podemos ayudarte?">{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-premium btn-primary-premium">
                                    <i class="bi bi-send me-2"></i>Enviar mensaje
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-5" data-aos="fade-left">
                <div class="card-premium p-5 mb-4">
                    <h3 class="mb-4">Información de contacto</h3>
                    
                    <div class="d-flex gap-3 mb-4">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 50px; height: 50px; background: var(--gradient-1);">
                                <i class="bi bi-geo-alt text-white fs-5"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-1">Dirección</h5>
                            <p class="text-muted mb-0">Quito, Ecuador<br>Av. Principal 123</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-4">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 50px; height: 50px; background: var(--gradient-2);">
                                <i class="bi bi-telephone text-white fs-5"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-1">Teléfono</h5>
                            <p class="text-muted mb-0">+593 99 123 4567<br>Lun - Vie: 9:00 - 18:00</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-4">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 50px; height: 50px; background: var(--gradient-3);">
                                <i class="bi bi-envelope text-white fs-5"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-1">Email</h5>
                            <p class="text-muted mb-0">info@threadly.ec<br>soporte@threadly.ec</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 50px; height: 50px; background: var(--gradient-4);">
                                <i class="bi bi-whatsapp text-dark fs-5"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-1">WhatsApp</h5>
                            <p class="text-muted mb-0">+593 99 123 4567<br>Respuesta inmediata</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="card-premium p-5">
                    <h3 class="mb-4">Síguenos</h3>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" 
                           style="width: 50px; height: 50px;">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                        <a href="#" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" 
                           style="width: 50px; height: 50px;">
                            <i class="bi bi-instagram fs-5"></i>
                        </a>
                        <a href="#" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" 
                           style="width: 50px; height: 50px;">
                            <i class="bi bi-tiktok fs-5"></i>
                        </a>
                        <a href="#" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" 
                           style="width: 50px; height: 50px;">
                            <i class="bi bi-twitter-x fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
