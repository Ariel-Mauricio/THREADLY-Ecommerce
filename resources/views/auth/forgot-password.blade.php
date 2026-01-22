@extends('layouts.app')

@section('title', 'Recuperar Contraseña - THREADLY')

@section('content')
<div class="container py-5" style="padding-top: 120px !important;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="icon-circle mx-auto mb-3" style="width: 80px; height: 80px; background: var(--gradient-1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-key text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h3 class="mb-2">¿Olvidaste tu contraseña?</h3>
                        <p class="text-muted">No te preocupes. Ingresa tu correo y te enviaremos instrucciones para restablecerla.</p>
                    </div>

                    @if(session('status'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" 
                                       placeholder="tu@email.com" required autofocus>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-envelope me-2"></i>Enviar Enlace de Recuperación
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i>Volver al inicio de sesión
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
