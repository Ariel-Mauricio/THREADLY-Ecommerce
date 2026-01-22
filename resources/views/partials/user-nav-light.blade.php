{{-- User Navigation Bar - Light version for light backgrounds --}}
@auth
<div class="user-nav-bar" style="background: white; border: 2px solid #e2e8f0; box-shadow: 0 5px 25px rgba(0,0,0,0.08);">
    <div class="user-nav-left">
        @if(url()->previous() != url()->current() && !request()->routeIs('home'))
            <a href="{{ url()->previous() }}" class="btn-user-back">
                <i class="bi bi-arrow-left"></i>
                <span>Regresar</span>
            </a>
        @else
            <a href="{{ route('home') }}" class="btn-user-back">
                <i class="bi bi-house"></i>
                <span>Inicio</span>
            </a>
        @endif
        @if(isset($pageTitle))
            <h1 class="page-title-user">{{ $pageTitle }}</h1>
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
@endauth
