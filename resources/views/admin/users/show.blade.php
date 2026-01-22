@extends('layouts.admin')

@section('title', 'Detalle de Usuario')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i> Volver a usuarios
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- User Info -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="avatar-circle mx-auto mb-3" style="width: 100px; height: 100px; background: var(--gradient-1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <span class="text-white" style="font-size: 2.5rem; font-weight: 700;">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    
                    @if($user->is_admin)
                        <span class="badge bg-primary mb-2">Administrador</span>
                    @else
                        <span class="badge bg-secondary mb-2">Cliente</span>
                    @endif

                    @if($user->suspended_at)
                        <span class="badge bg-danger mb-2">Suspendido</span>
                    @endif

                    <hr>

                    <div class="text-start">
                        <p class="mb-2">
                            <i class="bi bi-phone me-2 text-muted"></i>
                            {{ $user->phone ?? 'No especificado' }}
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-calendar me-2 text-muted"></i>
                            Miembro desde {{ $user->created_at->format('d/m/Y') }}
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-clock me-2 text-muted"></i>
                            Último acceso: {{ $user->last_login_at?->diffForHumans() ?? 'Nunca' }}
                        </p>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i> Editar
                        </a>
                        @if($user->suspended_at)
                            <form action="{{ route('admin.users.restore', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-check-circle me-1"></i> Restaurar
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.suspend', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-pause-circle me-1"></i> Suspender
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Estadísticas</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <h3 class="mb-0 text-primary">{{ $user->orders_count ?? $user->orders->count() }}</h3>
                            <small class="text-muted">Órdenes</small>
                        </div>
                        <div class="col-6 mb-3">
                            <h3 class="mb-0 text-success">${{ number_format($totalSpent, 2) }}</h3>
                            <small class="text-muted">Total Gastado</small>
                        </div>
                        <div class="col-6">
                            <h3 class="mb-0 text-info">{{ $user->addresses->count() }}</h3>
                            <small class="text-muted">Direcciones</small>
                        </div>
                        <div class="col-6">
                            <h3 class="mb-0 text-warning">{{ $user->reviews->count() }}</h3>
                            <small class="text-muted">Reseñas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders & Activity -->
        <div class="col-lg-8">
            <!-- Recent Orders -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="bi bi-bag me-2"></i>Órdenes Recientes</h6>
                </div>
                <div class="card-body p-0">
                    @if($user->orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-4">ID</th>
                                        <th class="py-3">Fecha</th>
                                        <th class="py-3">Total</th>
                                        <th class="py-3">Estado</th>
                                        <th class="py-3 text-end px-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->orders as $order)
                                        <tr>
                                            <td class="py-3 px-4">#{{ $order->id }}</td>
                                            <td class="py-3">{{ $order->created_at->format('d/m/Y') }}</td>
                                            <td class="py-3">${{ number_format($order->total, 2) }}</td>
                                            <td class="py-3">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'processing' => 'info',
                                                        'paid' => 'success',
                                                        'shipped' => 'primary',
                                                        'delivered' => 'success',
                                                        'cancelled' => 'danger',
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-end px-4">
                                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-bag display-4 text-muted"></i>
                            <p class="text-muted mt-2">Este usuario no tiene órdenes</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Logs -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Actividad Reciente</h6>
                </div>
                <div class="card-body">
                    @if($activityLogs->count() > 0)
                        <div class="timeline">
                            @foreach($activityLogs as $log)
                                <div class="timeline-item d-flex mb-3">
                                    <div class="timeline-icon me-3">
                                        <i class="bi {{ $log->action_icon }} text-{{ $log->action_color }}"></i>
                                    </div>
                                    <div class="timeline-content flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $log->action_label }}</strong>
                                            <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if($log->ip_address)
                                            <small class="text-muted">IP: {{ $log->ip_address }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-clock-history display-4 text-muted"></i>
                            <p class="text-muted mt-2">No hay actividad registrada</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-item {
    position: relative;
    padding-left: 10px;
}
.timeline-item::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 25px;
    bottom: -15px;
    width: 2px;
    background: #e9ecef;
}
.timeline-item:last-child::before {
    display: none;
}
.timeline-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
    background: white;
}
</style>
@endsection
