@extends('layouts.admin')

@section('title', 'Registro de Actividad')

@section('content')
<div class="admin-content">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-white fw-bold">
                <i class="bi bi-activity me-2" style="color: var(--accent);"></i>Registro de Actividad
            </h1>
            <p class="text-white-50 mb-0">Historial de acciones en el sistema</p>
        </div>
        <form action="{{ route('admin.activity.clear') }}" method="POST" class="d-inline"
              onsubmit="return confirm('¿Eliminar registros de más de 30 días?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-trash me-2"></i>Limpiar antiguos
            </button>
        </form>
    </div>

    <!-- Filters -->
    <div class="card-glass p-4 mb-4">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <select name="action" class="form-select">
                    <option value="">Todas las acciones</option>
                    @foreach($actions ?? [] as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ ucfirst($action) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-5 text-md-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-funnel me-1"></i>Filtrar
                </button>
                <a href="{{ route('admin.activity.index') }}" class="btn btn-outline-light">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Activity Timeline -->
    <div class="card-glass p-4">
        <div class="activity-timeline">
            @forelse($activities ?? [] as $activity)
                <div class="activity-item">
                    <div class="activity-icon {{ $activity->action }}">
                        @switch($activity->action)
                            @case('login')
                                <i class="bi bi-box-arrow-in-right"></i>
                                @break
                            @case('logout')
                                <i class="bi bi-box-arrow-right"></i>
                                @break
                            @case('register')
                                <i class="bi bi-person-plus"></i>
                                @break
                            @case('order_created')
                                <i class="bi bi-bag-plus"></i>
                                @break
                            @case('order_updated')
                                <i class="bi bi-bag-check"></i>
                                @break
                            @case('product_created')
                                <i class="bi bi-box-seam"></i>
                                @break
                            @case('product_updated')
                                <i class="bi bi-pencil-square"></i>
                                @break
                            @case('product_deleted')
                                <i class="bi bi-trash"></i>
                                @break
                            @case('review_created')
                                <i class="bi bi-star"></i>
                                @break
                            @case('cart_updated')
                                <i class="bi bi-cart"></i>
                                @break
                            @default
                                <i class="bi bi-activity"></i>
                        @endswitch
                    </div>
                    <div class="activity-content">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-{{ $activity->action == 'login' ? 'success' : ($activity->action == 'logout' ? 'secondary' : 'primary') }} mb-1">
                                    {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                                </span>
                                <p class="text-white mb-1">{{ $activity->description }}</p>
                                <small class="text-white-50">
                                    <i class="bi bi-person me-1"></i>{{ $activity->user->name ?? 'Sistema' }}
                                    @if($activity->ip_address)
                                        • <i class="bi bi-geo-alt me-1"></i>{{ $activity->ip_address }}
                                    @endif
                                </small>
                            </div>
                            <small class="text-white-50">{{ $activity->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-activity"></i>
                        <p class="mb-0">No hay actividad registrada</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if(isset($activities) && $activities->hasPages())
            <div class="mt-4">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .activity-timeline {
        position: relative;
    }
    
    .activity-item {
        display: flex;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: rgba(168, 85, 247, 0.2);
        color: var(--accent);
    }
    
    .activity-icon.login {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
    }
    
    .activity-icon.logout {
        background: rgba(107, 114, 128, 0.2);
        color: #6b7280;
    }
    
    .activity-icon.order_created,
    .activity-icon.order_updated {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
    }
    
    .activity-icon.product_deleted {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }
    
    .activity-icon.review_created {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
    }
    
    .activity-content {
        flex: 1;
    }
</style>
@endpush
