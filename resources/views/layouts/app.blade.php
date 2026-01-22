<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'THREADLY - Camisetas Premium Ecuador')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
            --accent: #14b8a6;
            --dark: #0f172a;
            --dark-light: #1e293b;
            --gray: #64748b;
            --light: #f8fafc;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --gradient-hero: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
        }

        /* ========== NAVBAR ========== */
        .navbar-premium {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar-premium.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        
        .navbar-brand-premium {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 800;
            font-size: 1.8rem;
            color: white !important;
            letter-spacing: -1px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand-premium span {
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link-premium {
            color: rgba(255,255,255,0.8) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1.2rem !important;
            border-radius: 30px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link-premium:hover {
            color: white !important;
            background: rgba(255,255,255,0.1);
        }

        .nav-link-premium.active {
            background: var(--gradient-1);
            color: white !important;
        }

        .cart-btn {
            position: relative;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .cart-btn:hover {
            background: white;
            color: var(--dark);
        }

        .cart-count {
            background: var(--secondary);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            min-width: 20px;
            text-align: center;
        }

        /* ========== HERO SECTION ========== */
        .hero-premium {
            min-height: 100vh;
            background: var(--gradient-hero);
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero-shapes {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.5;
        }

        .shape-1 {
            width: 600px;
            height: 600px;
            background: var(--gradient-1);
            top: -200px;
            right: -100px;
            animation: float 8s ease-in-out infinite;
        }

        .shape-2 {
            width: 400px;
            height: 400px;
            background: var(--gradient-2);
            bottom: -100px;
            left: -100px;
            animation: float 6s ease-in-out infinite reverse;
        }

        .shape-3 {
            width: 300px;
            height: 300px;
            background: var(--gradient-3);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }

        @keyframes pulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.3; }
            50% { transform: translate(-50%, -50%) scale(1.1); opacity: 0.5; }
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 30px;
            color: white;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
        }

        .hero-badge i {
            color: var(--accent);
        }

        .hero-title {
            font-size: clamp(2.5rem, 6vw, 5rem);
            font-weight: 800;
            color: white;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        .hero-title .highlight {
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-description {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.7);
            margin-bottom: 2rem;
            max-width: 500px;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-premium {
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary-premium {
            background: var(--gradient-1);
            color: white;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-primary-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 50px rgba(102, 126, 234, 0.5);
            color: white;
        }

        .btn-outline-premium {
            background: transparent;
            color: white;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .btn-outline-premium:hover {
            background: white;
            color: var(--dark);
            border-color: white;
        }

        .hero-image-container {
            position: relative;
        }

        .hero-image-wrapper {
            position: relative;
            display: inline-block;
        }

        .hero-image {
            width: 100%;
            max-width: 500px;
            border-radius: 30px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
            transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
            transition: transform 0.5s ease;
        }

        .hero-image:hover {
            transform: perspective(1000px) rotateY(0deg) rotateX(0deg);
        }

        .floating-card {
            position: absolute;
            background: white;
            border-radius: 20px;
            padding: 1rem 1.5rem;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: float 3s ease-in-out infinite;
        }

        .floating-card-1 {
            top: 10%;
            left: -30px;
        }

        .floating-card-2 {
            bottom: 20%;
            right: -30px;
            animation-delay: 1.5s;
        }

        .floating-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .floating-card .text h5 {
            font-size: 0.9rem;
            margin-bottom: 0.2rem;
            color: var(--dark);
        }

        .floating-card .text p {
            font-size: 0.8rem;
            color: var(--gray);
            margin: 0;
        }

        /* ========== SECTIONS ========== */
        .section-premium {
            padding: 100px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-badge {
            display: inline-block;
            background: var(--gradient-1);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        /* ========== FEATURES ========== */
        .features-section {
            background: white;
        }

        .feature-card {
            text-align: center;
            padding: 2rem;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            background: var(--light);
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            color: white;
        }

        .feature-card h4 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            color: var(--gray);
            font-size: 0.95rem;
            margin: 0;
        }

        /* ========== CATEGORY CARDS ========== */
        .category-premium {
            position: relative;
            border-radius: 30px;
            overflow: hidden;
            height: 350px;
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .category-premium:hover {
            transform: scale(1.02);
        }

        .category-premium img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .category-premium:hover img {
            transform: scale(1.1);
        }

        .category-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 30%, rgba(15,23,42,0.95) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2rem;
            color: white;
        }

        .category-overlay h3 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .category-overlay p {
            color: rgba(255,255,255,0.7);
            margin-bottom: 1rem;
        }

        .category-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .category-btn:hover {
            color: var(--accent);
            gap: 1rem;
        }

        /* ========== PRODUCT CARDS ========== */
        .product-premium {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            height: 100%;
        }

        .product-premium:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }

        .product-image-container {
            position: relative;
            height: 280px;
            overflow: hidden;
            background: #f1f5f9;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-premium:hover .product-image-container img {
            transform: scale(1.1);
        }

        .product-badges {
            position: absolute;
            top: 1rem;
            left: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .badge-premium {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-sale {
            background: var(--gradient-2);
            color: white;
        }

        .badge-new {
            background: var(--gradient-4);
            color: var(--dark);
        }

        .product-actions {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
        }

        .product-premium:hover .product-actions {
            opacity: 1;
            transform: translateX(0);
        }

        .action-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .action-btn:hover {
            background: var(--primary);
            color: white;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-category {
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0.5rem 0;
            color: var(--dark);
            transition: color 0.3s ease;
        }

        .product-premium:hover .product-name {
            color: var(--primary);
        }

        .product-price-container {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-top: 1rem;
        }

        .current-price {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--dark);
        }

        .original-price {
            font-size: 1rem;
            color: var(--gray);
            text-decoration: line-through;
        }

        .product-colors {
            display: flex;
            gap: 0.3rem;
            margin-top: 1rem;
        }

        .color-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .color-dot:hover {
            transform: scale(1.2);
        }

        /* ========== NEWSLETTER ========== */
        .newsletter-section {
            background: var(--dark);
            position: relative;
            overflow: hidden;
        }

        .newsletter-section .shape {
            opacity: 0.3;
        }

        .newsletter-content {
            position: relative;
            z-index: 2;
        }

        .newsletter-form {
            background: rgba(255,255,255,0.1);
            border-radius: 60px;
            padding: 0.5rem;
            display: flex;
            max-width: 500px;
            margin: 0 auto;
        }

        .newsletter-form input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 1rem 1.5rem;
            color: white;
            font-size: 1rem;
        }

        .newsletter-form input::placeholder {
            color: rgba(255,255,255,0.6);
        }

        .newsletter-form input:focus {
            outline: none;
        }

        .newsletter-form button {
            background: var(--gradient-2);
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .newsletter-form button:hover {
            transform: scale(1.05);
        }

        /* ========== FOOTER ========== */
        .footer-premium {
            background: var(--dark);
            color: white;
            padding: 80px 0 30px;
        }

        .footer-brand {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .footer-brand span {
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-description {
            color: rgba(255,255,255,0.6);
            margin-bottom: 1.5rem;
            max-width: 300px;
        }

        .footer-social {
            display: flex;
            gap: 1rem;
        }

        .footer-social a {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }

        .footer-social a:hover {
            background: var(--gradient-1);
            transform: translateY(-3px);
        }

        .footer-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: white;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 30px;
            margin-top: 50px;
            text-align: center;
            color: rgba(255,255,255,0.5);
        }

        /* ========== CART SIDEBAR ========== */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -450px;
            width: 450px;
            height: 100vh;
            background: white;
            box-shadow: -10px 0 50px rgba(0,0,0,0.2);
            z-index: 2000;
            transition: right 0.4s ease;
            display: flex;
            flex-direction: column;
        }

        .cart-sidebar.open {
            right: 0;
        }

        .cart-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .cart-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        .cart-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-header h3 {
            font-size: 1.3rem;
            margin: 0;
        }

        .cart-close {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: var(--light);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cart-close:hover {
            background: var(--dark);
            color: white;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border-radius: 15px;
            margin-bottom: 1rem;
            background: var(--light);
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            margin-bottom: 0.3rem;
        }

        .cart-item-details {
            font-size: 0.85rem;
            color: var(--gray);
        }

        .cart-item-price {
            font-weight: 700;
            color: var(--primary);
            margin-top: 0.5rem;
        }

        .cart-item-qty {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-footer {
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
            background: var(--light);
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .cart-total span:first-child {
            font-size: 1.1rem;
        }

        .cart-total span:last-child {
            font-size: 1.5rem;
            font-weight: 800;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 991px) {
            .hero-image {
                margin-top: 3rem;
                transform: none;
            }

            .floating-card {
                display: none;
            }

            .cart-sidebar {
                width: 100%;
                right: -100%;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .section-premium {
                padding: 60px 0;
            }

            .product-image-container {
                height: 200px;
            }
        }

        /* ========== PAGE HEADER ========== */
        .page-header {
            background: var(--gradient-hero);
            padding: 150px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .page-header .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
        }

        .page-header .shape-1 {
            width: 400px;
            height: 400px;
            background: var(--gradient-1);
            top: -100px;
            right: -100px;
        }

        .page-header .shape-2 {
            width: 300px;
            height: 300px;
            background: var(--gradient-2);
            bottom: -50px;
            left: -50px;
        }

        /* ========== FORMS ========== */
        .form-control-premium {
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control-premium:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .form-label-premium {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        /* ========== CARDS ========== */
        .card-premium {
            background: white;
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            border: none;
            overflow: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gray);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--dark);
        }
        
        /* User Navigation Bar - For logged in pages */
        .user-nav-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .user-nav-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-user-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: var(--light);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            color: var(--dark);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-user-back:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-user-back i {
            font-size: 1rem;
        }
        
        .page-title-user {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }
        
        .btn-user-logout {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-user-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(239, 68, 68, 0.4);
        }
        
        .btn-user-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: none;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-user-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(99, 102, 241, 0.4);
            color: white;
        }
        
        @media (max-width: 576px) {
            .user-nav-bar {
                padding: 12px 15px;
            }
            .btn-user-back span,
            .btn-user-logout span {
                display: none;
            }
            .btn-user-back,
            .btn-user-logout,
            .btn-user-home {
                padding: 10px 14px;
            }
            .page-title-user {
                font-size: 1rem;
            }
        }
        
        /* Additional mobile responsive fixes */
        @media (max-width: 768px) {
            .navbar-brand-premium {
                font-size: 1.4rem;
            }
            .cart-btn {
                padding: 0.5rem 0.8rem;
            }
            .hero-title {
                font-size: 2rem;
            }
            .hero-description {
                font-size: 1rem;
            }
            .btn-premium {
                padding: 0.8rem 1.5rem;
                font-size: 0.9rem;
            }
            .section-title {
                font-size: 1.8rem;
            }
            .product-info {
                padding: 1rem;
            }
            .product-name {
                font-size: 1rem;
            }
            .current-price {
                font-size: 1.2rem;
            }
        }
        
        @media (max-width: 480px) {
            .page-header {
                padding: 120px 0 50px;
            }
            .section-premium {
                padding: 40px 0;
            }
            .feature-card {
                padding: 1.5rem;
            }
            .feature-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-premium">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between w-100">
                <a href="{{ route('home') }}" class="navbar-brand-premium text-decoration-none">
                    THREAD<span>LY</span>
                </a>

                <div class="d-none d-lg-flex align-items-center gap-2">
                    <a href="{{ route('home') }}" class="nav-link-premium {{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a>
                    <a href="{{ route('products.index') }}" class="nav-link-premium {{ request()->routeIs('products.*') ? 'active' : '' }}">Colección</a>
                    <a href="{{ route('products.index', ['featured' => 1]) }}" class="nav-link-premium">Destacados</a>
                    <a href="#about" class="nav-link-premium">Nosotros</a>
                    <a href="#contact" class="nav-link-premium">Contacto</a>
                </div>

                <div class="d-flex align-items-center gap-3">
                    @auth
                        <a href="{{ route('orders.index') }}" class="nav-link-premium d-none d-md-block">
                            <i class="bi bi-person"></i> Mi Cuenta
                        </a>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="nav-link-premium d-none d-md-block">
                                <i class="bi bi-gear"></i> Admin
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="nav-link-premium d-none d-md-block">Iniciar Sesión</a>
                    @endauth

                    <button class="cart-btn" onclick="toggleCart()">
                        <i class="bi bi-bag"></i>
                        <span class="d-none d-sm-inline">Carrito</span>
                        <span class="cart-count" id="cart-count">0</span>
                    </button>

                    <button class="btn d-lg-none text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" style="background: var(--dark);">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-white">THREAD<span style="color: #ec4899;">LY</span></h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <nav class="d-flex flex-column gap-2">
                <a href="{{ route('home') }}" class="nav-link-premium">Inicio</a>
                <a href="{{ route('products.index') }}" class="nav-link-premium">Colección</a>
                <a href="{{ route('products.index', ['featured' => 1]) }}" class="nav-link-premium">Destacados</a>
                <a href="#about" class="nav-link-premium">Nosotros</a>
                <a href="#contact" class="nav-link-premium">Contacto</a>
                <hr class="border-secondary">
                @auth
                    <a href="{{ route('orders.index') }}" class="nav-link-premium">Mi Cuenta</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link-premium border-0 bg-transparent w-100 text-start">Cerrar Sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link-premium">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="nav-link-premium">Registrarse</a>
                @endauth
            </nav>
        </div>
    </div>

    <!-- Cart Overlay -->
    <div class="cart-overlay" id="cart-overlay" onclick="toggleCart()"></div>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cart-sidebar">
        <div class="cart-header">
            <h3><i class="bi bi-bag me-2"></i>Tu Carrito</h3>
            <button class="cart-close" onclick="toggleCart()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="cart-items" id="cart-items">
            <div class="text-center py-5 text-muted">
                <i class="bi bi-bag-x fs-1 mb-3 d-block"></i>
                <p>Tu carrito está vacío</p>
                <a href="{{ route('products.index') }}" class="btn btn-premium btn-primary-premium btn-sm">Ver Productos</a>
            </div>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span id="cart-total">$0.00</span>
            </div>
            <a href="{{ route('checkout') }}" class="btn btn-premium btn-primary-premium w-100">
                Finalizar Compra <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 1050; max-width: 400px; border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 1050; max-width: 400px; border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-premium">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="footer-brand">THREAD<span>LY</span></div>
                    <p class="footer-description">Camisetas premium con diseños únicos. Calidad que se siente, estilo que se ve. Hecho en Ecuador 🇪🇨</p>
                    <div class="footer-social">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-tiktok"></i></a>
                        <a href="#"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="footer-title">Tienda</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('products.index') }}">Todos los productos</a></li>
                        <li><a href="{{ route('products.index', ['new' => 1]) }}">Nuevos</a></li>
                        <li><a href="{{ route('products.index', ['sale' => 1]) }}">Ofertas</a></li>
                        <li><a href="{{ route('products.index', ['featured' => 1]) }}">Más vendidos</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="footer-title">Ayuda</h5>
                    <ul class="footer-links">
                        <li><a href="#">Preguntas frecuentes</a></li>
                        <li><a href="#">Guía de tallas</a></li>
                        <li><a href="#">Envíos</a></li>
                        <li><a href="#">Devoluciones</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="footer-title">Empresa</h5>
                    <ul class="footer-links">
                        <li><a href="#">Sobre nosotros</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contacto</a></li>
                        <li><a href="#">Trabaja con nosotros</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4" id="contact">
                    <h5 class="footer-title">Contacto</h5>
                    <ul class="footer-links">
                        <li><i class="bi bi-geo-alt me-2"></i>Quito, Ecuador</li>
                        <li><i class="bi bi-phone me-2"></i>+593 99 123 4567</li>
                        <li><i class="bi bi-envelope me-2"></i>hola@threadly.ec</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} THREADLY. Todos los derechos reservados. Hecho con <i class="bi bi-heart-fill text-danger"></i> en Ecuador</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-premium');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Cart functionality
        function toggleCart() {
            document.getElementById('cart-sidebar').classList.toggle('open');
            document.getElementById('cart-overlay').classList.toggle('open');
            document.body.style.overflow = document.getElementById('cart-sidebar').classList.contains('open') ? 'hidden' : '';
        }

        function loadCart() {
            fetch('{{ route("cart.get") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                updateCartUI(data);
            })
            .catch(error => {
                console.error('Error loading cart:', error);
            });
        }

        function updateCartUI(cart) {
            const cartItems = document.getElementById('cart-items');
            const cartCount = document.getElementById('cart-count');
            const cartTotal = document.getElementById('cart-total');

            if (!cart || !cart.items || cart.items.length === 0) {
                cartItems.innerHTML = `
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-bag-x fs-1 mb-3 d-block"></i>
                        <p>Tu carrito está vacío</p>
                        <a href="{{ route('products.index') }}" class="btn btn-premium btn-primary-premium btn-sm">Ver Productos</a>
                    </div>
                `;
                cartCount.textContent = '0';
                cartTotal.textContent = '$0.00';
                return;
            }

            let itemsHtml = '';
            cart.items.forEach(item => {
                itemsHtml += `
                    <div class="cart-item">
                        <img src="${item.image}" alt="${item.name}" onerror="this.src='https://via.placeholder.com/80'">
                        <div class="cart-item-info">
                            <div class="cart-item-name">${item.name}</div>
                            <div class="cart-item-details">
                                ${item.size ? 'Talla: ' + item.size : ''} 
                                ${item.color ? '| <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:' + item.color + ';vertical-align:middle;border:1px solid #ddd;"></span>' : ''}
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="cart-item-qty">
                                    <button class="qty-btn" onclick="updateCartItem(${item.id}, ${item.quantity - 1})" ${item.quantity <= 1 ? 'disabled' : ''}>
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <span class="px-2">${item.quantity}</span>
                                    <button class="qty-btn" onclick="updateCartItem(${item.id}, ${item.quantity + 1})" ${item.product && item.quantity >= item.product.stock ? 'disabled' : ''}>
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                <div class="cart-item-price">$${item.subtotal.toFixed(2)}</div>
                            </div>
                        </div>
                        <button class="btn btn-sm text-danger p-1" onclick="removeCartItem(${item.id})" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            });

            cartItems.innerHTML = itemsHtml;
            cartCount.textContent = cart.count || 0;
            cartTotal.textContent = '$' + (cart.total || 0).toFixed(2);
        }

        function showCartNotification(message, type = 'success') {
            // Remove existing notifications
            document.querySelectorAll('.cart-notification').forEach(n => n.remove());
            
            const notification = document.createElement('div');
            notification.className = `cart-notification alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
            notification.style.cssText = 'top: 100px; right: 20px; z-index: 3000; max-width: 350px; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);';
            notification.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        function addToCart(productId, size = null, color = null, quantity = 1) {
            // Disable the button temporarily
            const btn = event?.target?.closest('button');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            }

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: productId,
                    size: size,
                    color: color,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartUI(data);
                    showCartNotification(data.message || 'Producto agregado al carrito');
                    toggleCart();
                } else {
                    showCartNotification(data.message || 'Error al agregar el producto', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCartNotification('Error de conexión', 'error');
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-bag-plus"></i>';
                }
            });
        }

        function updateCartItem(itemId, quantity) {
            if (quantity < 1) {
                removeCartItem(itemId);
                return;
            }

            fetch('{{ route("cart.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartUI(data);
                } else {
                    showCartNotification(data.message || 'Error al actualizar', 'error');
                    loadCart(); // Reload cart to get fresh data
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCartNotification('Error de conexión', 'error');
            });
        }

        function removeCartItem(itemId) {
            fetch('{{ route("cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    item_id: itemId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartUI(data);
                    showCartNotification(data.message || 'Producto eliminado');
                } else {
                    showCartNotification(data.message || 'Error al eliminar', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCartNotification('Error de conexión', 'error');
            });
        }

        // Load cart on page load
        document.addEventListener('DOMContentLoaded', loadCart);

        // Auto-hide alerts
        setTimeout(function() {
            document.querySelectorAll('.alert:not(.cart-notification)').forEach(function(alert) {
                if (bootstrap.Alert.getOrCreateInstance) {
                    bootstrap.Alert.getOrCreateInstance(alert).close();
                }
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>
