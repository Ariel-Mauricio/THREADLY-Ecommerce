{{-- User Navigation Bar - Include this in protected pages --}}
@auth
<div class="user-nav-bar" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
    <div class="user-nav-left">
        @if(url()->previous() != url()->current() && !request()->routeIs('home'))
            <a href="{{ url()->previous() }}" class="btn-user-back" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.15); color: rgba(255,255,255,0.8);">
                <i class="bi bi-arrow-left"></i>
                <span>Regresar</span>
            </a>
        @else
            <a href="{{ route('home') }}" class="btn-user-back" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.15); color: rgba(255,255,255,0.8);">
                <i class="bi bi-house"></i>
                <span>Inicio</span>
            </a>
        @endif
        @if(isset($pageTitle))
            <h1 class="page-title-user" style="color: white;">{{ $pageTitle }}</h1>
        @endif
    </div>
    <div class="user-nav-right">
        <a href="{{ route('home') }}" class="btn-user-home">
            <i class="bi bi-shop"></i>
            <span>Tienda</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn-user-logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Salir</span>
            </button>
        </form>
    </div>
</div>

<style>
    .user-nav-bar .btn-user-back:hover {
        background: rgba(168, 85, 247, 0.2) !important;
        border-color: rgba(168, 85, 247, 0.4) !important;
        color: white !important;
    }
</style>
@endauth
