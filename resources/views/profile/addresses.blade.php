@extends('layouts.app')

@section('title', 'Mis Direcciones - THREADLY')

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
    .address-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 20px;
        height: 100%;
        transition: all 0.3s ease;
    }
    .address-card:hover {
        background: rgba(255,255,255,0.05);
        border-color: rgba(168, 85, 247, 0.3);
    }
    .address-card.default {
        border-color: #a855f7;
        background: rgba(168, 85, 247, 0.08);
    }
    .btn-primary {
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(168, 85, 247, 0.3);
    }
    .btn-outline-primary {
        border: 1px solid #a855f7;
        color: #a855f7;
        border-radius: 8px;
    }
    .btn-outline-primary:hover {
        background: rgba(168, 85, 247, 0.15);
        border-color: #a855f7;
        color: #fff;
    }
    .btn-outline-secondary {
        border: 1px solid rgba(255,255,255,0.2);
        color: rgba(255,255,255,0.7);
        border-radius: 8px;
    }
    .btn-outline-secondary:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
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
    /* Modal dark theme */
    .modal-content {
        background: #1a1a2e;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
    }
    .modal-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 20px 24px;
    }
    .modal-title {
        color: #fff;
    }
    .modal-body {
        padding: 24px;
    }
    .modal-footer {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding: 16px 24px;
    }
    .btn-close {
        filter: invert(1);
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
    .form-check-input {
        background-color: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
    }
    .form-check-input:checked {
        background-color: #a855f7;
        border-color: #a855f7;
    }
    .form-check-label {
        color: rgba(255,255,255,0.8);
    }
    .btn-secondary {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        border-radius: 10px;
    }
    .btn-secondary:hover {
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.3);
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
        @include('partials.user-nav', ['pageTitle' => 'Mis Direcciones'])
        
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
                    <div class="profile-card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <h4 class="mb-0 text-white">
                            <i class="bi bi-geo-alt-fill me-2 text-purple"></i>Mis Direcciones
                        </h4>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                            <i class="bi bi-plus-lg me-1"></i> Nueva Dirección
                        </button>
                    </div>
                    <div class="p-4">
                        @if($addresses->count() > 0)
                            <div class="row g-4">
                                @foreach($addresses as $address)
                                    <div class="col-md-6">
                                        <div class="address-card {{ $address->is_default ? 'default' : '' }}">
                                            @if($address->is_default)
                                                <span class="badge bg-purple mb-3" style="background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);">
                                                    <i class="bi bi-star-fill me-1"></i>Predeterminada
                                                </span>
                                            @endif
                                            <h6 class="text-white fw-bold mb-2">{{ $address->name }}</h6>
                                            <p class="text-white-50 mb-1">{{ $address->address }}</p>
                                            <p class="text-white-50 mb-1">{{ $address->city }}, {{ $address->province }}</p>
                                            <p class="text-white-50 mb-2">{{ $address->postal_code }}</p>
                                            @if($address->phone)
                                                <p class="text-white-50 mb-2">
                                                    <i class="bi bi-telephone me-1"></i>{{ $address->phone }}
                                                </p>
                                            @endif
                                            @if($address->address_reference)
                                                <p class="small text-white-50 mb-0">
                                                    <i class="bi bi-info-circle me-1"></i>{{ $address->address_reference }}
                                                </p>
                                            @endif
                                            <div class="mt-3 pt-3 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
                                                @if(!$address->is_default)
                                                    <form action="{{ route('profile.addresses.default', $address) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-primary btn-sm">
                                                            <i class="bi bi-star"></i> Predeterminar
                                                        </button>
                                                    </form>
                                                @endif
                                                <button class="btn btn-outline-secondary btn-sm edit-address-btn" 
                                                        data-address="{{ json_encode($address) }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form action="{{ route('profile.addresses.destroy', $address) }}" method="POST" class="d-inline delete-address-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="bi bi-geo-alt"></i>
                                <h5 class="text-white mt-3">No tienes direcciones guardadas</h5>
                                <p class="text-white-50">Agrega una dirección para hacer tu próximo pedido más rápido.</p>
                                <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                    <i class="bi bi-plus-lg me-1"></i> Agregar Dirección
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-geo-alt-fill me-2 text-purple"></i>Nueva Dirección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Etiqueta <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   placeholder="Ej: Casa, Oficina" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="recipient_name" class="form-label">Nombre del Destinatario <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="recipient_name" name="recipient_name" 
                                   value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Dirección <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="address" name="address" rows="2" 
                                      placeholder="Calle principal, número, edificio/casa" required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">Ciudad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="province" class="form-label">Provincia <span class="text-danger">*</span></label>
                            <select class="form-select" id="province" name="province" required>
                                <option value="">Seleccionar...</option>
                                <option value="Azuay">Azuay</option>
                                <option value="Bolívar">Bolívar</option>
                                <option value="Cañar">Cañar</option>
                                <option value="Carchi">Carchi</option>
                                <option value="Chimborazo">Chimborazo</option>
                                <option value="Cotopaxi">Cotopaxi</option>
                                <option value="El Oro">El Oro</option>
                                <option value="Esmeraldas">Esmeraldas</option>
                                <option value="Galápagos">Galápagos</option>
                                <option value="Guayas">Guayas</option>
                                <option value="Imbabura">Imbabura</option>
                                <option value="Loja">Loja</option>
                                <option value="Los Ríos">Los Ríos</option>
                                <option value="Manabí">Manabí</option>
                                <option value="Morona Santiago">Morona Santiago</option>
                                <option value="Napo">Napo</option>
                                <option value="Orellana">Orellana</option>
                                <option value="Pastaza">Pastaza</option>
                                <option value="Pichincha">Pichincha</option>
                                <option value="Santa Elena">Santa Elena</option>
                                <option value="Santo Domingo de los Tsáchilas">Santo Domingo de los Tsáchilas</option>
                                <option value="Sucumbíos">Sucumbíos</option>
                                <option value="Tungurahua">Tungurahua</option>
                                <option value="Zamora Chinchipe">Zamora Chinchipe</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="postal_code" class="form-label">Código Postal</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Teléfono de Contacto <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   value="{{ auth()->user()->phone }}" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address_reference" class="form-label">Referencia</label>
                            <input type="text" class="form-control" id="address_reference" name="address_reference" 
                                   placeholder="Ej: Junto al parque, edificio azul">
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1">
                                <label class="form-check-label" for="is_default">
                                    Establecer como dirección predeterminada
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Guardar Dirección
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Address Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-fill me-2 text-purple"></i>Editar Dirección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editAddressForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_name" class="form-label">Etiqueta <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_recipient_name" class="form-label">Nombre del Destinatario <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_recipient_name" name="recipient_name" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="edit_address" class="form-label">Dirección <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_address" name="address" rows="2" required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_city" class="form-label">Ciudad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_city" name="city" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_province" class="form-label">Provincia <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_province" name="province" required>
                                <option value="">Seleccionar...</option>
                                <option value="Azuay">Azuay</option>
                                <option value="Bolívar">Bolívar</option>
                                <option value="Cañar">Cañar</option>
                                <option value="Carchi">Carchi</option>
                                <option value="Chimborazo">Chimborazo</option>
                                <option value="Cotopaxi">Cotopaxi</option>
                                <option value="El Oro">El Oro</option>
                                <option value="Esmeraldas">Esmeraldas</option>
                                <option value="Galápagos">Galápagos</option>
                                <option value="Guayas">Guayas</option>
                                <option value="Imbabura">Imbabura</option>
                                <option value="Loja">Loja</option>
                                <option value="Los Ríos">Los Ríos</option>
                                <option value="Manabí">Manabí</option>
                                <option value="Morona Santiago">Morona Santiago</option>
                                <option value="Napo">Napo</option>
                                <option value="Orellana">Orellana</option>
                                <option value="Pastaza">Pastaza</option>
                                <option value="Pichincha">Pichincha</option>
                                <option value="Santa Elena">Santa Elena</option>
                                <option value="Santo Domingo de los Tsáchilas">Santo Domingo de los Tsáchilas</option>
                                <option value="Sucumbíos">Sucumbíos</option>
                                <option value="Tungurahua">Tungurahua</option>
                                <option value="Zamora Chinchipe">Zamora Chinchipe</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_postal_code" class="form-label">Código Postal</label>
                            <input type="text" class="form-control" id="edit_postal_code" name="postal_code">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_phone" class="form-label">Teléfono de Contacto <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="edit_phone" name="phone" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="edit_address_reference" class="form-label">Referencia</label>
                            <input type="text" class="form-control" id="edit_address_reference" name="address_reference">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Actualizar Dirección
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function editAddress(address) {
    document.getElementById('editAddressForm').action = '/perfil/direcciones/' + address.id;
    document.getElementById('edit_name').value = address.name;
    document.getElementById('edit_recipient_name').value = address.recipient_name || '';
    document.getElementById('edit_address').value = address.address;
    document.getElementById('edit_city').value = address.city;
    document.getElementById('edit_province').value = address.province;
    document.getElementById('edit_postal_code').value = address.postal_code || '';
    document.getElementById('edit_phone').value = address.phone || '';
    document.getElementById('edit_address_reference').value = address.address_reference || '';
    
    new bootstrap.Modal(document.getElementById('editAddressModal')).show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle edit address buttons
    document.querySelectorAll('.edit-address-btn[data-address]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            editAddress(JSON.parse(this.dataset.address));
        });
    });
    
    // Handle delete address forms
    document.querySelectorAll('.delete-address-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('¿Estás seguro de eliminar esta dirección?')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endpush
@endsection
