@extends('layouts.app')

@section('title', 'Iniciar Sesión - THREADLY')

@section('content')
<section style="min-height: 100vh; display: flex; align-items: center; background: var(--gradient-hero); position: relative; overflow: hidden;">
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-md-5" data-aos="fade-up">
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="navbar-brand-premium text-decoration-none d-inline-block" style="font-size: 2.5rem;">
                        THREAD<span>LY</span>
                    </a>
                    <p class="text-white-50 mt-2">Bienvenido de nuevo</p>
                </div>

                <div class="card-premium p-5">
                    <h3 class="text-center mb-4">Iniciar Sesión</h3>

                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-3">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="bi bi-envelope me-2"></i>Email
                            </label>
                            <input type="email" name="email" class="form-control form-control-premium" 
                                   value="{{ old('email') }}" placeholder="tu@email.com" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-premium d-flex justify-content-between">
                                <span><i class="bi bi-lock me-2"></i>Contraseña</span>
                                <a href="{{ route('password.request') }}" class="text-decoration-none small">¿Olvidaste tu contraseña?</a>
                            </label>
                            <div class="position-relative">
                                <input type="password" name="password" id="password" class="form-control form-control-premium" 
                                       placeholder="••••••••" required>
                                <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-2" onclick="togglePassword()">
                                    <i class="bi bi-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4 d-flex align-items-center justify-content-between">
                            <label class="form-check d-flex align-items-center gap-2">
                                <input type="checkbox" name="remember" class="form-check-input" style="width: 20px; height: 20px;">
                                <span>Recordarme</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-premium btn-primary-premium w-100 mb-4" style="padding: 1rem;">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                        </button>

                        <div class="text-center mb-4">
                            <span class="text-muted">O continúa con</span>
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
                            <span class="text-muted">¿No tienes cuenta?</span>
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold ms-1">Regístrate</a>
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
</style>
@endpush

@push('scripts')
<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Validación del formulario de login
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const emailInput = form.querySelector('input[name="email"]');
        const passwordInput = form.querySelector('input[name="password"]');
        const submitBtn = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function(e) {
            let isValid = true;
            clearErrors();

            // Validar email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailInput.value.trim()) {
                showError(emailInput, 'El email es obligatorio');
                isValid = false;
            } else if (!emailRegex.test(emailInput.value)) {
                showError(emailInput, 'Ingresa un email válido');
                isValid = false;
            }

            // Validar contraseña
            if (!passwordInput.value) {
                showError(passwordInput, 'La contraseña es obligatoria');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return;
            }

            // Mostrar loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Ingresando...';
        });

        function showError(input, message) {
            input.classList.add('is-invalid');
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = message;
            input.parentElement.appendChild(feedback);
        }

        function clearErrors() {
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
        }

        // Limpiar error al escribir
        [emailInput, passwordInput].forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                const feedback = this.parentElement.querySelector('.invalid-feedback');
                if (feedback) feedback.remove();
            });
        });
    });
</script>
@endpush
