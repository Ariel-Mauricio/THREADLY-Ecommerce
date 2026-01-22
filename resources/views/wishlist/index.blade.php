@extends('layouts.app')

@section('title', 'Mi Lista de Deseos - THREADLY')

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
    .product-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }
    .product-card:hover {
        transform: translateY(-5px);
        border-color: rgba(168, 85, 247, 0.3);
        box-shadow: 0 15px 40px rgba(168, 85, 247, 0.15);
    }
    .product-card .card-img-top {
        border-radius: 0;
    }
    .product-card .card-body {
        padding: 16px;
    }
    .product-card .card-title a {
        color: #fff !important;
        text-decoration: none;
    }
    .product-card .card-title a:hover {
        color: #a855f7 !important;
    }
    .product-card .card-footer {
        background: rgba(255,255,255,0.02);
        border-top: 1px solid rgba(255,255,255,0.05);
        padding: 12px 16px;
        color: rgba(255,255,255,0.5);
    }
    .btn-primary {
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        border: none;
        border-radius: 8px;
        font-weight: 600;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(168, 85, 247, 0.3);
    }
    .btn-outline-danger {
        border: 1px solid rgba(239, 68, 68, 0.5);
        color: #ef4444;
        border-radius: 8px;
    }
    .btn-outline-danger:hover {
        background: rgba(239, 68, 68, 0.15);
        border-color: #ef4444;
        color: #fff;
    }
    .btn-remove {
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(10px);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .btn-remove:hover {
        background: #ef4444;
        transform: scale(1.1);
    }
    .alert-success {
        background: rgba(34, 197, 94, 0.15);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #22c55e;
        border-radius: 12px;
    }
    .badge-discount {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 600;
    }
    .price-old {
        color: rgba(255,255,255,0.4);
        text-decoration: line-through;
    }
    .price-new {
        color: #ef4444;
        font-weight: 700;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state i {
        font-size: 4rem;
        color: rgba(255,255,255,0.2);
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<section class="profile-section py-5">
    <div class="container">
        @include('partials.user-nav', ['pageTitle' => 'Lista de Deseos'])
        
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
                    <div class="profile-card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <h4 class="mb-0 text-white">
                            <i class="bi bi-heart-fill me-2 text-danger"></i>Mi Lista de Deseos
                            @if($wishlistItems->count() > 0)
                                <span class="badge bg-secondary ms-2">{{ $wishlistItems->count() }}</span>
                            @endif
                        </h4>
                        @if($wishlistItems->count() > 0)
                            <form action="{{ route('wishlist.clear') }}" method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de vaciar tu lista de deseos?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash me-1"></i> Vaciar Lista
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="p-4">
                        @if($wishlistItems->count() > 0)
                            <div class="row g-4">
                                @foreach($wishlistItems as $item)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="product-card">
                                            <div class="position-relative">
                                                <a href="{{ route('products.show', $item->product->slug) }}">
                                                    @if($item->product->image)
                                                        <img src="{{ Storage::url($item->product->image) }}" 
                                                             class="card-img-top" alt="{{ $item->product->name }}"
                                                             style="height: 200px; object-fit: cover;">
                                                    @else
                                                        <div style="height: 200px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center;">
                                                            <i class="bi bi-image text-white-50" style="font-size: 3rem;"></i>
                                                        </div>
                                                    @endif
                                                </a>
                                                
                                                @if($item->product->discount_percent)
                                                    <span class="badge badge-discount position-absolute" style="top: 10px; left: 10px;">
                                                        -{{ $item->product->discount_percent }}%
                                                    </span>
                                                @endif
                                                
                                                <form action="{{ route('wishlist.remove', $item->product) }}" method="POST" 
                                                      class="position-absolute" style="top: 10px; right: 10px;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-remove" title="Eliminar de favoritos">
                                                        <i class="bi bi-heart-fill text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <div class="card-body">
                                                <h6 class="card-title mb-2">
                                                    <a href="{{ route('products.show', $item->product->slug) }}">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h6>
                                                <p class="text-white-50 small mb-3">{{ $item->product->category?->name }}</p>
                                                
                                                <div class="d-flex align-items-center gap-2 mb-3">
                                                    @if($item->product->discount_percent)
                                                        <span class="price-old">${{ number_format($item->product->price, 2) }}</span>
                                                        <span class="price-new">${{ number_format($item->product->final_price, 2) }}</span>
                                                    @else
                                                        <span class="text-white fw-bold">${{ number_format($item->product->price, 2) }}</span>
                                                    @endif
                                                </div>
                                                
                                                @if($item->product->stock > 0)
                                                    <form action="{{ route('wishlist.move-to-cart', $item->product) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                                            <i class="bi bi-cart-plus me-1"></i> Agregar al Carrito
                                                        </button>
                                                    </form>
                                                    <small class="text-success d-block mt-2">
                                                        <i class="bi bi-check-circle me-1"></i>En stock
                                                    </small>
                                                @else
                                                    <span class="badge bg-secondary w-100 py-2">Agotado</span>
                                                @endif
                                            </div>
                                            <div class="card-footer small">
                                                <i class="bi bi-clock me-1"></i>
                                                Agregado {{ $item->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="bi bi-heart"></i>
                                <h5 class="text-white mt-3">Tu lista de deseos está vacía</h5>
                                <p class="text-white-50">Explora nuestra colección y guarda tus productos favoritos.</p>
                                <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">
                                    <i class="bi bi-bag me-1"></i> Ver Productos
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
