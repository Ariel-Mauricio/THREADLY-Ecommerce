@extends('layouts.app')

@section('title', 'Crear Cuenta - THREADLY')

@section('content')
<section style="min-height: 100vh; display: flex; align-items: center; background: var(--gradient-hero); position: relative; overflow: hidden; padding: 3rem 0;">
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-md-6" data-aos="fade-up">
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="navbar-brand-premium text-decoration-none d-inline-block" style="font-size: 2.5rem;">
                        THREAD<span>LY</span>
                    </a>
                    <p class="text-white-50 mt-2">Únete a la comunidad THREADLY</p>
                </div>

                <div class="card-premium p-5">
                    <h3 class="text-center mb-4">Crear Cuenta</h3>

                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-3">
                            <ul class="mb-0 list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li><i class="bi bi-exclamation-circle me-2"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label-premium">
                                    <i class="bi bi-person me-2"></i>Nombre
                                </label>
                                <input type="text" name="name" class="form-control form-control-premium" 
                                       value="{{ old('name') }}" placeholder="Tu nombre" required autofocus>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label-premium">
                                    <i class="bi bi-telephone me-2"></i>Teléfono
                                </label>
                                <input type="tel" name="phone" class="form-control form-control-premium" 
                                       value="{{ old('phone') }}" placeholder="+593 99 999 9999">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="bi bi-envelope me-2"></i>Email
                            </label>
                            <input type="email" name="email" class="form-control form-control-premium" 
                                   value="{{ old('email') }}" placeholder="tu@email.com" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label-premium">
                                    <i class="bi bi-lock me-2"></i>Contraseña
                                </label>
                                <input type="password" name="password" class="form-control form-control-premium" 
                                       placeholder="Mínimo 8 caracteres" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label-premium">
                                    <i class="bi bi-lock-fill me-2"></i>Confirmar
                                </label>
                                <input type="password" name="password_confirmation" class="form-control form-control-premium" 
                                       placeholder="Repetir contraseña" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="bi bi-geo-alt me-2"></i>Ciudad
                            </label>
                            <select name="city" class="form-control form-control-premium">
                                <option value="">Selecciona tu ciudad</option>
                                <option value="Quito" {{ old('city') == 'Quito' ? 'selected' : '' }}>Quito</option>
                                <option value="Guayaquil" {{ old('city') == 'Guayaquil' ? 'selected' : '' }}>Guayaquil</option>
                                <option value="Cuenca" {{ old('city') == 'Cuenca' ? 'selected' : '' }}>Cuenca</option>
                                <option value="Santo Domingo" {{ old('city') == 'Santo Domingo' ? 'selected' : '' }}>Santo Domingo</option>
                                <option value="Machala" {{ old('city') == 'Machala' ? 'selected' : '' }}>Machala</option>
                                <option value="Manta" {{ old('city') == 'Manta' ? 'selected' : '' }}>Manta</option>
                                <option value="Portoviejo" {{ old('city') == 'Portoviejo' ? 'selected' : '' }}>Portoviejo</option>
                                <option value="Ambato" {{ old('city') == 'Ambato' ? 'selected' : '' }}>Ambato</option>
                                <option value="Riobamba" {{ old('city') == 'Riobamba' ? 'selected' : '' }}>Riobamba</option>
                                <option value="Loja" {{ old('city') == 'Loja' ? 'selected' : '' }}>Loja</option>
                                <option value="Otra" {{ old('city') == 'Otra' ? 'selected' : '' }}>Otra ciudad</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-check d-flex align-items-start gap-2">
                                <input type="checkbox" name="terms" class="form-check-input mt-1" style="width: 20px; height: 20px;" required>
                                <span class="text-muted small">
                                    Acepto los <a href="#" class="text-decoration-none">Términos y Condiciones</a> 
                                    y la <a href="#" class="text-decoration-none">Política de Privacidad</a>
                                </span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="form-check d-flex align-items-start gap-2">
                                <input type="checkbox" name="newsletter" class="form-check-input mt-1" style="width: 20px; height: 20px;">
                                <span class="text-muted small">
                                    Quiero recibir ofertas exclusivas y novedades por email
                                </span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-premium btn-primary-premium w-100 mb-4" style="padding: 1rem;">
                            <i class="bi bi-person-plus me-2"></i>Crear Cuenta
                        </button>

                        <div class="text-center mb-4">
                            <span class="text-muted">O regístrate con</span>
                        </div>

                        <div class="d-flex gap-3 mb-4">
                            <button type="button" class="btn btn-outline-secondary flex-grow-1 py-3 rounded-3">
                                <i class="bi bi-google me-2"></i>Google
                            </button>
                            <button type="button" class="btn btn-outline-secondary flex-grow-1 py-3 rounded-3">
                                <i class="bi bi-facebook me-2"></i>Facebook
                            </button>
                        </div>

                        <div class="text-center">
                            <span class="text-muted">¿Ya tienes cuenta?</span>
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold ms-1">Inicia Sesión</a>
                        </div>
                    </form>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="text-white-50 text-decoration-none">
                        <i class="bi bi-arrow-left me-2"></i>Volver a la tienda
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .navbar-premium {
        display: none !important;
    }
    .footer-premium {
        display: none !important;
    }
    .password-strength {
        height: 4px;
        background: #e9ecef;
        border-radius: 2px;
        margin-top: 0.5rem;
        overflow: hidden;
    }
    .password-strength-bar {
        height: 100%;
        transition: all 0.3s ease;
        border-radius: 2px;
    }
    .password-requirements {
        font-size: 0.75rem;
        margin-top: 0.5rem;
    }
    .password-requirements li {
        color: #6c757d;
        transition: color 0.2s;
    }
    .password-requirements li.valid {
        color: #28a745;
    }
    .password-requirements li.valid::before {
        content: '✓ ';
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const nameInput = form.querySelector('input[name="name"]');
    const emailInput = form.querySelector('input[name="email"]');
    const phoneInput = form.querySelector('input[name="phone"]');
    const passwordInput = form.querySelector('input[name="password"]');
    const confirmInput = form.querySelector('input[name="password_confirmation"]');
    const termsInput = form.querySelector('input[name="terms"]');
    const submitBtn = form.querySelector('button[type="submit"]');

    // Agregar indicador de fuerza de contraseña
    const passwordWrapper = passwordInput.closest('.col-md-6');
    const strengthHtml = `
        <div class="password-strength">
            <div class="password-strength-bar" id="strengthBar"></div>
        </div>
        <ul class="password-requirements list-unstyled mb-0" id="requirements">
            <li id="req-length">Mínimo 8 caracteres</li>
            <li id="req-upper">Una letra mayúscula</li>
            <li id="req-lower">Una letra minúscula</li>
            <li id="req-number">Un número</li>
            <li id="req-special">Un carácter especial (@$!%*?&)</li>
        </ul>
    `;
    passwordWrapper.insertAdjacentHTML('beforeend', strengthHtml);

    // Validar fuerza de contraseña en tiempo real
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        
        // Requisitos
        const hasLength = password.length >= 8;
        const hasUpper = /[A-Z]/.test(password);
        const hasLower = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecial = /[@$!%*?&]/.test(password);

        document.getElementById('req-length').classList.toggle('valid', hasLength);
        document.getElementById('req-upper').classList.toggle('valid', hasUpper);
        document.getElementById('req-lower').classList.toggle('valid', hasLower);
        document.getElementById('req-number').classList.toggle('valid', hasNumber);
        document.getElementById('req-special').classList.toggle('valid', hasSpecial);

        if (hasLength) strength++;
        if (hasUpper) strength++;
        if (hasLower) strength++;
        if (hasNumber) strength++;
        if (hasSpecial) strength++;

        const bar = document.getElementById('strengthBar');
        const colors = ['#dc3545', '#fd7e14', '#ffc107', '#20c997', '#28a745'];
        const widths = ['20%', '40%', '60%', '80%', '100%'];
        
        bar.style.width = widths[strength - 1] || '0%';
        bar.style.background = colors[strength - 1] || '#e9ecef';
    });

    // Formatear teléfono
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d\s\+\-\(\)]/g, '');
            e.target.value = value;
        });
    }

    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let isValid = true;
        clearErrors();

        // Validar nombre
        const nameRegex = /^[\p{L}\s\-']+$/u;
        if (!nameInput.value.trim()) {
            showError(nameInput, 'El nombre es obligatorio');
            isValid = false;
        } else if (!nameRegex.test(nameInput.value)) {
            showError(nameInput, 'El nombre solo puede contener letras');
            isValid = false;
        }

        // Validar email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailInput.value.trim()) {
            showError(emailInput, 'El email es obligatorio');
            isValid = false;
        } else if (!emailRegex.test(emailInput.value)) {
            showError(emailInput, 'Ingresa un email válido');
            isValid = false;
        }

        // Validar teléfono (opcional pero si tiene, debe ser válido)
        if (phoneInput && phoneInput.value.trim()) {
            const phoneRegex = /^[\+]?[0-9\s\-\(\)]{7,20}$/;
            if (!phoneRegex.test(phoneInput.value.replace(/\s/g, ''))) {
                showError(phoneInput, 'Ingresa un teléfono válido');
                isValid = false;
            }
        }

        // Validar contraseña
        const password = passwordInput.value;
        if (!password) {
            showError(passwordInput, 'La contraseña es obligatoria');
            isValid = false;
        } else {
            const hasLength = password.length >= 8;
            const hasUpper = /[A-Z]/.test(password);
            const hasLower = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[@$!%*?&]/.test(password);

            if (!hasLength || !hasUpper || !hasLower || !hasNumber || !hasSpecial) {
                showError(passwordInput, 'La contraseña no cumple los requisitos de seguridad');
                isValid = false;
            }
        }

        // Validar confirmación
        if (confirmInput.value !== passwordInput.value) {
            showError(confirmInput, 'Las contraseñas no coinciden');
            isValid = false;
        }

        // Validar términos
        if (!termsInput.checked) {
            showError(termsInput, 'Debes aceptar los términos y condiciones');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            // Scroll al primer error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
            return;
        }

        // Mostrar loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creando cuenta...';
    });

    function showError(input, message) {
        input.classList.add('is-invalid');
        const wrapper = input.closest('.mb-4') || input.closest('.col-md-6');
        const existing = wrapper.querySelector('.invalid-feedback');
        if (!existing) {
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback d-block';
            feedback.textContent = message;
            wrapper.appendChild(feedback);
        }
    }

    function clearErrors() {
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    }

    // Limpiar errores al escribir
    form.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const wrapper = this.closest('.mb-4') || this.closest('.col-md-6');
            if (wrapper) {
                const feedback = wrapper.querySelector('.invalid-feedback');
                if (feedback) feedback.remove();
            }
        });
    });
});
</script>
@endpush
