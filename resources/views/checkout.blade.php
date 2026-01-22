@extends('layouts.app')

@section('title', 'Checkout - THREADLY')

@section('content')
<!-- Page Header -->
<section class="page-header" style="padding: 140px 0 60px;">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row">
            <div class="col-12" data-aos="fade-up">
                <h1 class="hero-title text-white" style="font-size: 2.5rem;">
                    <i class="bi bi-bag-check me-3"></i>Checkout
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="background: transparent;">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-white-50">Productos</a></li>
                        <li class="breadcrumb-item text-white active">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="section-premium" style="padding-top: 40px; background: var(--light);">
    <div class="container">
        @include('partials.user-nav-light', ['pageTitle' => 'Finalizar Compra'])
        
        @if(isset($cartItems) && count($cartItems) > 0)
            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="row g-5">
                    <!-- Checkout Form -->
                    <div class="col-lg-7" data-aos="fade-right">
                        
                        <!-- Error Messages -->
                        @if($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 mb-4">
                                <h6 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Por favor corrige los siguientes errores:</h6>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger border-0 rounded-3 mb-4">
                                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        <!-- Contact Information -->
                        <div class="card-premium p-4 mb-4">
                            <h4 class="mb-4 d-flex align-items-center gap-2">
                                <span class="d-flex align-items-center justify-content-center rounded-circle" style="width: 35px; height: 35px; background: var(--gradient-1); color: white; font-size: 0.9rem;">1</span>
                                Información de Contacto
                            </h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-premium">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" id="first_name"
                                           class="form-control form-control-premium @error('first_name') is-invalid @enderror" 
                                           value="{{ old('first_name', auth()->user()->name ?? '') }}" 
                                           placeholder="Tu nombre"
                                           required
                                           pattern="^[\p{L}\s\-]+$"
                                           maxlength="100">
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Apellido <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" id="last_name"
                                           class="form-control form-control-premium @error('last_name') is-invalid @enderror" 
                                           value="{{ old('last_name') }}" 
                                           placeholder="Tu apellido"
                                           required
                                           pattern="^[\p{L}\s\-]+$"
                                           maxlength="100">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email"
                                           class="form-control form-control-premium @error('email') is-invalid @enderror" 
                                           value="{{ old('email', auth()->user()->email ?? '') }}" 
                                           placeholder="tu@email.com"
                                           required
                                           maxlength="255">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Teléfono <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" id="phone"
                                           class="form-control form-control-premium @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone') }}" 
                                           placeholder="+593 99 123 4567" 
                                           required
                                           maxlength="20">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="card-premium p-4 mb-4">
                            <h4 class="mb-4 d-flex align-items-center gap-2">
                                <span class="d-flex align-items-center justify-content-center rounded-circle" style="width: 35px; height: 35px; background: var(--gradient-1); color: white; font-size: 0.9rem;">2</span>
                                Dirección de Envío
                            </h4>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label-premium">Dirección <span class="text-danger">*</span></label>
                                    <input type="text" name="address" id="address"
                                           class="form-control form-control-premium @error('address') is-invalid @enderror" 
                                           value="{{ old('address') }}" 
                                           placeholder="Calle principal y número" 
                                           required
                                           maxlength="500">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label-premium">Referencia <small class="text-muted">(Opcional)</small></label>
                                    <input type="text" name="address_reference" id="address_reference"
                                           class="form-control form-control-premium" 
                                           value="{{ old('address_reference') }}" 
                                           placeholder="Ej: Junto al parque central, edificio azul"
                                           maxlength="255">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Ciudad <span class="text-danger">*</span></label>
                                    <select name="city" id="city" class="form-select form-control-premium @error('city') is-invalid @enderror" required>
                                        <option value="">Selecciona una ciudad</option>
                                        @php
                                            $cities = ['Quito', 'Guayaquil', 'Cuenca', 'Ambato', 'Manta', 'Loja', 'Machala', 'Ibarra', 'Riobamba', 'Esmeraldas', 'Portoviejo', 'Santo Domingo', 'Otra'];
                                        @endphp
                                        @foreach($cities as $city)
                                            <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">Provincia <span class="text-danger">*</span></label>
                                    <select name="province" id="province" class="form-select form-control-premium @error('province') is-invalid @enderror" required>
                                        <option value="">Selecciona una provincia</option>
                                        @php
                                            $provinces = ['Azuay', 'Bolívar', 'Cañar', 'Carchi', 'Chimborazo', 'Cotopaxi', 'El Oro', 'Esmeraldas', 'Galápagos', 'Guayas', 'Imbabura', 'Loja', 'Los Ríos', 'Manabí', 'Morona Santiago', 'Napo', 'Orellana', 'Pastaza', 'Pichincha', 'Santa Elena', 'Santo Domingo de los Tsáchilas', 'Sucumbíos', 'Tungurahua', 'Zamora Chinchipe'];
                                        @endphp
                                        @foreach($provinces as $province)
                                            <option value="{{ $province }}" {{ old('province') == $province ? 'selected' : '' }}>{{ $province }}</option>
                                        @endforeach
                                    </select>
                                    @error('province')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label-premium">Notas adicionales <small class="text-muted">(Opcional)</small></label>
                                    <textarea name="notes" id="notes" 
                                              class="form-control form-control-premium" 
                                              rows="2" 
                                              placeholder="Instrucciones especiales para la entrega..."
                                              maxlength="1000">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="card-premium p-4">
                            <h4 class="mb-4 d-flex align-items-center gap-2">
                                <span class="d-flex align-items-center justify-content-center rounded-circle" style="width: 35px; height: 35px; background: var(--gradient-1); color: white; font-size: 0.9rem;">3</span>
                                Método de Pago
                            </h4>
                            
                            @error('payment_method')
                                <div class="alert alert-danger border-0 rounded-3 mb-3">
                                    <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror

                            <div class="payment-options">
                                <label class="payment-option {{ old('payment_method', 'card') == 'card' ? 'active' : '' }}">
                                    <input type="radio" name="payment_method" value="card" {{ old('payment_method', 'card') == 'card' ? 'checked' : '' }}>
                                    <div class="payment-option-content">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="payment-icon" style="background: var(--gradient-1);">
                                                <i class="bi bi-credit-card text-white"></i>
                                            </div>
                                            <div>
                                                <strong>Tarjeta de Crédito/Débito</strong>
                                                <small class="d-block text-muted">Visa, MasterCard, Diners</small>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2 mt-2">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/200px-Visa_Inc._logo.svg.png" alt="Visa" height="25">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/200px-Mastercard-logo.svg.png" alt="Mastercard" height="25">
                                        </div>
                                    </div>
                                    <i class="bi bi-check-circle-fill check-icon"></i>
                                </label>

                                <label class="payment-option {{ old('payment_method') == 'transfer' ? 'active' : '' }}">
                                    <input type="radio" name="payment_method" value="transfer" {{ old('payment_method') == 'transfer' ? 'checked' : '' }}>
                                    <div class="payment-option-content">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="payment-icon" style="background: var(--gradient-4);">
                                                <i class="bi bi-bank text-dark"></i>
                                            </div>
                                            <div>
                                                <strong>Transferencia Bancaria</strong>
                                                <small class="d-block text-muted">Banco Pichincha, Produbanco, etc.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <i class="bi bi-check-circle-fill check-icon"></i>
                                </label>

                                <!-- Información bancaria para transferencia -->
                                <div id="transfer-info" class="transfer-details mt-3" style="display: none;">
                                    <div class="card border-0 rounded-3 p-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                        <h6 class="mb-3 text-dark d-flex align-items-center gap-2">
                                            <i class="bi bi-info-circle text-primary"></i>
                                            Datos para Transferencia
                                        </h6>
                                        
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="bank-info-item">
                                                    <small class="text-muted d-block">Banco</small>
                                                    <strong class="text-dark">Banco Pichincha</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bank-info-item">
                                                    <small class="text-muted d-block">Tipo de Cuenta</small>
                                                    <strong class="text-dark">Cuenta Corriente</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bank-info-item">
                                                    <small class="text-muted d-block">Número de Cuenta</small>
                                                    <strong class="text-dark" id="account-number">2100123456</strong>
                                                    <button type="button" class="btn btn-sm btn-link p-0 ms-2" onclick="copyToClipboard('2100123456')" title="Copiar">
                                                        <i class="bi bi-clipboard"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bank-info-item">
                                                    <small class="text-muted d-block">Titular</small>
                                                    <strong class="text-dark">THREADLY FASHION S.A.</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bank-info-item">
                                                    <small class="text-muted d-block">RUC</small>
                                                    <strong class="text-dark">1792123456001</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bank-info-item">
                                                    <small class="text-muted d-block">Email de confirmación</small>
                                                    <strong class="text-dark">pagos@threadly.ec</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="my-3">

                                        <!-- Upload comprobante -->
                                        <div class="voucher-upload">
                                            <label class="form-label-premium text-dark">
                                                <i class="bi bi-upload me-1"></i> Subir Comprobante de Pago <span class="text-danger">*</span>
                                            </label>
                                            <div class="upload-zone" id="upload-zone">
                                                <input type="file" name="payment_voucher" id="payment_voucher" 
                                                       accept="image/*,.pdf" class="d-none">
                                                <div class="upload-content text-center py-4" id="upload-content">
                                                    <i class="bi bi-cloud-arrow-up display-4 text-muted"></i>
                                                    <p class="mb-1 text-dark">Arrastra tu comprobante aquí</p>
                                                    <small class="text-muted">o haz clic para seleccionar</small>
                                                    <br>
                                                    <small class="text-muted">PNG, JPG, PDF (máx. 5MB)</small>
                                                </div>
                                                <div class="upload-preview d-none" id="upload-preview">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="preview-icon">
                                                            <i class="bi bi-file-earmark-check text-success fs-1"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <strong class="text-dark d-block" id="file-name">archivo.jpg</strong>
                                                            <small class="text-muted" id="file-size">1.2 MB</small>
                                                        </div>
                                                        <button type="button" class="btn btn-outline-danger btn-sm" id="remove-file">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('payment_voucher')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted d-block mt-2">
                                                <i class="bi bi-shield-check text-success me-1"></i>
                                                Tu pedido será procesado una vez verificado el pago
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <label class="payment-option {{ old('payment_method') == 'cash' ? 'active' : '' }}">
                                    <input type="radio" name="payment_method" value="cash" {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
                                    <div class="payment-option-content">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="payment-icon" style="background: var(--gradient-2);">
                                                <i class="bi bi-cash-coin text-white"></i>
                                            </div>
                                            <div>
                                                <strong>Pago Contra Entrega</strong>
                                                <small class="d-block text-muted">Paga cuando recibas tu pedido</small>
                                            </div>
                                        </div>
                                    </div>
                                    <i class="bi bi-check-circle-fill check-icon"></i>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-5" data-aos="fade-left">
                        <div class="card-premium p-4 sticky-top" style="top: 100px;">
                            <h4 class="mb-4">
                                <i class="bi bi-receipt me-2"></i>Resumen del Pedido
                            </h4>
                            
                            <div class="order-items mb-4" style="max-height: 350px; overflow-y: auto;">
                                @foreach($cartItems as $item)
                                    <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                                        @php
                                            $imageUrl = $item->product->image && str_starts_with($item->product->image, 'http') 
                                                ? $item->product->image 
                                                : ($item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/80');
                                        @endphp
                                        <div class="position-relative flex-shrink-0">
                                            <img src="{{ $imageUrl }}" alt="{{ $item->product->name }}" 
                                                 class="rounded-3" style="width: 70px; height: 70px; object-fit: cover;">
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark" style="font-size: 0.7rem;">
                                                {{ $item->quantity }}
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 min-width-0">
                                            <h6 class="mb-1 text-truncate" title="{{ $item->product->name }}">{{ $item->product->name }}</h6>
                                            <small class="text-muted d-block">
                                                @if($item->size) Talla: {{ $item->size }} @endif
                                                @if($item->color) 
                                                    @if($item->size) | @endif
                                                    <span class="color-indicator" data-color="{{ $item->color }}"></span>
                                                @endif
                                            </small>
                                            <div class="d-flex justify-content-between align-items-center mt-1">
                                                <small class="text-muted">${{ number_format($item->price, 2) }} c/u</small>
                                                <strong class="text-primary">${{ number_format($item->subtotal, 2) }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Coupon (diseño solamente) -->
                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-premium" placeholder="Código de descuento" style="border-radius: 15px 0 0 15px;" disabled>
                                    <button class="btn btn-dark px-4" type="button" style="border-radius: 0 15px 15px 0;" disabled>
                                        <i class="bi bi-tag"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Próximamente: cupones de descuento</small>
                            </div>

                            <!-- Totals -->
                            <div class="border-top pt-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal ({{ $cartItems->sum('quantity') }} productos)</span>
                                    <span>${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">
                                        Envío
                                        @if($shipping == 0)
                                            <span class="badge bg-success ms-1">GRATIS</span>
                                        @endif
                                    </span>
                                    <span>{{ $shipping > 0 ? '$' . number_format($shipping, 2) : 'Gratis' }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">IVA (12%)</span>
                                    <span>${{ number_format($tax, 2) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-4">
                                    <strong style="font-size: 1.2rem;">Total</strong>
                                    <strong style="font-size: 1.5rem; color: var(--primary);">${{ number_format($total, 2) }}</strong>
                                </div>

                                <button type="submit" class="btn btn-premium btn-primary-premium w-100" id="submit-btn" style="padding: 1.2rem;">
                                    <i class="bi bi-lock me-2"></i>
                                    <span id="btn-text">Confirmar Pedido</span>
                                    <span id="btn-loading" class="d-none">
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                        Procesando...
                                    </span>
                                </button>

                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-shield-check me-1"></i>
                                        Pago 100% seguro con encriptación SSL
                                    </small>
                                </div>

                                <div class="text-center mt-2">
                                    <a href="{{ route('products.index') }}" class="text-muted text-decoration-none">
                                        <i class="bi bi-arrow-left me-1"></i>Continuar comprando
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <i class="bi bi-cart-x display-1 text-muted mb-4"></i>
                <h3>Tu carrito está vacío</h3>
                <p class="text-muted mb-4">Agrega algunos productos para continuar con tu compra</p>
                <a href="{{ route('products.index') }}" class="btn btn-premium btn-primary-premium">
                    <i class="bi bi-bag me-2"></i>Ver Productos
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .payment-options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .payment-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.2rem;
        border: 2px solid #e2e8f0;
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-option:hover {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.02);
    }

    .payment-option.active {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.05);
    }

    .payment-option input {
        display: none;
    }

    .payment-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .check-icon {
        color: var(--primary);
        font-size: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .payment-option.active .check-icon {
        opacity: 1;
    }

    .form-control-premium.is-invalid {
        border-color: #dc3545;
    }

    .form-control-premium.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
    }

    .order-items::-webkit-scrollbar {
        width: 6px;
    }

    .order-items::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .order-items::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    .min-width-0 {
        min-width: 0;
    }

    /* Transfer details styles */
    .transfer-details {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bank-info-item {
        padding: 0.5rem;
        background: white;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .upload-zone {
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .upload-zone:hover,
    .upload-zone.drag-over {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.05);
    }

    .upload-zone.has-file {
        border-style: solid;
        border-color: #28a745;
        background: rgba(40, 167, 69, 0.05);
    }

    .preview-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(40, 167, 69, 0.1);
        border-radius: 12px;
    }

    .upload-preview img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const transferInfo = document.getElementById('transfer-info');
    const uploadZone = document.getElementById('upload-zone');
    const fileInput = document.getElementById('payment_voucher');
    const uploadContent = document.getElementById('upload-content');
    const uploadPreview = document.getElementById('upload-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const removeFileBtn = document.getElementById('remove-file');

    // Payment option selection
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            this.querySelector('input').checked = true;

            // Show/hide transfer info
            const selectedMethod = this.querySelector('input').value;
            if (selectedMethod === 'transfer') {
                transferInfo.style.display = 'block';
            } else {
                transferInfo.style.display = 'none';
            }
        });
    });

    // Check if transfer is already selected (e.g., after validation error)
    const transferRadio = document.querySelector('input[name="payment_method"][value="transfer"]');
    if (transferRadio && transferRadio.checked) {
        transferInfo.style.display = 'block';
    }

    // File upload handling
    if (uploadZone && fileInput) {
        // Click to upload
        uploadZone.addEventListener('click', function(e) {
            if (e.target !== removeFileBtn && !removeFileBtn.contains(e.target)) {
                fileInput.click();
            }
        });

        // Drag and drop
        uploadZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('drag-over');
        });

        uploadZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
        });

        uploadZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFile(files[0]);
            }
        });

        // File input change
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleFile(this.files[0]);
            }
        });

        // Remove file
        if (removeFileBtn) {
            removeFileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                clearFile();
            });
        }
    }

    function handleFile(file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            alert('Tipo de archivo no permitido. Solo se aceptan imágenes (JPG, PNG, GIF, WEBP) y PDF.');
            return;
        }

        // Validate file size (5MB max)
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('El archivo es demasiado grande. Máximo 5MB.');
            return;
        }

        // Update file input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;

        // Show preview
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        
        uploadContent.classList.add('d-none');
        uploadPreview.classList.remove('d-none');
        uploadZone.classList.add('has-file');
    }

    function clearFile() {
        fileInput.value = '';
        uploadContent.classList.remove('d-none');
        uploadPreview.classList.add('d-none');
        uploadZone.classList.remove('has-file');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Copy to clipboard function
    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show toast notification
            const toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 end-0 p-3';
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <div class="toast show" role="alert">
                    <div class="toast-body bg-success text-white rounded">
                        <i class="bi bi-check-circle me-2"></i>Copiado al portapapeles
                    </div>
                </div>
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2000);
        });
    };

    // Form validation and submission
    const form = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');

    form.addEventListener('submit', function(e) {
        // Basic client-side validation
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Check if transfer is selected and voucher is required
        const paymentMethod = form.querySelector('input[name="payment_method"]:checked');
        if (paymentMethod && paymentMethod.value === 'transfer') {
            if (!fileInput.files || fileInput.files.length === 0) {
                isValid = false;
                uploadZone.style.borderColor = '#dc3545';
                alert('Por favor sube el comprobante de pago para continuar.');
                return;
            }
        }

        // Email validation
        const email = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email.value && !emailRegex.test(email.value)) {
            isValid = false;
            email.classList.add('is-invalid');
        }

        // Phone validation
        const phone = document.getElementById('phone');
        const phoneRegex = /^[\+]?[0-9\s\-\(\)]{7,20}$/;
        if (phone.value && !phoneRegex.test(phone.value.replace(/\s/g, ''))) {
            isValid = false;
            phone.classList.add('is-invalid');
        }

        if (!isValid) {
            e.preventDefault();
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
    });

    // Remove invalid class on input
    form.querySelectorAll('.form-control-premium, .form-select').forEach(field => {
        field.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });

    // Phone formatting
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        // Allow only numbers, spaces, plus, parentheses, and dashes
        let value = e.target.value.replace(/[^\d\s\+\-\(\)]/g, '');
        e.target.value = value;
    });
    
    // Apply color indicators
    document.querySelectorAll('.color-indicator[data-color]').forEach(function(el) {
        el.style.cssText = 'display:inline-block;width:12px;height:12px;border-radius:50%;background:' + el.dataset.color + ';vertical-align:middle;border:1px solid #ddd;';
    });
});
</script>
@endpush
