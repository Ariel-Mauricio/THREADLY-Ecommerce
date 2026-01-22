@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestión de Usuarios</h2>
            <p class="text-muted mb-0">Administra los usuarios de tu tienda</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.exports.users') }}" class="btn btn-outline-success">
                <i class="bi bi-download me-1"></i> Exportar CSV
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Nuevo Usuario
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Buscar</label>
                    <input type="text" class="form-control" name="search" 
                           value="{{ request('search') }}" placeholder="Nombre o email...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Rol</label>
                    <select class="form-select" name="role">
                        <option value="">Todos</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administradores</option>
                        <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Clientes</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select class="form-select" name="status">
                        <option value="">Todos</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activos</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspendidos</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4">Usuario</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Rol</th>
                            <th class="py-3">Órdenes</th>
                            <th class="py-3">Estado</th>
                            <th class="py-3">Registro</th>
                            <th class="py-3 text-end px-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3" style="width: 40px; height: 40px; background: var(--gradient-1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <span class="text-white fw-bold">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            @if($user->phone)
                                                <small class="text-muted">{{ $user->phone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">{{ $user->email }}</td>
                                <td class="py-3">
                                    @if($user->is_admin)
                                        <span class="badge bg-primary">Administrador</span>
                                    @else
                                        <span class="badge bg-secondary">Cliente</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-info">{{ $user->orders_count }}</span>
                                </td>
                                <td class="py-3">
                                    @if($user->suspended_at)
                                        <span class="badge bg-danger">Suspendido</span>
                                    @else
                                        <span class="badge bg-success">Activo</span>
                                    @endif
                                </td>
                                <td class="py-3">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 text-end px-4">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-dark dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if($user->suspended_at)
                                                <li>
                                                    <form action="{{ route('admin.users.restore', $user) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-success">
                                                            <i class="bi bi-check-circle me-2"></i>Restaurar
                                                        </button>
                                                    </form>
                                                </li>
                                            @else
                                                <li>
                                                    <form action="{{ route('admin.users.suspend', $user) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-warning">
                                                            <i class="bi bi-pause-circle me-2"></i>Suspender
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li>
                                                <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        @if($user->is_admin)
                                                            <i class="bi bi-person me-2"></i>Quitar Admin
                                                        @else
                                                            <i class="bi bi-shield me-2"></i>Hacer Admin
                                                        @endif
                                                    </button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                      onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i>Eliminar
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-people display-4 text-muted"></i>
                                    <p class="text-muted mt-2">No se encontraron usuarios</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
            <div class="card-footer bg-white border-0">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
