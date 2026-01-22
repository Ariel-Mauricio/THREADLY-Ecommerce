@extends('layouts.app')

@section('title', 'Mi Perfil - THREADLY')

@section('content')
<section class="py-5" style="min-height: 100vh; background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #0f0f1a 100%); padding-top: 120px !important;">
<div class="container">
    @include('partials.user-nav', ['pageTitle' => 'Mi Perfil'])
    
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="profile-sidebar">
                <div class="text-center p-4">
                    <div class="avatar-circle mx-auto mb-3" style="width: 100px; height: 100px; background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 32px rgba(168, 85, 247, 0.3);">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <span class="text-white" style="font-size: 2.5rem; font-weight: 700;">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <h5 class="text-white mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-white-50 mb-2">{{ auth()->user()->email }}</p>
                    <small class="text-white-50">Miembro desde {{ auth()->user()->created_at->format('M Y') }}</small>
                </div>
                <div class="profile-nav">
                    <a href="{{ route('profile.index') }}" class="profile-nav-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                        <i class="bi bi-person me-2"></i> Mi Perfil
                    </a>
                    <a href="{{ route('profile.edit') }}" class="profile-nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="bi bi-pencil me-2"></i> Editar Perfil
                    </a>
                    <a href="{{ route('profile.addresses') }}" class="profile-nav-item {{ request()->routeIs('profile.addresses') ? 'active' : '' }}">
                        <i class="bi bi-geo-alt me-2"></i> Mis Direcciones
                    </a>
                    <a href="{{ route('orders.index') }}" class="profile-nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="bi bi-bag me-2"></i> Mis Pedidos
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="profile-nav-item {{ request()->routeIs('wishlist.*') ? 'active' : '' }}">
                        <i class="bi bi-heart me-2"></i> Lista de Deseos
                    </a>
                    <a href="{{ route('profile.password') }}" class="profile-nav-item {{ request()->routeIs('profile.password') ? 'active' : '' }}">
                        <i class="bi bi-key me-2"></i> Cambiar Contraseña
                    </a>
                    
                    <div style="border-top: 1px solid rgba(255,255,255,0.1); margin: 12px 0;"></div>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="profile-nav-item logout-btn" style="width: 100%; border: none; background: transparent; cursor: pointer; text-align: left;">
                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 mb-4">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 rounded-3 mb-4">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <div class="profile-card">
                <div class="profile-card-header">
                    <h4 class="text-white mb-0"><i class="bi bi-person me-2" style="color: #a855f7;"></i>Mi Perfil</h4>
                </div>
                <div class="profile-card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="text-white-50 small mb-1">Nombre Completo</label>
                            <p class="text-white fw-semibold mb-0">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="text-white-50 small mb-1">Correo Electrónico</label>
                            <p class="text-white fw-semibold mb-0">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="text-white-50 small mb-1">Teléfono</label>
                            <p class="text-white fw-semibold mb-0">{{ auth()->user()->phone ?? 'No especificado' }}</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="text-white-50 small mb-1">Género</label>
                            <p class="text-white fw-semibold mb-0">
                                @switch(auth()->user()->gender)
                                    @case('male') Masculino @break
                                    @case('female') Femenino @break
                                    @case('other') Otro @break
                                    @default No especificado
                                @endswitch
                            </p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="text-white-50 small mb-1">Fecha de Nacimiento</label>
                            <p class="text-white fw-semibold mb-0">{{ auth()->user()->birth_date?->format('d/m/Y') ?? 'No especificada' }}</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="text-white-50 small mb-1">Último Acceso</label>
                            <p class="text-white fw-semibold mb-0">{{ auth()->user()->last_login_at?->diffForHumans() ?? 'Primera sesión' }}</p>
                        </div>
                    </div>

                    <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

                    <h5 class="text-white mb-4"><i class="bi bi-graph-up me-2" style="color: #a855f7;"></i>Estadísticas</h5>
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="stats-box stats-blue">
                                <h3 class="mb-1">{{ auth()->user()->orders->count() }}</h3>
                                <small>Pedidos</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stats-box stats-green">
                                <h3 class="mb-1">${{ number_format(auth()->user()->orders->whereNotIn('status', ['cancelled', 'payment_failed'])->sum('total'), 2) }}</h3>
                                <small>Total Gastado</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stats-box stats-red">
                                <h3 class="mb-1">{{ auth()->user()->wishlist->count() }}</h3>
                                <small>En Wishlist</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stats-box stats-purple">
                                <h3 class="mb-1">{{ auth()->user()->reviews->count() }}</h3>
                                <small>Reseñas</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary-gradient">
                            <i class="bi bi-pencil me-2"></i>Editar Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

@push('styles')
<style>
    .profile-sidebar {
        background: rgba(255,255,255,0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        overflow: hidden;
    }
    
    .profile-nav {
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    
    .profile-nav-item {
        display: block;
        padding: 14px 20px;
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    
    .profile-nav-item:hover {
        background: rgba(168, 85, 247, 0.1);
        color: white;
        padding-left: 25px;
    }
    
    .profile-nav-item.active {
        background: rgba(168, 85, 247, 0.2);
        color: white;
        border-left: 3px solid #a855f7;
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
        padding: 20px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .profile-card-body {
        padding: 24px;
    }
    
    .stats-box {
        padding: 20px;
        border-radius: 12px;
        text-align: center;
    }
    
    .stats-box h3 {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .stats-box small {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stats-blue {
        background: rgba(59, 130, 246, 0.15);
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    .stats-blue h3 { color: #3b82f6; }
    .stats-blue small { color: rgba(59, 130, 246, 0.8); }
    
    .stats-green {
        background: rgba(34, 197, 94, 0.15);
        border: 1px solid rgba(34, 197, 94, 0.3);
    }
    .stats-green h3 { color: #22c55e; }
    .stats-green small { color: rgba(34, 197, 94, 0.8); }
    
    .stats-red {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    .stats-red h3 { color: #ef4444; }
    .stats-red small { color: rgba(239, 68, 68, 0.8); }
    
    .stats-purple {
        background: rgba(168, 85, 247, 0.15);
        border: 1px solid rgba(168, 85, 247, 0.3);
    }
    .stats-purple h3 { color: #a855f7; }
    .stats-purple small { color: rgba(168, 85, 247, 0.8); }
    
    .btn-primary-gradient {
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(168, 85, 247, 0.4);
        color: white;
    }
</style>
@endpush
