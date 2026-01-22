@extends('layouts.admin')

@section('title', 'Gestión de Categorías')

@section('content')
<div class="admin-content">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-white fw-bold">
                <i class="bi bi-tags me-2" style="color: var(--accent);"></i>Categorías
            </h1>
            <p class="text-white-50 mb-0">Organiza tus productos por categorías</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
            <i class="bi bi-plus-lg me-2"></i>Nueva Categoría
        </button>
    </div>

    <!-- Categories Grid -->
    <div class="row g-4">
        @forelse($categories ?? [] as $category)
            <div class="col-md-6 col-lg-4">
                <div class="card-glass p-4 h-100 category-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="category-icon">
                            <i class="bi bi-folder-fill"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item" onclick="editCategory({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ addslashes($category->description ?? '') }}')">
                                        <i class="bi bi-pencil me-2"></i>Editar
                                    </button>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item text-danger" onclick="confirmDelete({{ $category->id }}, '{{ addslashes($category->name) }}')">
                                        <i class="bi bi-trash me-2"></i>Eliminar
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <h5 class="text-white mb-2">{{ $category->name }}</h5>
                    <p class="text-white-50 small mb-3">{{ Str::limit($category->description ?? 'Sin descripción', 80) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="badge bg-secondary">
                            <i class="bi bi-box me-1"></i>{{ $category->products_count ?? $category->products->count() }} productos
                        </span>
                        <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="btn btn-sm btn-outline-light">
                            Ver productos
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card-glass p-5 text-center">
                    <div class="empty-state">
                        <i class="bi bi-tags" style="font-size: 3rem;"></i>
                        <p class="mb-3">No hay categorías creadas</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
                            <i class="bi bi-plus-lg me-2"></i>Crear primera categoría
                        </button>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Create/Edit Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-dark); border: 1px solid var(--border-color);">
            <form id="categoryForm" method="POST">
                @csrf
                <div id="methodField"></div>
                
                <div class="modal-header" style="border-color: var(--border-color);">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-tags me-2" style="color: var(--accent);"></i>
                        <span id="modalTitle">Nueva Categoría</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Categoría <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="categoryName" class="form-control" required placeholder="Ej: Camisetas">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Descripción</label>
                        <textarea name="description" id="categoryDescription" class="form-control" rows="3" placeholder="Describe esta categoría..."></textarea>
                    </div>
                </div>
                
                <div class="modal-footer" style="border-color: var(--border-color);">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i><span id="submitBtnText">Crear</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-dark); border: 1px solid var(--border-color);">
            <div class="modal-header" style="border-color: var(--border-color);">
                <h5 class="modal-title text-white">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Eliminar Categoría
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-white">¿Estás seguro de que deseas eliminar la categoría <strong class="text-danger" id="deleteCategoryName"></strong>?</p>
                <p class="text-white-50 small mb-0">Los productos de esta categoría quedarán sin categoría asignada.</p>
            </div>
            <div class="modal-footer" style="border-color: var(--border-color);">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .category-card {
        transition: all 0.3s ease;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
    }
    
    .category-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.2) 0%, rgba(99, 102, 241, 0.1) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--accent);
    }
    
    .dropdown-menu-dark {
        background: var(--bg-dark);
        border: 1px solid var(--border-color);
    }
</style>
@endpush

@push('scripts')
<script>
    const categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'));
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    
    // Reset modal for creating
    document.getElementById('categoryModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('categoryForm').action = '{{ route("admin.categories.store") }}';
        document.getElementById('categoryForm').reset();
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('modalTitle').textContent = 'Nueva Categoría';
        document.getElementById('submitBtnText').textContent = 'Crear';
    });
    
    function editCategory(id, name, description) {
        document.getElementById('categoryForm').action = `/admin/categories/${id}`;
        document.getElementById('methodField').innerHTML = '@method("PUT")';
        document.getElementById('categoryName').value = name;
        document.getElementById('categoryDescription').value = description;
        document.getElementById('modalTitle').textContent = 'Editar Categoría';
        document.getElementById('submitBtnText').textContent = 'Guardar';
        categoryModal.show();
    }
    
    function confirmDelete(id, name) {
        document.getElementById('deleteForm').action = `/admin/categories/${id}`;
        document.getElementById('deleteCategoryName').textContent = name;
        deleteModal.show();
    }
</script>
@endpush
