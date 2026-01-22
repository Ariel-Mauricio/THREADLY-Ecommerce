@extends('layouts.app')

@section('title', 'Pago con Tarjeta - THREADLY')

@section('content')
<section class="py-5" style="min-height: 100vh; background: var(--gradient-hero); position: relative; overflow: hidden; padding-top: 120px !important;">
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8" data-aos="fade-up">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold text-white mb-3">
                        <i class="bi bi-shield-lock me-3"></i>Pago Seguro
                    </h1>
                    <p class="text-white-50 lead">Completa tu compra de forma segura</p>
                </div>

                <div class="card-premium p-4 p-md-5">
                    <!-- Order Summary -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h5 class="mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-receipt text-primary"></i>
                            Resumen del Pedido #{{ $order->order_number ?? 'N/A' }}
                        </h5>
                        <div class="bg-light rounded-3 p-3">
                            <div class="d-flex justify-content-between text-muted mb-2">
                                <span>Subtotal</span>
                                <span>${{ number_format($order->subtotal ?? 0, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted mb-2">
                                <span>Envío</span>
                                <span>{{ ($order->shipping_cost ?? 0) > 0 ? '$' . number_format($order->shipping_cost, 2) : 'Gratis' }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted mb-2">
                                <span>IVA (12%)</span>
                                <span>${{ number_format($order->tax ?? 0, 2) }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total a Pagar</span>
                                <span class="text-primary">${{ number_format($order->total ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Accepted Cards -->
                    <div class="text-center mb-4">
                        <span class="text-muted small d-block mb-2">Aceptamos</span>
                        <div class="d-flex justify-content-center gap-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/200px-Visa_Inc._logo.svg.png" alt="Visa" height="30">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/200px-Mastercard-logo.svg.png" alt="Mastercard" height="30">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/American_Express_logo_%282018%29.svg/200px-American_Express_logo_%282018%29.svg.png" alt="AmEx" height="30">
                        </div>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger border-0 rounded-3 mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="paymentForm" method="POST" action="{{ route('payment.payphone.process', $order) }}" novalidate>
                        @csrf

                        <!-- Card Holder Name -->
                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="bi bi-person me-2"></i>Nombre del Titular
                            </label>
                            <input type="text" name="card_name" id="cardHolder" 
                                   class="form-control form-control-premium @error('card_name') is-invalid @enderror" 
                                   placeholder="Como aparece en la tarjeta" 
                                   value="{{ old('card_name', $order->customer_name ?? '') }}"
                                   required
                                   autocomplete="cc-name"
                                   maxlength="100"
                                   style="text-transform: uppercase;">
                            @error('card_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Card Number -->
                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="bi bi-credit-card me-2"></i>Número de Tarjeta
                            </label>
                            <div class="position-relative">
                                <input type="text" name="card_number" id="cardNumber" 
                                       class="form-control form-control-premium @error('card_number') is-invalid @enderror" 
                                       placeholder="1234 5678 9012 3456" 
                                       required 
                                       maxlength="19"
                                       autocomplete="cc-number"
                                       inputmode="numeric"
                                       style="padding-right: 60px;">
                                <div class="position-absolute end-0 top-50 translate-middle-y me-3">
                                    <i class="bi bi-credit-card-2-front fs-4 text-muted" id="cardIcon"></i>
                                </div>
                            </div>
                            @error('card_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" id="cardType"></small>
                        </div>

                        <div class="row">
                            <!-- Expiry Date -->
                            <div class="col-6 mb-4">
                                <label class="form-label-premium">
                                    <i class="bi bi-calendar3 me-2"></i>Expiración
                                </label>
                                <input type="text" name="card_expiry" id="expiry" 
                                       class="form-control form-control-premium @error('card_expiry') is-invalid @enderror" 
                                       placeholder="MM/AA" 
                                       required 
                                       maxlength="5"
                                       autocomplete="cc-exp"
                                       inputmode="numeric">
                                @error('card_expiry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- CVV -->
                            <div class="col-6 mb-4">
                                <label class="form-label-premium">
                                    <i class="bi bi-shield-lock me-2"></i>CVV
                                </label>
                                <div class="position-relative">
                                    <input type="password" name="card_cvv" id="cvv" 
                                           class="form-control form-control-premium @error('card_cvv') is-invalid @enderror" 
                                           placeholder="•••" 
                                           required 
                                           maxlength="4"
                                           autocomplete="cc-csc"
                                           inputmode="numeric">
                                    <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-2 p-0" 
                                            data-bs-toggle="tooltip" 
                                            data-bs-placement="top" 
                                            title="Código de 3 o 4 dígitos en el reverso de tu tarjeta"
                                            style="background: transparent; border: none;">
                                        <i class="bi bi-question-circle text-muted"></i>
                                    </button>
                                </div>
                                @error('card_cvv')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="bi bi-envelope me-2"></i>Email para Recibo
                            </label>
                            <input type="email" name="card_email" id="cardEmail"
                                   class="form-control form-control-premium @error('card_email') is-invalid @enderror" 
                                   value="{{ old('card_email', $order->customer_email ?? auth()->user()->email ?? '') }}" 
                                   placeholder="tu@email.com" 
                                   required
                                   autocomplete="email"
                                   maxlength="255">
                            @error('card_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Terms Checkbox -->
                        <div class="mb-4">
                            <label class="form-check d-flex align-items-start gap-2">
                                <input type="checkbox" name="accept_terms" id="acceptTerms" class="form-check-input mt-1" style="width: 18px; height: 18px;" required>
                                <span class="text-muted small">
                                    Acepto los <a href="#" class="text-primary">términos y condiciones</a> y la <a href="#" class="text-primary">política de privacidad</a>
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="payButton" class="btn btn-premium btn-primary-premium w-100" 
                                style="padding: 1.2rem; font-size: 1.1rem;">
                            <span id="btnText">
                                <i class="bi bi-lock-fill me-2"></i>
                                Pagar ${{ number_format($order->total ?? 0, 2) }}
                            </span>
                            <span id="btnLoading" class="d-none">
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Procesando pago...
                            </span>
                        </button>

                        <div class="text-center mt-4">
                            <a href="{{ route('checkout') }}" class="text-muted text-decoration-none">
                                <i class="bi bi-arrow-left me-2"></i>Volver al checkout
                            </a>
                        </div>
                    </form>

                    <!-- Security Info -->
                    <div class="mt-5 pt-4 border-top">
                        <div class="row text-center text-muted small g-3">
                            <div class="col-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-shield-check fs-4 mb-2" style="color: var(--accent);"></i>
                                    <span>Pago 100% Seguro</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-lock-fill fs-4 mb-2" style="color: var(--accent);"></i>
                                    <span>SSL Encriptado</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-patch-check fs-4 mb-2" style="color: var(--accent);"></i>
                                    <span>Datos Protegidos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Provider Info -->
                <div class="text-center mt-4">
                    <span class="text-white-50 small">Transacción procesada de forma segura</span>
                    <div class="d-flex justify-content-center align-items-center gap-3 mt-2">
                        <i class="bi bi-shield-fill-check text-white-50 fs-5"></i>
                        <span class="text-white small">256-bit SSL</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .form-control-premium.is-invalid {
        border-color: #dc3545;
    }
    
    .form-control-premium.is-valid {
        border-color: #198754;
    }
    
    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    #cardNumber.visa + div #cardIcon {
        color: #1a1f71;
    }
    
    #cardNumber.mastercard + div #cardIcon {
        color: #eb001b;
    }
    
    #cardNumber.amex + div #cardIcon {
        color: #006fcf;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Card number formatting and validation
    const cardNumber = document.getElementById('cardNumber');
    const cardIcon = document.getElementById('cardIcon');
    const cardType = document.getElementById('cardType');
    
    cardNumber.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '').replace(/\D/g, '');
        let formatted = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formatted;
        
        // Detect card type
        cardNumber.classList.remove('visa', 'mastercard', 'amex');
        
        if (value.startsWith('4')) {
            cardIcon.className = 'bi bi-credit-card-2-front fs-4';
            cardIcon.style.color = '#1a1f71';
            cardType.textContent = 'Visa';
            cardNumber.classList.add('visa');
        } else if (value.startsWith('5') || (value.startsWith('2') && value.length > 1 && value[1] >= '2' && value[1] <= '7')) {
            cardIcon.className = 'bi bi-credit-card-2-front fs-4';
            cardIcon.style.color = '#eb001b';
            cardType.textContent = 'Mastercard';
            cardNumber.classList.add('mastercard');
        } else if (value.startsWith('3') && (value[1] === '4' || value[1] === '7')) {
            cardIcon.className = 'bi bi-credit-card-2-front fs-4';
            cardIcon.style.color = '#006fcf';
            cardType.textContent = 'American Express';
            cardNumber.classList.add('amex');
        } else {
            cardIcon.className = 'bi bi-credit-card-2-front fs-4 text-muted';
            cardType.textContent = '';
        }
        
        // Validate card number (Luhn algorithm)
        if (value.length >= 13) {
            if (luhnCheck(value)) {
                cardNumber.classList.remove('is-invalid');
                cardNumber.classList.add('is-valid');
            } else {
                cardNumber.classList.remove('is-valid');
                cardNumber.classList.add('is-invalid');
            }
        } else {
            cardNumber.classList.remove('is-valid', 'is-invalid');
        }
    });

    // Luhn algorithm for card validation
    function luhnCheck(num) {
        let arr = (num + '').split('').reverse().map(x => parseInt(x));
        let sum = arr.reduce((acc, val, i) => {
            if (i % 2 !== 0) {
                val = val * 2;
                if (val > 9) val = val - 9;
            }
            return acc + val;
        }, 0);
        return sum % 10 === 0;
    }

    // Expiry formatting and validation
    const expiry = document.getElementById('expiry');
    expiry.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            let month = parseInt(value.substring(0, 2));
            if (month > 12) month = 12;
            if (month < 1 && value.length >= 2) month = '0' + value[1];
            value = String(month).padStart(2, '0') + '/' + value.substring(2, 4);
        }
        e.target.value = value;
        
        // Validate expiry
        if (value.length === 5) {
            const [month, year] = value.split('/');
            const now = new Date();
            const currentYear = now.getFullYear() % 100;
            const currentMonth = now.getMonth() + 1;
            const expYear = parseInt(year);
            const expMonth = parseInt(month);
            
            if (expYear > currentYear || (expYear === currentYear && expMonth >= currentMonth)) {
                expiry.classList.remove('is-invalid');
                expiry.classList.add('is-valid');
            } else {
                expiry.classList.remove('is-valid');
                expiry.classList.add('is-invalid');
            }
        } else {
            expiry.classList.remove('is-valid', 'is-invalid');
        }
    });

    // CVV - only numbers
    const cvv = document.getElementById('cvv');
    cvv.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
        
        if (e.target.value.length >= 3) {
            cvv.classList.remove('is-invalid');
            cvv.classList.add('is-valid');
        } else {
            cvv.classList.remove('is-valid', 'is-invalid');
        }
    });

    // Card holder - uppercase
    const cardHolder = document.getElementById('cardHolder');
    cardHolder.addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase().replace(/[^A-Z\s]/g, '');
    });

    // Email validation
    const cardEmail = document.getElementById('cardEmail');
    cardEmail.addEventListener('blur', function(e) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailRegex.test(e.target.value)) {
            cardEmail.classList.remove('is-invalid');
            cardEmail.classList.add('is-valid');
        } else {
            cardEmail.classList.remove('is-valid');
            cardEmail.classList.add('is-invalid');
        }
    });

    // Form submission
    const form = document.getElementById('paymentForm');
    const payButton = document.getElementById('payButton');
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validate card number
        const cardNum = cardNumber.value.replace(/\s/g, '');
        if (cardNum.length < 13 || !luhnCheck(cardNum)) {
            cardNumber.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validate expiry
        if (expiry.value.length !== 5 || expiry.classList.contains('is-invalid')) {
            expiry.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validate CVV
        if (cvv.value.length < 3) {
            cvv.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validate card holder
        if (cardHolder.value.trim().length < 3) {
            cardHolder.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(cardEmail.value)) {
            cardEmail.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validate terms
        const acceptTerms = document.getElementById('acceptTerms');
        if (!acceptTerms.checked) {
            acceptTerms.classList.add('is-invalid');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
            return;
        }
        
        // Show loading state
        payButton.disabled = true;
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
    });

    // Remove invalid class on input
    form.querySelectorAll('.form-control-premium, .form-check-input').forEach(field => {
        field.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
});
</script>
@endpush
