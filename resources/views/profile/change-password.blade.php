@extends('layouts.app')

@section('title', 'Cambiar Contraseña - THREADLY')

@push('styles')
<style>
    .profile-section {
        min-height: 100vh;
        background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #0f0f1a 100%);
        padding-top: 120px !important;
    }
    .profile-sidebar {
        background: rgba(255,255,255,0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        overflow: hidden;
    }
    .profile-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    .profile-nav-item:hover {
        background: rgba(168, 85, 247, 0.1);
        color: #a855f7;
        border-left-color: #a855f7;
    }
    .profile-nav-item.active {
        background: rgba(168, 85, 247, 0.15);
        color: #a855f7;
        border-left-color: #a855f7;
    }
    .profile-nav-item.logout-btn:hover {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border-left-color: #ef4444;
    }
    .profile-card {
        background: rgba(255,255,255,0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        overflow: hidden;
    }
    .profile-card-header {
        background: rgba(255,255,255,0.05);
        padding: 20px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .form-control {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        color: #fff !important;
        border-radius: 10px;
        padding: 12px 16px;
    }
    .form-control:focus {
        background: rgba(255,255,255,0.08) !important;
        border-color: #a855f7 !important;
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2) !important;
    }
    .form-control::placeholder {
        color: rgba(255,255,255,0.4) !important;
    }
    .form-label {
        color: rgba(255,255,255,0.8);
        font-weight: 500;
        margin-bottom: 8px;
    }
    .form-text {
        color: rgba(255,255,255,0.5) !important;
    }
    .input-group .btn-outline-secondary {
        border: 1px solid rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.6);
        background: rgba(255,255,255,0.03);
    }
    .input-group .btn-outline-secondary:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
        color: #fff;
    }
    .btn-primary {
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(168, 85, 247, 0.3);
    }
    .btn-outline-secondary {
        border: 1px solid rgba(255,255,255,0.2);
        color: rgba(255,255,255,0.7);
        padding: 12px 24px;
        border-radius: 10px;
    }
    .btn-outline-secondary:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
    }
    .alert-success {
        background: rgba(34, 197, 94, 0.15);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #22c55e;
        border-radius: 12px;
    }
    .alert-danger {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #ef4444;
        border-radius: 12px;
    }
    .alert-info {
        background: rgba(59, 130, 246, 0.15);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: #60a5fa;
        border-radius: 12px;
    }
    .alert-info ul {
        color: rgba(255,255,255,0.7);
    }
    .alert-info strong {
        color: #60a5fa;
    }
</style>
@endpush

@section('content')
<section class="profile-section py-5">
    <div class="container">
        @include('partials.user-nav', ['pageTitle' => 'Cambiar Contraseña'])
        
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                @include('profile.partials.sidebar')
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="profile-card">
                    <div class="profile-card-header">
                        <h4 class="mb-0 text-white">
                            <i class="bi bi-key-fill me-2 text-purple"></i>Cambiar Contraseña
                        </h4>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="current_password" class="form-label">
                                    Contraseña Actual <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" name="current_password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    Nueva Contraseña <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required minlength="8">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Mínimo 8 caracteres. Se recomienda usar letras, números y símbolos.</div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">
                                    Confirmar Nueva Contraseña <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="alert alert-info mb-4">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Consejos para una contraseña segura:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Usa al menos 8 caracteres</li>
                                    <li>Combina letras mayúsculas y minúsculas</li>
                                    <li>Incluye números y símbolos especiales</li>
                                    <li>No uses información personal como nombres o fechas</li>
                                </ul>
                            </div>

                            <hr class="my-4 border-secondary opacity-25">

                            <div class="d-flex justify-content-between flex-wrap gap-3">
                                <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Volver
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-2"></i>Cambiar Contraseña
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.nextElementSibling.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
@endpush
@endsection
