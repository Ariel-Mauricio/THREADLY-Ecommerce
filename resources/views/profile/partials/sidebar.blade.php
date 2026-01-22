<div class="profile-sidebar">
    <div class="text-center p-4">
        <div class="avatar-circle mx-auto mb-3" style="width: 100px; height: 100px; background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(168, 85, 247, 0.3);">
            @if(auth()->user()->avatar)
                <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <span class="text-white" style="font-size: 2.5rem; font-weight: 700;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            @endif
        </div>
        <h5 class="text-white mb-1 fw-bold">{{ auth()->user()->name }}</h5>
        <p class="text-white-50 mb-2">{{ auth()->user()->email }}</p>
        <small class="text-white-50">
            <i class="bi bi-calendar3 me-1"></i>
            Miembro desde {{ auth()->user()->created_at->format('M Y') }}
        </small>
    </div>
    
    <div class="profile-nav">
        <a href="{{ route('profile.index') }}" class="profile-nav-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
            <i class="bi bi-person-fill"></i>
            <span>Mi Perfil</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="profile-nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="bi bi-pencil-fill"></i>
            <span>Editar Perfil</span>
        </a>
        <a href="{{ route('profile.addresses') }}" class="profile-nav-item {{ request()->routeIs('profile.addresses') ? 'active' : '' }}">
            <i class="bi bi-geo-alt-fill"></i>
            <span>Mis Direcciones</span>
        </a>
        <a href="{{ route('orders.index') }}" class="profile-nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
            <i class="bi bi-bag-fill"></i>
            <span>Mis Pedidos</span>
        </a>
        <a href="{{ route('wishlist.index') }}" class="profile-nav-item {{ request()->routeIs('wishlist.*') ? 'active' : '' }}">
            <i class="bi bi-heart-fill"></i>
            <span>Lista de Deseos</span>
        </a>
        <a href="{{ route('profile.password') }}" class="profile-nav-item {{ request()->routeIs('profile.password') ? 'active' : '' }}">
            <i class="bi bi-key-fill"></i>
            <span>Cambiar Contraseña</span>
        </a>
        
        <div style="border-top: 1px solid rgba(255,255,255,0.1); margin: 12px 0;"></div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="profile-nav-item logout-btn" style="width: 100%; border: none; background: transparent; cursor: pointer; text-align: left;">
                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar Sesión</span>
            </button>
        </form>
    </div>
</div>
