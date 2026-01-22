@if ($paginator->hasPages())
    <nav class="pagination-wrapper">
        <ul class="pagination-custom">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item-custom disabled">
                    <span class="page-link-custom page-nav">
                        <i class="bi bi-chevron-left"></i>
                        <span class="d-none d-sm-inline">Anterior</span>
                    </span>
                </li>
            @else
                <li class="page-item-custom">
                    <a class="page-link-custom page-nav" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="bi bi-chevron-left"></i>
                        <span class="d-none d-sm-inline">Anterior</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item-custom dots">
                        <span class="page-link-custom">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item-custom active">
                                <span class="page-link-custom">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item-custom">
                                <a class="page-link-custom" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item-custom">
                    <a class="page-link-custom page-nav" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <span class="d-none d-sm-inline">Siguiente</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item-custom disabled">
                    <span class="page-link-custom page-nav">
                        <span class="d-none d-sm-inline">Siguiente</span>
                        <i class="bi bi-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
        
        <p class="pagination-info">
            Mostrando <strong>{{ $paginator->firstItem() ?? 0 }}</strong> - <strong>{{ $paginator->lastItem() ?? 0 }}</strong> de <strong>{{ $paginator->total() }}</strong>
        </p>
    </nav>
    
    <style>
        .pagination-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
        .pagination-custom {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
            justify-content: center;
        }
        .page-item-custom {
            display: inline-flex;
        }
        .page-link-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 42px;
            padding: 0 0.75rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.9);
            color: #334155;
            border: 2px solid #e2e8f0;
        }
        .page-link-custom:hover {
            background: #6366f1;
            color: white;
            border-color: #6366f1;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        .page-item-custom.active .page-link-custom {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }
        .page-item-custom.disabled .page-link-custom {
            background: #f1f5f9;
            color: #94a3b8;
            border-color: #e2e8f0;
            cursor: not-allowed;
            pointer-events: none;
        }
        .page-item-custom.dots .page-link-custom {
            background: transparent;
            border-color: transparent;
            min-width: auto;
            padding: 0 0.25rem;
        }
        .page-link-custom.page-nav {
            gap: 0.5rem;
            padding: 0 1rem;
        }
        .page-link-custom.page-nav i {
            font-size: 0.85rem;
        }
        .pagination-info {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0;
        }
        .pagination-info strong {
            color: #334155;
        }
        
        /* Dark theme support for admin */
        .main-content .pagination-wrapper .page-link-custom {
            background: rgba(255,255,255,0.05);
            color: rgba(255,255,255,0.8);
            border-color: rgba(255,255,255,0.1);
        }
        .main-content .pagination-wrapper .page-link-custom:hover {
            background: rgba(168, 85, 247, 0.3);
            color: white;
            border-color: rgba(168, 85, 247, 0.5);
        }
        .main-content .pagination-wrapper .page-item-custom.active .page-link-custom {
            background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        }
        .main-content .pagination-wrapper .page-item-custom.disabled .page-link-custom {
            background: rgba(255,255,255,0.02);
            color: rgba(255,255,255,0.3);
            border-color: rgba(255,255,255,0.05);
        }
        .main-content .pagination-wrapper .pagination-info {
            color: rgba(255,255,255,0.5);
        }
        .main-content .pagination-wrapper .pagination-info strong {
            color: rgba(255,255,255,0.8);
        }
        
        @media (max-width: 576px) {
            .page-link-custom {
                min-width: 38px;
                height: 38px;
                font-size: 0.85rem;
            }
            .page-link-custom.page-nav {
                padding: 0 0.75rem;
            }
        }
    </style>
@endif
