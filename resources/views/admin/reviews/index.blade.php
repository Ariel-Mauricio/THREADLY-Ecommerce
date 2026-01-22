@extends('layouts.admin')

@section('title', 'Gestión de Reseñas')

@section('content')
<div class="admin-content">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-white fw-bold">
                <i class="bi bi-star me-2" style="color: #f59e0b;"></i>Reseñas de Clientes
            </h1>
            <p class="text-white-50 mb-0">Gestiona las reseñas de productos</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="card-glass p-4 mb-4">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <select name="rating" class="form-select">
                    <option value="">Todas las calificaciones</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                            {{ $i }} estrellas
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Todos los estados</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprobadas</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendientes</option>
                </select>
            </div>
            <div class="col-md-4 text-md-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-funnel me-1"></i>Filtrar
                </button>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-light">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Reviews List -->
    <div class="row g-4">
        @forelse($reviews ?? [] as $review)
            <div class="col-md-6">
                <div class="card-glass p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-3">
                                {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <strong class="text-white d-block">{{ $review->user->name ?? 'Usuario' }}</strong>
                                <small class="text-white-50">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            @if($review->is_approved)
                                <span class="badge bg-success">Aprobada</span>
                            @else
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Product info -->
                    <div class="d-flex align-items-center mb-3 p-2 rounded" style="background: rgba(255,255,255,0.05);">
                        <img src="{{ $review->product->image ?? 'https://via.placeholder.com/40' }}" 
                             alt="" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                        <span class="text-white small">{{ Str::limit($review->product->name ?? 'Producto', 30) }}</span>
                    </div>
                    
                    <!-- Rating -->
                    <div class="mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}" 
                               style="color: {{ $i <= $review->rating ? '#f59e0b' : 'rgba(255,255,255,0.2)' }};"></i>
                        @endfor
                        <span class="ms-2 text-white-50 small">({{ $review->rating }}/5)</span>
                    </div>
                    
                    <!-- Comment -->
                    <p class="text-white-50 small mb-3">{{ $review->comment ?? 'Sin comentario' }}</p>
                    
                    <!-- Actions -->
                    <div class="d-flex gap-2 mt-auto">
                        @if(!$review->is_approved)
                            <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="bi bi-check-lg me-1"></i>Aprobar
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning">
                                    <i class="bi bi-x-lg me-1"></i>Rechazar
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta reseña?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card-glass p-5 text-center">
                    <div class="empty-state">
                        <i class="bi bi-star" style="color: #f59e0b;"></i>
                        <p class="mb-0">No hay reseñas para mostrar</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    @if(isset($reviews) && $reviews->hasPages())
        <div class="mt-4">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
@endsection
