@extends('layouts.app')

@section('title', 'Editar Perfil - THREADLY')

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
    .form-control, .form-select {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        color: #fff !important;
        border-radius: 10px;
        padding: 12px 16px;
    }
    .form-control:focus, .form-select:focus {
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
    .form-select option {
        background: #1a1a2e;
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
    .avatar-preview {
        border: 3px solid rgba(168, 85, 247, 0.3);
        border-radius: 50%;
    }
    .alert-success {
        background: rgba(34, 197, 94, 0.15);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #22c55e;
        border-radius: 12px;
    }
</style>
@endpush

@section('content')
<section class="profile-section py-5">
    <div class="container">
        @include('partials.user-nav', ['pageTitle' => 'Editar Perfil'])
        
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

                <div class="profile-card">
                    <div class="profile-card-header">
                        <h4 class="mb-0 text-white">
                            <i class="bi bi-pencil-fill me-2 text-purple"></i>Editar Perfil
                        </h4>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="form-label">
                                        Nombre Completo <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="email" class="form-label">
                                        Correo Electrónico <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" 
                                           placeholder="09XXXXXXXX">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="gender" class="form-label">Género</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">Seleccionar...</option>
                                        <option value="male" {{ old('gender', auth()->user()->gender) == 'male' ? 'selected' : '' }}>Masculino</option>
                                        <option value="female" {{ old('gender', auth()->user()->gender) == 'female' ? 'selected' : '' }}>Femenino</option>
                                        <option value="other" {{ old('gender', auth()->user()->gender) == 'other' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="birth_date" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                           id="birth_date" name="birth_date" 
                                           value="{{ old('birth_date', auth()->user()->birth_date?->format('Y-m-d')) }}">
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="avatar" class="form-label">Foto de Perfil</label>
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" 
                                           id="avatar" name="avatar" accept="image/*">
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if(auth()->user()->avatar)
                                        <div class="mt-3 d-flex align-items-center gap-3">
                                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar actual" 
                                                 class="avatar-preview" style="width: 60px; height: 60px; object-fit: cover;">
                                            <small class="text-white-50">Imagen actual</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <hr class="my-4 border-secondary opacity-25">

                            <div class="d-flex justify-content-between flex-wrap gap-3">
                                <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Volver
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-2"></i>Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
