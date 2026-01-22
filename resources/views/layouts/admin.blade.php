<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - THREADLY Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #a855f7;
            --accent: #a855f7;
            --sidebar-width: 280px;
            --bg-dark: #0f0f23;
            --bg-darker: #080816;
            --card-bg: rgba(255, 255, 255, 0.03);
            --border-color: rgba(255, 255, 255, 0.08);
        }
        
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--bg-dark) 0%, var(--bg-darker) 100%);
            min-height: 100vh;
            color: #e2e8f0;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, rgba(15, 15, 35, 0.98) 0%, rgba(8, 8, 22, 0.98) 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--border-color);
            padding: 25px;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0 30px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 25px;
        }
        
        .sidebar-brand .logo {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
        }
        
        .sidebar-brand .brand-text {
            font-size: 1.4rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }
        
        .sidebar-brand .brand-text small {
            display: block;
            font-size: 0.65rem;
            font-weight: 500;
            color: rgba(255,255,255,0.5);
            -webkit-text-fill-color: rgba(255,255,255,0.5);
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        .nav-section {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.4);
            margin: 20px 0 10px;
            padding-left: 15px;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.6);
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 4px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .nav-link:hover {
            color: white;
            background: rgba(168, 85, 247, 0.15);
            transform: translateX(5px);
        }
        
        .nav-link.active {
            color: white;
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.3) 0%, rgba(99, 102, 241, 0.2) 100%);
            box-shadow: 0 4px 15px rgba(168, 85, 247, 0.2);
        }
        
        .nav-link i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }
        
        .nav-link .badge-count {
            margin-left: auto;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            font-size: 0.65rem;
            padding: 3px 8px;
            border-radius: 20px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: 100vh;
        }
        
        .admin-content {
            max-width: 1600px;
            margin: 0 auto;
        }
        
        /* Glass Cards */
        .card-glass {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            transition: all 0.3s ease;
        }
        
        .card-glass:hover {
            border-color: rgba(168, 85, 247, 0.3);
            box-shadow: 0 8px 32px rgba(168, 85, 247, 0.1);
        }
        
        /* Stats Cards */
        .stats-card {
            border-radius: 16px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            opacity: 0.1;
            transform: translate(30%, -30%);
        }
        
        .stats-card-green {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(16, 185, 129, 0.1) 100%);
            border: 1px solid rgba(34, 197, 94, 0.2);
        }
        .stats-card-green::before { background: #22c55e; }
        .stats-card-green .stats-icon { background: rgba(34, 197, 94, 0.2); color: #22c55e; }
        
        .stats-card-purple {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.15) 0%, rgba(139, 92, 246, 0.1) 100%);
            border: 1px solid rgba(168, 85, 247, 0.2);
        }
        .stats-card-purple::before { background: #a855f7; }
        .stats-card-purple .stats-icon { background: rgba(168, 85, 247, 0.2); color: #a855f7; }
        
        .stats-card-blue {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(99, 102, 241, 0.1) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        .stats-card-blue::before { background: #3b82f6; }
        .stats-card-blue .stats-icon { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
        
        .stats-card-orange {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(251, 146, 60, 0.1) 100%);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }
        .stats-card-orange::before { background: #f59e0b; }
        .stats-card-orange .stats-icon { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        
        .stats-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        
        .stats-content { flex: 1; }
        .stats-label {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stats-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            margin: 4px 0;
        }
        .stats-change {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .stats-change.positive { color: #22c55e; }
        .stats-change.negative { color: #ef4444; }
        
        /* Quick Action Buttons */
        .quick-action-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .quick-action-btn:hover {
            background: rgba(168, 85, 247, 0.1);
            border-color: rgba(168, 85, 247, 0.3);
            color: white;
            transform: translateX(5px);
        }
        
        .qa-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        
        .bg-purple-subtle { background: rgba(168, 85, 247, 0.2); }
        .text-purple { color: #a855f7; }
        .bg-cyan-subtle { background: rgba(6, 182, 212, 0.2); }
        .bg-blue-subtle { background: rgba(59, 130, 246, 0.2); }
        .bg-green-subtle { background: rgba(34, 197, 94, 0.2); }
        .bg-orange-subtle { background: rgba(245, 158, 11, 0.2); }
        .bg-pink-subtle { background: rgba(236, 72, 153, 0.2); }
        .text-pink { color: #ec4899; }
        
        /* Avatar */
        .avatar-sm {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        /* Top Product Item */
        .top-product-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255,255,255,0.02);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .top-product-item:hover {
            background: rgba(168, 85, 247, 0.1);
        }
        
        .rank-badge {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.5);
        }
        
        .rank-badge.top-3 {
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
            color: white;
        }
        
        .product-thumb {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            object-fit: cover;
        }
        
        .product-thumb-sm {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            object-fit: cover;
        }
        
        .product-info { flex: 1; min-width: 0; }
        
        /* Stock Alert Item */
        .stock-alert-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(239, 68, 68, 0.05);
            border: 1px solid rgba(239, 68, 68, 0.1);
            border-radius: 12px;
        }
        
        /* Promo Item */
        .promo-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(245, 158, 11, 0.05);
            border: 1px solid rgba(245, 158, 11, 0.1);
            border-radius: 12px;
        }
        
        .promo-badge {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            font-weight: 700;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 6px;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            color: rgba(255,255,255,0.5);
        }
        
        .empty-state i {
            font-size: 2.5rem;
            opacity: 0.5;
            display: block;
            margin-bottom: 10px;
        }
        
        /* Pulse Dot */
        .pulse-dot {
            width: 8px;
            height: 8px;
            background: #22c55e;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        /* Tables */
        .table-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 25px;
        }
        
        .table-dark {
            --bs-table-bg: transparent;
            --bs-table-hover-bg: rgba(168, 85, 247, 0.1);
        }
        
        .table th {
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            padding: 12px 16px;
        }
        
        .table td {
            border-bottom: 1px solid var(--border-color);
            padding: 16px;
            vertical-align: middle;
        }
        
        /* Forms */
        .form-control, .form-select {
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            color: white;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.08);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
            color: white;
        }
        
        .form-control::placeholder {
            color: rgba(255,255,255,0.4);
        }
        
        .form-label {
            color: rgba(255,255,255,0.8);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        
        /* Buttons */
        .btn {
            border-radius: 10px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #9333ea 0%, #4f46e5 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(168, 85, 247, 0.3);
        }
        
        .btn-outline-light {
            border-color: var(--border-color);
            color: rgba(255,255,255,0.8);
        }
        
        .btn-outline-light:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.3);
            color: white;
        }
        
        .btn-outline-light.active {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }
        
        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            backdrop-filter: blur(10px);
        }
        
        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        
        /* Image Preview */
        .image-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid var(--border-color);
        }
        
        /* Override Bootstrap cards for dark theme */
        .card {
            background: rgba(255,255,255,0.03) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.08) !important;
            border-radius: 16px !important;
            color: #e2e8f0;
        }
        
        .card-body {
            color: #e2e8f0;
        }
        
        .card-header {
            background: rgba(255,255,255,0.05) !important;
            border-bottom: 1px solid rgba(255,255,255,0.08) !important;
            color: #fff !important;
        }
        
        .bg-light {
            background: rgba(255,255,255,0.05) !important;
        }
        
        .bg-white {
            background: rgba(255,255,255,0.03) !important;
        }
        
        .shadow-sm {
            box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
        }
        
        /* Override table styles */
        .table {
            color: #e2e8f0;
        }
        
        .table-hover tbody tr:hover {
            background: rgba(168, 85, 247, 0.1) !important;
            color: #fff;
        }
        
        .table thead th {
            background: rgba(255,255,255,0.05) !important;
            color: rgba(255,255,255,0.7) !important;
            border-color: rgba(255,255,255,0.08) !important;
        }
        
        .table td, .table th {
            border-color: rgba(255,255,255,0.08) !important;
        }
        
        /* Text colors */
        .text-dark {
            color: #fff !important;
        }
        
        .text-muted {
            color: rgba(255,255,255,0.5) !important;
        }
        
        .fw-semibold, .fw-bold {
            color: #fff;
        }
        
        /* Form select options */
        .form-select option {
            background: #1a1a2e;
            color: #fff;
        }
        
        /* Modal dark theme */
        .modal-content {
            background: #1a1a2e !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            border-radius: 16px !important;
        }
        
        .modal-header {
            border-bottom: 1px solid rgba(255,255,255,0.1) !important;
        }
        
        .modal-footer {
            border-top: 1px solid rgba(255,255,255,0.1) !important;
        }
        
        .modal-title {
            color: #fff;
        }
        
        .btn-close {
            filter: invert(1);
        }
        
        /* Pagination */
        .pagination .page-link {
            background: rgba(255,255,255,0.05);
            border-color: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
        }
        
        .pagination .page-link:hover {
            background: rgba(168, 85, 247, 0.2);
            border-color: rgba(168, 85, 247, 0.3);
            color: #fff;
        }
        
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
            border-color: transparent;
        }
        
        .pagination .page-item.disabled .page-link {
            background: rgba(255,255,255,0.02);
            color: rgba(255,255,255,0.3);
        }
        
        /* Status badges */
        .badge.bg-success { background: rgba(34, 197, 94, 0.2) !important; color: #22c55e !important; }
        .badge.bg-warning { background: rgba(251, 191, 36, 0.2) !important; color: #fbbf24 !important; }
        .badge.bg-danger { background: rgba(239, 68, 68, 0.2) !important; color: #ef4444 !important; }
        .badge.bg-info { background: rgba(59, 130, 246, 0.2) !important; color: #3b82f6 !important; }
        .badge.bg-primary { background: rgba(168, 85, 247, 0.2) !important; color: #a855f7 !important; }
        .badge.bg-secondary { background: rgba(148, 163, 184, 0.2) !important; color: #94a3b8 !important; }
        
        /* Buttons outline variants */
        .btn-outline-secondary {
            border-color: rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.7);
        }
        
        .btn-outline-secondary:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.3);
            color: #fff;
        }
        
        .btn-outline-success {
            border-color: rgba(34, 197, 94, 0.5);
            color: #22c55e;
        }
        
        .btn-outline-success:hover {
            background: rgba(34, 197, 94, 0.15);
            border-color: #22c55e;
            color: #fff;
        }
        
        .btn-outline-danger {
            border-color: rgba(239, 68, 68, 0.5);
            color: #ef4444;
        }
        
        .btn-outline-danger:hover {
            background: rgba(239, 68, 68, 0.15);
            border-color: #ef4444;
            color: #fff;
        }
        
        .btn-outline-warning {
            border-color: rgba(251, 191, 36, 0.5);
            color: #fbbf24;
        }
        
        .btn-outline-warning:hover {
            background: rgba(251, 191, 36, 0.15);
            border-color: #fbbf24;
            color: #fff;
        }
        
        .btn-outline-info {
            border-color: rgba(59, 130, 246, 0.5);
            color: #3b82f6;
        }
        
        .btn-outline-info:hover {
            background: rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
            color: #fff;
        }
        
        /* Link colors */
        a {
            color: #a855f7;
        }
        
        a:hover {
            color: #c084fc;
        }
        
        /* Dropdown menus */
        .dropdown-menu {
            background: #1a1a2e !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            border-radius: 12px !important;
        }
        
        .dropdown-item {
            color: rgba(255,255,255,0.8) !important;
        }
        
        .dropdown-item:hover {
            background: rgba(168, 85, 247, 0.15) !important;
            color: #fff !important;
        }
        
        .dropdown-divider {
            border-color: rgba(255,255,255,0.1) !important;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                left: -280px;
                transition: left 0.3s ease;
                z-index: 1050;
            }
            .sidebar.open {
                left: 0;
            }
            .sidebar-brand .brand-text,
            .nav-link span,
            .nav-section { display: block; }
            .nav-link { justify-content: flex-start; padding: 14px 18px; }
            .main-content { 
                margin-left: 0; 
                padding: 15px;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }
            .sidebar-overlay.open {
                display: block;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 10px;
            }
            .stats-card {
                padding: 16px;
            }
            .stats-value {
                font-size: 1.4rem;
            }
            .table-responsive {
                font-size: 0.85rem;
            }
            .btn {
                padding: 0.5rem 0.8rem;
                font-size: 0.85rem;
            }
        }
        
        /* Mobile Header */
        .mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: linear-gradient(180deg, rgba(15, 15, 35, 0.98) 0%, rgba(8, 8, 22, 0.98) 100%);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            z-index: 1030;
            padding: 0 15px;
            align-items: center;
            justify-content: space-between;
        }
        
        @media (max-width: 992px) {
            .mobile-header {
                display: flex;
            }
            .main-content {
                padding-top: 75px;
            }
        }
        
        .mobile-header .logo-small {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
        }
        
        .mobile-header .logo-small i {
            font-size: 1.5rem;
            background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .mobile-header .logo-small span {
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .mobile-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-mobile-menu {
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-mobile-menu:hover {
            background: rgba(168, 85, 247, 0.3);
        }
        
        /* Top Navigation Bar */
        .top-nav-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            padding: 15px 20px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .top-nav-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .top-nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            background: rgba(168, 85, 247, 0.15);
            border-color: rgba(168, 85, 247, 0.3);
            color: white;
        }
        
        .btn-back i {
            font-size: 1rem;
        }
        
        .page-title-nav {
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            margin: 0;
        }
        
        .btn-logout-top {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 10px;
            color: #ef4444;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-logout-top:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.5);
        }
        
        .btn-store-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 10px;
            color: #22c55e;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-store-link:hover {
            background: rgba(34, 197, 94, 0.2);
            border-color: rgba(34, 197, 94, 0.5);
            color: #22c55e;
        }
        
        @media (max-width: 576px) {
            .top-nav-bar {
                padding: 12px 15px;
            }
            .btn-back span,
            .btn-logout-top span,
            .btn-store-link span {
                display: none;
            }
            .btn-back,
            .btn-logout-top,
            .btn-store-link {
                padding: 8px 12px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Mobile Header -->
    <div class="mobile-header">
        <a href="{{ route('admin.dashboard') }}" class="logo-small">
            <i class="bi bi-bag-heart"></i>
            <span>THREADLY</span>
        </a>
        <div class="mobile-header-actions">
            <a href="{{ route('home') }}" class="btn-mobile-menu" title="Ver Tienda" target="_blank">
                <i class="bi bi-shop"></i>
            </a>
            <button class="btn-mobile-menu" onclick="toggleSidebar()" title="Menú">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="logo">
                <i class="bi bi-bag-heart"></i>
            </div>
            <div class="brand-text">
                THREADLY
                <small>Admin Panel</small>
            </div>
        </div>
        
        <nav class="nav flex-column">
            <span class="nav-section">Principal</span>
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>
            
            <span class="nav-section">Tienda</span>
            <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <i class="bi bi-box-seam"></i> <span>Productos</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="bi bi-tags"></i> <span>Categorías</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.promotions*') ? 'active' : '' }}" href="{{ route('admin.promotions.index') }}">
                <i class="bi bi-lightning-charge"></i> <span>Promociones</span>
            </a>
            
            <span class="nav-section">Pedidos</span>
            <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <i class="bi bi-bag-check"></i> <span>Pedidos</span>
                @php $pendingCount = \App\Models\Order::where('status', 'pending')->count(); @endphp
                @if($pendingCount > 0)
                    <span class="badge-count">{{ $pendingCount }}</span>
                @endif
            </a>
            
            <span class="nav-section">Usuarios</span>
            <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people"></i> <span>Clientes</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}">
                <i class="bi bi-star"></i> <span>Reseñas</span>
            </a>
            
            <span class="nav-section">Sistema</span>
            <a class="nav-link {{ request()->routeIs('admin.activity*') ? 'active' : '' }}" href="{{ route('admin.activity.index') }}">
                <i class="bi bi-activity"></i> <span>Actividad</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                <i class="bi bi-file-earmark-bar-graph"></i> <span>Reportes</span>
            </a>
            
            <hr style="border-color: var(--border-color); margin: 20px 0;">
            
            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                <i class="bi bi-shop"></i> <span>Ver Tienda</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent text-danger">
                    <i class="bi bi-box-arrow-right"></i> <span>Cerrar Sesión</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation Bar -->
        <div class="top-nav-bar">
            <div class="top-nav-left">
                @if(!request()->routeIs('admin.dashboard'))
                    <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('admin.dashboard') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i>
                        <span>Regresar</span>
                    </a>
                @endif
                <h1 class="page-title-nav">@yield('page-title', 'Panel de Administración')</h1>
            </div>
            <div class="top-nav-right">
                <a href="{{ route('home') }}" class="btn-store-link" target="_blank">
                    <i class="bi bi-shop"></i>
                    <span>Ver Tienda</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-logout-top">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Sidebar for mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }
        
        // Close sidebar when clicking a link on mobile
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 992) {
                    toggleSidebar();
                }
            });
        });
        
        // Close sidebar on resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                document.querySelector('.sidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('open');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
