<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lúdika's Store</title>
    <link rel='icon' type='image/png' href='/images/logo-dice-v2.png?v=3.6'>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }

        #app {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .app-main {
            padding-top: 12px;
        }

        /* ===== CUSTOM NAVBAR ===== */
        .app-navbar {
            background: #1E6F5C ;
            padding: 0;
            border-bottom: 3px solid #C9A227;
            box-shadow: 0 4px 25px rgba(30, 111, 92, 0.4);
        }

        .app-navbar .container {
            min-height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: nowrap;
            position: relative;
            padding: 8px 15px;
        }

        @media (max-width: 600px) {
            .app-navbar__brand {
                font-size: 0.95rem;
                gap: 6px;
            }
            .app-navbar__brand img {
                height: 30px !important;
            }
        }

        .app-navbar__brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.25rem;
            color: #EAD8B1 !important;
            letter-spacing: 0.5px;
            transition: color 0.2s, transform 0.2s;
        }

        .app-navbar__brand:hover {
            color: #FFFFFF !important;
            transform: scale(1.02);
        }

        .app-navbar__brand-icon {
            width: 38px;
            height: 38px;
            background: #C9A227;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 12px rgba(201, 162, 39, 0.4);
            flex-shrink: 0;
        }

        .app-navbar .nav-link-ghost {
            color: rgba(234, 216, 177, 0.85) !important;
            font-size: 0.95rem;
            font-weight: 600;
            padding: 0.4rem 1.1rem !important;
            border-radius: 50px;
            transition: background 0.2s, color 0.2s;
        }

        .app-navbar .nav-link-ghost:hover {
            background: rgba(234, 216, 177, 0.15);
            color: #FFFFFF !important;
        }

        .app-navbar .nav-link-register {
            background: #C9A227;
            color: #2C2C2C !important;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 0.5rem 1.4rem !important;
            border-radius: 50px;
            margin-left: 6px;
            box-shadow: 0 4px 14px rgba(201, 162, 39, 0.35);
            transition: background 0.2s, transform 0.15s;
        }

        .app-navbar .nav-link-register:hover {
            background: #EAD8B1;
            transform: translateY(-2px);
            color: #2C2C2C !important;
        }

        .navbar-cart-btn {
            background: #C9A227;
            border: none;
            border-radius: 50px;
            padding: 6px 16px 6px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #2C2C2C;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            position: relative;
            box-shadow: 0 4px 14px rgba(201, 162, 39, 0.3);
        }

        .navbar-app-btn {
            background: rgba(234, 216, 177, 0.15);
            border: 1.5px solid rgba(234, 216, 177, 0.4);
            border-radius: 50px;
            padding: 6px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #EAD8B1 !important;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, transform 0.2s;
        }

        .navbar-app-btn:hover {
            background: #EAD8B1;
            color: #1E6F5C !important;
            transform: translateY(-2px);
        }

        .navbar-cart-btn:hover {
            background: #EAD8B1;
            box-shadow: 0 6px 18px rgba(234, 216, 177, 0.4);
            transform: translateY(-2px);
        }

        .navbar-cart-badge {
            display: none;
            position: absolute;
            top: -6px;
            right: -6px;
            min-width: 22px;
            height: 22px;
            background: #69B578;
            color: #2C2C2C;
            font-size: 0.65rem;
            font-weight: 800;
            border-radius: 50px;
            align-items: center;
            justify-content: center;
            line-height: 1;
            padding: 0 5px;
            border: 2px solid #1E6F5C;
            box-shadow: 0 2px 6px rgba(105, 181, 120, 0.4);
        }

        .navbar-user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(234, 216, 177, 0.1);
            border: 1.5px solid rgba(234, 216, 177, 0.25);
            border-radius: 50px;
            padding: 4px 16px 4px 6px;
            text-decoration: none;
            color: #EAD8B1 !important;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background 0.2s, border-color 0.2s;
        }

        .navbar-user-chip:hover {
            background: rgba(234, 216, 177, 0.2);
            border-color: rgba(234, 216, 177, 0.5);
            color: #FFFFFF !important;
        }

        .navbar-user-avatar {
            width: 32px;
            height: 32px;
            background: #C9A227;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            color: #2C2C2C;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(201, 162, 39, 0.3);
        }

        .app-navbar .dropdown-menu {
            margin-top: 8px !important;
            border-radius: 12px;
            border: 1.5px solid #d6ead8;
            box-shadow: 0 8px 24px rgba(30, 111, 92, 0.15);
            overflow: hidden;
            padding: 6px;
            min-width: 160px;
        }

        .app-navbar .dropdown-item {
            border-radius: 8px;
            font-size: 0.88rem;
            padding: 8px 14px;
            color: #1E6F5C;
            font-weight: 500;
            transition: background 0.15s;
        }

        .app-navbar .dropdown-item:hover {
            background: #eef6ef;
            color: #155a49;
        }

        .app-navbar .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 0.45rem 0.6rem;
            background: rgba(0, 0, 0, 0.2);
            box-shadow: none !important;
        }

        .app-navbar .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23EAD8B1' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        @media (max-width: 767.98px) {
            .app-navbar .container {
                padding-top: 8px;
                padding-bottom: 8px;
                flex-wrap: wrap !important;
                row-gap: 10px;
            }

            .app-navbar__brand {
                flex: 1 1 auto;
                min-width: 0;
            }

            .app-navbar .navbar-toggler {
                flex: 0 0 auto;
            }

            .app-navbar .navbar-collapse {
                flex-basis: 100%;
                width: 100%;
                margin: 0;
                margin-top: 6px;
                padding: 14px;
                border-radius: 20px;
                overflow: hidden;
                clear: both;
            }

            .app-navbar .navbar-collapse.show,
            .app-navbar .navbar-collapse.collapsing {
                display: block;
            }

            .app-navbar .navbar-collapse {
                background: #1E6F5C ;
                border: 1px solid rgba(234, 216, 177, 0.15);
                box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4);
            }

            .app-navbar .navbar-nav {
                width: 100%;
                align-items: stretch !important;
                gap: 10px !important;
            }

            .app-navbar .navbar-nav .nav-item {
                width: 100%;
                text-align: left;
            }

            .app-navbar .nav-link-ghost,
            .app-navbar .nav-link-register {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                margin: 0 !important;
                min-height: 48px;
                padding: 12px 16px !important;
                text-align: center;
                max-width: 100%;
            }

            .app-navbar .nav-link-ghost {
                background: rgba(255, 255, 255, 0.06);
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: #ffffff !important;
            }

            .app-navbar .nav-link-register {
                background: #C9A227;
                box-shadow: 0 3px 10px rgba(201, 162, 39, 0.40);
            }

            .mobile-menu-stack {
                display: flex;
                flex-direction: column;
                gap: 10px;
                margin-bottom: 10px;
            }

            .mobile-menu-card {
                background: rgba(7, 25, 20, 0.22);
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 16px;
                padding: 10px;
                backdrop-filter: blur(6px);
            }

            .mobile-menu-list {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .mobile-auth-links {
                background: rgba(255, 255, 255, 0.08);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 16px;
                overflow: hidden;
                box-shadow: none;
            }

            .mobile-auth-link {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 12px;
                width: 100%;
                padding: 13px 14px;
                color: #ffffff;
                text-decoration: none;
                font-size: 0.98rem;
                font-weight: 600;
                border-radius: 14px;
                line-height: 1.2;
            }

            .mobile-auth-link:hover {
                background: rgba(255, 255, 255, 0.12);
                color: #ffffff;
            }

            .mobile-auth-divider {
                margin: 0;
                border: 0;
                border-top: 1px solid rgba(255, 255, 255, 0.08);
            }

            .mobile-auth-btn {
                display: flex;
                align-items: center;
                gap: 12px;
                width: 100%;
                padding: 13px 14px;
                color: #ffffff;
                background: transparent;
                border: 0;
                font-size: 0.98rem;
                font-weight: 600;
                text-align: left;
                border-radius: 14px;
            }

            .mobile-auth-btn:hover {
                background: rgba(255, 255, 255, 0.12);
                color: #ffffff;
            }

            .mobile-auth-guest {
                display: flex;
                flex-direction: column;
                gap: 10px;
                margin-bottom: 10px;
            }

            .mobile-auth-guest .nav-item {
                width: 100%;
            }
        }

        /* ===== TOAST ===== */
        #cart-toast {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 10000;
            background: #fff;
            border: 1.5px solid #69B578;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(30, 111, 92, 0.22);
            padding: 14px 20px;
            min-width: 255px;
            max-width: 330px;
            pointer-events: none;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.32s ease, transform 0.32s ease;
            display: none;
        }

        #cart-toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== QUANTITY MODAL ===== */
        #qty-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(13, 31, 24, 0.55);
            z-index: 20000;
            backdrop-filter: blur(3px);
            align-items: center;
            justify-content: center;
        }

        #qty-modal-overlay.open {
            display: flex;
        }

        #qty-modal {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(30, 111, 92, 0.28);
            border: 1.5px solid #69B578;
            padding: 0;
            width: 340px;
            max-width: 94vw;
            overflow: hidden;
            animation: qtyModalIn 0.25s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes qtyModalIn {
            from {
                opacity: 0;
                transform: scale(0.85) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        #qty-modal-header {
            background: #1E6F5C ;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #qty-modal-title {
            color: #fff;
            font-weight: 700;
            font-size: 0.97rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #qty-modal-close {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.85);
            font-size: 1.4rem;
            cursor: pointer;
            line-height: 1;
            padding: 0;
            transition: color 0.15s;
        }

        #qty-modal-close:hover {
            color: #fff;
        }

        #qty-modal-body {
            padding: 22px 22px 20px;
        }

        #qty-modal-product-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: #2C2C2C;
            margin-bottom: 4px;
            text-align: center;
        }

        #qty-modal-product-price {
            font-size: 0.85rem;
            color: #1E6F5C;
            font-weight: 600;
            text-align: center;
            margin-bottom: 18px;
        }

        .qty-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #1E6F5C;
            margin-bottom: 8px;
            text-align: center;
        }

        .qty-stepper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            border: 2px solid #69B578;
            border-radius: 50px;
            overflow: hidden;
            width: fit-content;
            margin: 0 auto 20px;
        }

        .qty-stepper button {
            background: #eef6ef;
            border: none;
            width: 42px;
            height: 42px;
            font-size: 1.3rem;
            font-weight: 700;
            color: #1E6F5C;
            cursor: pointer;
            transition: background 0.15s;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-stepper button:hover {
            background: #d6ead8;
        }

        .qty-stepper input {
            border: none;
            width: 60px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 700;
            color: #2C2C2C;
            outline: none;
            padding: 0;
            background: #fff;
            -moz-appearance: textfield;
        }

        .qty-stepper input::-webkit-inner-spin-button,
        .qty-stepper input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        #qty-modal-confirm {
            width: 100%;
            padding: 11px;
            background: #C9A227;
            color: #fff;
            border: none;
            border-radius: 50px;
            font-size: 0.93rem;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            box-shadow: 0 4px 16px rgba(201, 162, 39, 0.50);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        #qty-modal-confirm:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        #qty-modal-confirm:disabled {
            opacity: 0.65;
            cursor: wait;
            transform: none;
        }

        /* ===== SUCCESS PURCHASE MODAL ===== */
        #purchase-success-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(13, 31, 24, 0.60);
            z-index: 30000;
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
        }

        #purchase-success-overlay.open {
            display: flex;
        }

        #purchase-success-modal {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 24px 80px rgba(30, 111, 92, 0.30);
            border: 2px solid #69B578;
            padding: 0;
            width: 380px;
            max-width: 94vw;
            overflow: hidden;
            text-align: center;
            animation: successModalIn 0.4s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes successModalIn {
            from {
                opacity: 0;
                transform: scale(0.7) translateY(30px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        #purchase-success-header {
            background: #1E6F5C ;
            padding: 28px 24px 22px;
            position: relative;
        }

        .success-check-circle {
            width: 68px;
            height: 68px;
            background: rgba(255, 255, 255, 0.18);
            border: 3px solid rgba(255, 255, 255, 0.55);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            animation: successCheckPop 0.5s 0.25s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes successCheckPop {
            from {
                transform: scale(0.4);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        #purchase-success-header h2 {
            color: #fff;
            font-size: 1.2rem;
            font-weight: 800;
            margin: 0;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        #purchase-success-body {
            padding: 24px 28px 26px;
        }

        #purchase-success-msg {
            font-size: 0.97rem;
            color: #555;
            line-height: 1.6;
            margin: 0 0 22px;
        }

        #purchase-success-close {
            width: 100%;
            padding: 12px;
            background: #C9A227;
            color: #fff;
            border: none;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 18px rgba(201, 162, 39, 0.50);
            transition: opacity 0.2s, transform 0.15s;
        }

        #purchase-success-close:hover {
            opacity: 0.88;
            transform: scale(1.02);
        }

        .success-confetti {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .success-confetti span {
            position: absolute;
            top: -10px;
            border-radius: 2px;
            animation: confettiFall 1.2s ease-in forwards;
            opacity: 0;
        }

        @keyframes confettiFall {
            0% {
                opacity: 1;
                transform: translateY(0) rotate(0deg);
            }

            100% {
                opacity: 0;
                transform: translateY(100px) rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div id="app">

        {{-- ===== NAVBAR ===== --}}
        <nav class="navbar navbar-expand-md app-navbar">
            <div class="container">
                <a class="app-navbar__brand" href="{{ Auth::check() ? route('home') : url('/') }}">
                    <img src="/images/logo-dice-v2.png" alt="Lúdika"
                        style="height:38px; width:auto; object-fit:contain; border-radius:8px;">
                    Lúdika
                </a>

                {{-- Navegación principal --}}
                <div class="d-none d-md-flex align-items-center ms-3">
                    <a href="{{ route('categories.public') }}" class="nav-link-ghost" style="font-weight: 600;">
                        Categorías
                    </a>
                    <a href="{{ route('acercade') }}" class="nav-link-ghost" style="font-weight: 600;">
                        Quiénes somos
                    </a>

                </div>

                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- Categorías en móvil (solo visible en pantallas pequeñas) --}}
                    <div class="d-md-none mobile-menu-stack">
                        <div class="mobile-menu-card">
                            <div class="mobile-menu-list">
                                <a href="{{ route('categories.public') }}" class="mobile-auth-link">
                                    Categorías
                                </a>
                                <a href="{{ route('acercade') }}" class="mobile-auth-link">
                                    Quiénes somos
                                </a>

                                @auth
                                    @if(Auth::user()->hasRole('admin'))
                                        <hr class="mobile-auth-divider" style="margin: 4px 0; border-color: rgba(255,255,255,0.1);">
                                        <a href="{{ route('products.index') }}" class="mobile-auth-link" style="color: #C9A227;">
                                            Productos (Admin)
                                        </a>
                                        <a href="{{ route('categories.index') }}" class="mobile-auth-link" style="color: #C9A227;">
                                            Categorías (Admin)
                                        </a>
                                        <a href="{{ route('admin.orders.index') }}" class="mobile-auth-link" style="color: #C9A227;">
                                            Tabla de Pedidos
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>

                        @guest
                            <div class="mobile-menu-card mobile-auth-guest">
                                @if (Route::has('login'))
                                    <li class="nav-item list-unstyled">
                                        <a class="nav-link-ghost" href="{{ route('login') }}">Iniciar sesión</a>
                                    </li>
                                @endif
                                @if (Route::has('register'))
                                    <li class="nav-item list-unstyled">
                                        <a class="nav-link-register" href="{{ route('register') }}">Registrarse</a>
                                    </li>
                                @endif
                            </div>
                        @endguest
                    </div>

                    <ul class="navbar-nav ms-auto align-items-center gap-2">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link-ghost" href="{{ route('login') }}">Iniciar sesión</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link-register" href="{{ route('register') }}">Registrarse</a>
                                </li>
                            @endif
                        @else

                            {{-- Cart Button --}}
                            <li class="nav-item d-none d-md-block" style="position:relative; margin-left: 10px;">
                                <button id="cart-toggle" class="navbar-cart-btn" title="Mi carrito">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="9" cy="21" r="1" />
                                        <circle cx="20" cy="21" r="1" />
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                                    </svg>
                                    <span style="font-size:0.82rem;font-weight:600;">Carrito</span>
                                    <span id="cart-badge" class="navbar-cart-badge">0</span>
                                </button>

                                {{-- Cart Dropdown Panel --}}
                                <div id="cart-panel"
                                    style="display:none;position:absolute;top:calc(100% + 14px);right:0;
                                                                                         width:330px;background:#fff;border-radius:16px;
                                                                                         box-shadow:0 12px 40px rgba(30,111,92,0.20);
                                                                                         border:1.5px solid #69B578;z-index:9999;overflow:hidden;">
                                    <div
                                        style="background: #1E6F5C ;padding:14px 18px;
                                                                                                    display:flex;align-items:center;justify-content:space-between;">
                                        <span
                                            style="color:#fff;font-weight:700;font-size:0.97rem;display:flex;align-items:center;gap:8px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="9" cy="21" r="1" />
                                                <circle cx="20" cy="21" r="1" />
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                                            </svg>
                                            Mi Carrito
                                        </span>
                                        <button id="cart-panel-close"
                                            style="background:none;border:none;color:rgba(255,255,255,0.85);font-size:1.3rem;cursor:pointer;line-height:1;padding:0;">&times;</button>
                                    </div>
                                    <div id="cart-panel-body" style="max-height:290px;overflow-y:auto;padding:14px 16px;">
                                        <p style="text-align:center;color:#bbb;font-size:0.88rem;">Cargando...</p>
                                    </div>
                                    <div style="padding:12px 18px;border-top:1.5px solid #d6ead8;background:#f4faf5;">
                                        <div
                                            style="display:flex;justify-content:space-between;align-items:center;font-weight:700;font-size:0.95rem;">
                                            <span style="color:#2d2d2d;">Total:</span>
                                            <span id="cart-total" style="color:#1E6F5C;font-size:1.05rem;">$0.00</span>
                                        </div>
                                        <a href="{{ route('cart.index') }}"
                                            style="display:flex;align-items:center;justify-content:center;gap:7px;
                                                                                                       margin-top:11px;width:100%;padding:10px;
                                                                                                       background:#C9A227;
                                                                                                       color:#fff;border-radius:50px;text-decoration:none;
                                                                                                       font-size:.88rem;font-weight:700;
                                                                                                       box-shadow:0 4px 14px rgba(34,197,94,.50);
                                                                                                       transition:opacity .2s;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="9" cy="21" r="1" />
                                                <circle cx="20" cy="21" r="1" />
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                                            </svg>
                                            Ver carrito completo
                                        </a>
                                    </div>
                                </div>
                            </li>

                            {{-- User Dropdown --}}
                            <li class="nav-item dropdown d-none d-md-block">
                                <a id="navbarDropdown" class="navbar-user-chip dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <span class="navbar-user-avatar" style="overflow:hidden;">
                                        @if(Auth::user()->hasAvatar())
                                            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}"
                                                style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                                        @else
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        @endif
                                    </span>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round" style="margin-right:6px;">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                            <circle cx="12" cy="7" r="4" />
                                        </svg>
                                        Editar perfil
                                    </a>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round" style="margin-right:6px;">
                                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
                                        </svg>
                                        Mis compras
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round" style="margin-right:6px;">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                            <polyline points="16 17 21 12 16 7" />
                                            <line x1="21" y1="12" x2="9" y2="12" />
                                        </svg>
                                        Cerrar sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                            <li class="nav-item d-md-none">
                                <div class="mobile-auth-links">
                                    <a class="mobile-auth-link" href="{{ route('cart.index') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="9" cy="21" r="1" />
                                            <circle cx="20" cy="21" r="1" />
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                                        </svg>
                                        Carrito
                                    </a>
                                    <hr class="mobile-auth-divider">
                                    <a class="mobile-auth-link" href="{{ route('profile.edit') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                             stroke-linejoin="round">
                                             <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                             <circle cx="12" cy="7" r="4" />
                                         </svg>
                                         Mi Perfil
                                     </a>
                                     @if(Auth::user()->role === 'admin')
                                         <a class="mobile-auth-link" href="{{ route('home') }}">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                                             Panel Administrativo
                                         </a>
                                         <a class="mobile-auth-link" href="{{ route('productos.index') }}">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                             Gestionar Productos
                                         </a>
                                     @endif
                                    <hr class="mobile-auth-divider">
                                    <a class="mobile-auth-link" href="{{ route('orders.index') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
                                        </svg>
                                        Mis compras
                                    </a>
                                    <hr class="mobile-auth-divider">
                                    <button class="mobile-auth-btn" type="button"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                            <polyline points="16 17 21 12 16 7" />
                                            <line x1="21" y1="12" x2="9" y2="12" />
                                        </svg>
                                        Cerrar sesión
                                    </button>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- ===== TOAST NOTIFICATION ===== --}}
        <div id="cart-toast">
            <div style="display:flex;align-items:center;gap:12px;">
                <span style="display:flex;align-items:center;justify-content:center;
                         width:40px;height:40px;background:#C9A227;
                         border-radius:50%;flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </span>
                <div>
                    <p style="margin:0;font-weight:700;font-size:0.92rem;color:#2C2C2C;">¡Producto añadido al carrito!
                    </p>
                    <p id="cart-toast-name" style="margin:2px 0 0;font-size:0.82rem;color:#1E6F5C;"></p>
                </div>
            </div>
        </div>

        {{-- ===== QUANTITY MODAL ===== --}}
        <div id="qty-modal-overlay">
            <div id="qty-modal">
                <div id="qty-modal-header">
                    <p id="qty-modal-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1" />
                            <circle cx="20" cy="21" r="1" />
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                        </svg>
                        Añadir al carrito
                    </p>
                    <button id="qty-modal-close" aria-label="Cerrar">&times;</button>
                </div>
                <div id="qty-modal-body">
                    <p id="qty-modal-product-name"></p>
                    <p id="qty-modal-product-price"></p>
                    <span class="qty-label">Selecciona la cantidad:</span>
                    <div class="qty-stepper">
                        <button type="button" id="qty-minus" aria-label="Reducir cantidad">-</button>
                        <input type="number" id="qty-input" value="1" min="1" max="99">
                        <button type="button" id="qty-plus" aria-label="Aumentar cantidad">+</button>
                    </div>
                    <button type="button" id="qty-modal-confirm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1" />
                            <circle cx="20" cy="21" r="1" />
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                        </svg>
                        Agregar al carrito
                    </button>
                </div>
            </div>
        </div>

        {{-- ===== SUCCESS PURCHASE MODAL ===== --}}
        @if(session('success'))
            <div id="purchase-success-overlay" class="open">
                <div id="purchase-success-modal">
                    <div id="purchase-success-header">
                        <div class="success-confetti" id="confetti-container"></div>
                        <div class="success-check-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" fill="none"
                                stroke="#fff" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        </div>
                        <h2>¡Compra realizada con éxito!</h2>
                    </div>
                    <div id="purchase-success-body">
                        <p id="purchase-success-msg">{{ session('success') }}</p>
                        <button id="purchase-success-close"
                            onclick="document.getElementById('purchase-success-overlay').classList.remove('open')">
                            ¡Entendido, gracias! !
                        </button>
                    </div>
                </div>
            </div>
            <script>
                /* Confetti animation */
                (function () {
                    var colors = ['#1E6F5C', '#69B578', '#C9A227', '#EAD8B1', '#fff', '#2C2C2C'];
                    var container = document.getElementById('confetti-container');
                    if (!container) return;
                    for (var i = 0; i < 28; i++) {
                        var el = document.createElement('span');
                        var size = Math.random() * 8 + 5;
                        el.style.cssText = [
                            'left:' + Math.random() * 100 + '%',
                            'width:' + size + 'px',
                            'height:' + (size * 0.4) + 'px',
                            'background:' + colors[Math.floor(Math.random() * colors.length)],
                            'animation-delay:' + (Math.random() * 0.6) + 's',
                            'animation-duration:' + (Math.random() * 0.6 + 0.9) + 's'
                        ].join(';');
                        container.appendChild(el);
                    }
                })();
            </script>
        @endif


        {{-- ===== PAGE CONTENT ===== --}}
        <main class="app-main pb-4">
            @yield('content')
        </main>

        {{-- ===== FOOTER ===== --}}
        <footer style="
            background: #1E6F5C ;
            border-top: 3px solid #C9A227;
            padding: 40px 0 0;
            margin-top: auto;
        ">
            <div class="container">
                <div
                    style="display:flex; flex-wrap:wrap; gap:30px; justify-content:space-between; padding-bottom:24px;">

                    {{-- Brand column --}}
                    <div style="min-width:220px; flex:1 1 220px; max-width:280px;">
                        <a href="{{ url('/') }}"
                            style="display:inline-flex; align-items:center; gap:8px; text-decoration:none; margin-bottom:10px;">
                            <img src="/images/logo-dice-v2.png" alt="Lúdika"
                                style="height:40px; width:auto; object-fit:contain; border-radius:8px; flex-shrink:0;">
                            <span
                                style="font-size:1.25rem; font-weight:800; color:#EAD8B1; letter-spacing:0.5px;">Lúdika</span>
                        </a>
                        <p style="color:rgba(234,216,177,0.85); font-size:0.9rem; font-weight:500; line-height:1.65; margin:0;">
                            Tu tienda de confianza. Productos seleccionados con calidad y atención personalizada para
                            cada cliente.
                        </p>
                    </div>

                    {{-- Social Media column --}}
                    <div style="min-width:180px; flex:1 1 180px;">
                        <h6
                            style="color:#C9A227; font-size:0.78rem; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; margin-bottom:16px;">
                            Redes Sociales</h6>
                        <ul
                            style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:12px;">
                            <li>
                                <a href="https://www.facebook.com/nuestraludika" target="_blank"
                                    style="display:flex; align-items:center; gap:10px; color:#EAD8B1; font-weight:600; font-size:0.9rem; text-decoration:none; transition:color 0.2s;"
                                    onmouseover="this.style.color='#FFFFFF'"
                                    onmouseout="this.style.color='#EAD8B1'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                                    Facebook: Lúdika
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/ludika.2020" target="_blank"
                                    style="display:flex; align-items:center; gap:10px; color:#EAD8B1; font-weight:600; font-size:0.9rem; text-decoration:none; transition:color 0.2s;"
                                    onmouseover="this.style.color='#FFFFFF'"
                                    onmouseout="this.style.color='#EAD8B1'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                                    Instagram: ludika.2020
                                </a>
                            </li>
                            <li>
                                <a href="https://www.tiktok.com/@_juegosludika" target="_blank"
                                    style="display:flex; align-items:center; gap:10px; color:#EAD8B1; font-weight:600; font-size:0.9rem; text-decoration:none; transition:color 0.2s;"
                                    onmouseover="this.style.color='#FFFFFF'"
                                    onmouseout="this.style.color='#EAD8B1'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg>
                                    TikTok: @_juegosludika
                                </a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/@Lúdika-j3v" target="_blank"
                                    style="display:flex; align-items:center; gap:10px; color:#EAD8B1; font-weight:600; font-size:0.9rem; text-decoration:none; transition:color 0.2s;"
                                    onmouseover="this.style.color='#FFFFFF'"
                                    onmouseout="this.style.color='#EAD8B1'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/></svg>
                                    YouTube: @Lúdika-j3v
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Bottom bar --}}
                <div style="
                    border-top: 1px solid rgba(201,162,39,0.30);
                    padding: 16px 0;
                    display: flex;
                    flex-wrap: wrap;
                    align-items: center;
                    justify-content: space-between;
                    gap: 12px;
                ">
                    <p style="color:rgba(234,216,177,0.7); font-size:0.85rem; margin:0; font-weight:600;">
                        &copy; {{ date('Y') }} Lúdika. Todos los derechos reservados.
                    </p>
                    <p style="color:rgba(234,216,177,0.7); font-size:0.85rem; margin:0; font-weight:600;">
                        Hecho con <span style="color:#C9A227;">♥</span> en México
                    </p>
                </div>
            </div>
        </footer>

    </div>{{-- /#app --}}

    {{-- ======================================================= --}}
    {{-- MAIN CART SCRIPT â€” defined BEFORE @stack so window.addToCart
    is always available when onclick handlers in child views fire --}}
    {{-- ======================================================= --}}
    <script>

        function _cartFormatMoney(v) {
            return 'MXN $' + parseFloat(v).toFixed(2);
        }

        function _cartUpdateBadge(count) {
            var badge = document.getElementById('cart-badge');
            if (!badge) return;
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.style.display = 'inline-flex';
            } else {
                badge.style.display = 'none';
            }
        }

        function _cartShowToast(name) {
            var toast = document.getElementById('cart-toast');
            var toastName = document.getElementById('cart-toast-name');
            if (!toast) return;
            if (toastName) toastName.textContent = name || '';
            toast.style.display = 'block';
            requestAnimationFrame(function () {
                requestAnimationFrame(function () { toast.classList.add('show'); });
            });
            clearTimeout(window._cartToastTimer);
            window._cartToastTimer = setTimeout(function () {
                toast.classList.remove('show');
                setTimeout(function () { toast.style.display = 'none'; }, 350);
            }, 3000);
        }

        window.addToCart = function (productId, btn, name, price) {
            var overlay = document.getElementById('qty-modal-overlay');
            var inp = document.getElementById('qty-input');
            if (!overlay || !inp) {
                /* fallback: add qty=1 directly if modal not found */
                _cartDoAdd(productId, 1, btn);
                return;
            }
            window._cartPendingId = productId;
            window._cartPendingBtn = btn;
            inp.value = 1;
            var nameEl = document.getElementById('qty-modal-product-name');
            var priceEl = document.getElementById('qty-modal-product-price');
            if (nameEl) nameEl.textContent = name || '';
            if (priceEl) priceEl.textContent = price ? '$' + parseFloat(price).toFixed(2) : '';
            overlay.classList.add('open');
            inp.focus();
        };

        
        function _cartDoAdd(productId, qty, btn) {
            if (btn) btn.disabled = true;
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': (document.querySelector('meta[name=csrf-token]') || {}).content || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ product_id: productId, qty: qty })
            })
                .then(function (r) {
                    if (r.status === 422) {
                        return r.json().then(function (data) {
                            alert(data.message);
                            throw new Error(data.message);
                        });
                    }
                    return r.json();
                })
                .then(function (data) {
                    _cartUpdateBadge(data.count);
                    /* bounce animation on cart button */
                    var toggle = document.getElementById('cart-toggle');
                    if (toggle) {
                        toggle.style.transform = 'scale(1.35)';
                        toggle.style.transition = 'transform 0.15s ease';
                        setTimeout(function () { toggle.style.transform = 'scale(1)'; }, 220);
                    }
                    _cartShowToast(data.name || '');
                    if (btn) { btn.classList.add('cart-added'); btn.title = 'Añadido al carrito'; }
                    /* refresh panel if open */
                    var panel = document.getElementById('cart-panel');
                    if (panel && panel.style.display !== 'none') _cartLoadPanel();
                    setTimeout(function () {
                        if (btn) { btn.disabled = false; btn.classList.remove('cart-added'); }
                    }, 1400);
                })
                .catch(function (err) {
                    if (btn) btn.disabled = false;
                    console.error('Cart error:', err);
                });
        }

       
        function _cartLoadPanel() {
            var body = document.getElementById('cart-panel-body');
            if (body) body.innerHTML = '<p style="text-align:center;color:#bbb;font-size:.88rem;padding:18px 0;">Cargando...</p>';
            fetch('/cart/items', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    _cartUpdateBadge(data.count);
                    _cartRenderPanel(data);
                })
                .catch(function () {
                    var b = document.getElementById('cart-panel-body');
                    if (b) b.innerHTML = '<p style="color:#1E6F5C;text-align:center;padding:16px 0;">Error al cargar.</p>';
                });
        }

        function _cartRenderPanel(data) {
            var body = document.getElementById('cart-panel-body');
            var total = document.getElementById('cart-total');
            if (!body) return;
            if (!data.items || data.items.length === 0) {
                body.innerHTML = '<div style="text-align:center;padding:28px 0;color:#bbb;">'
                    + '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#69B578" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 10px;">'
                    + '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>'
                    + '<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>'
                    + '<p style="font-size:.9rem;margin:0;">Tu carrito está vacío</p></div>';
                if (total) total.textContent = '$0.00';
                return;
            }
            var html = '<table style="width:100%;border-collapse:collapse;font-size:.84rem;">'
                + '<thead><tr style="border-bottom:2px solid #d6ead8;">'
                + '<th style="text-align:left;padding:6px 4px;color:#1E6F5C;font-weight:700;">Producto</th>'
                + '<th style="text-align:center;padding:6px 4px;color:#1E6F5C;font-weight:700;">Cant.</th>'
                + '<th style="text-align:right;padding:6px 4px;color:#1E6F5C;font-weight:700;">Subtotal</th>'
                + '</tr></thead><tbody>';
            data.items.forEach(function (item) {
                html += '<tr style="border-bottom:1px solid #eef6ef;">'
                    + '<td style="padding:9px 4px;color:#2d2d2d;font-weight:500;max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' + item.name + '</td>'
                    + '<td style="padding:9px 4px;text-align:center;"><span style="display:inline-flex;align-items:center;justify-content:center;background:#eef6ef;border:1.5px solid #69B578;border-radius:50px;min-width:30px;padding:2px 8px;color:#1E6F5C;font-weight:700;">' + item.qty + '</span></td>'
                    + '<td style="padding:9px 4px;text-align:right;color:#1E6F5C;font-weight:700;">' + _cartFormatMoney(item.subtotal) + '</td>'
                    + '</tr>';
            });
            html += '</tbody></table>';
            body.innerHTML = html;
            if (total) total.textContent = _cartFormatMoney(data.total);
        }

        
        document.addEventListener('DOMContentLoaded', function () {

            @guest
                /* redirect cached login page on back-button */
                window.addEventListener('pageshow', function (e) {
                    if (e.persisted) window.location.replace('/');
                });
            @endguest

            @auth
                /* redirect authenticated users away from auth pages */
                if (/\/(login|register)/.test(window.location.pathname)) {
                    window.location.replace('/home');
                }

                /* â”€â”€ cart badge on load â”€â”€ */
                fetch('/cart/count', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function (r) { return r.json(); })
                    .then(function (data) { _cartUpdateBadge(data.count); })
                    .catch(function () { });

                /* â”€â”€ cart panel toggle â”€â”€ */
                var cartPanel = document.getElementById('cart-panel');
                var cartToggle = document.getElementById('cart-toggle');
                var cartClose = document.getElementById('cart-panel-close');

                if (cartToggle && cartPanel) {
                    cartToggle.addEventListener('click', function (e) {
                        e.stopPropagation();
                        var open = cartPanel.style.display !== 'none';
                        cartPanel.style.display = open ? 'none' : 'block';
                        if (!open) _cartLoadPanel();
                    });
                }
                if (cartClose && cartPanel) {
                    cartClose.addEventListener('click', function () { cartPanel.style.display = 'none'; });
                }
                document.addEventListener('click', function (e) {
                    if (!cartPanel || cartPanel.style.display === 'none') return;
                    if (!cartPanel.contains(e.target) && cartToggle && !cartToggle.contains(e.target)) {
                        cartPanel.style.display = 'none';
                    }
                });

                /* â”€â”€ qty modal wiring â”€â”€ */
                var qtyOverlay = document.getElementById('qty-modal-overlay');
                var qtyInput = document.getElementById('qty-input');
                var qtyMinus = document.getElementById('qty-minus');
                var qtyPlus = document.getElementById('qty-plus');
                var qtyConfirm = document.getElementById('qty-modal-confirm');
                var qtyModalClose = document.getElementById('qty-modal-close');

                function closeQtyModal() {
                    if (qtyOverlay) qtyOverlay.classList.remove('open');
                    window._cartPendingId = null;
                    window._cartPendingBtn = null;
                }

                if (qtyMinus && qtyInput) {
                    qtyMinus.addEventListener('click', function () {
                        var v = parseInt(qtyInput.value) || 1;
                        if (v > 1) qtyInput.value = v - 1;
                    });
                }
                if (qtyPlus && qtyInput) {
                    qtyPlus.addEventListener('click', function () {
                        var v = parseInt(qtyInput.value) || 1;
                        if (v < 99) qtyInput.value = v + 1;
                    });
                }
                if (qtyModalClose) qtyModalClose.addEventListener('click', closeQtyModal);
                if (qtyOverlay) {
                    qtyOverlay.addEventListener('click', function (e) {
                        if (e.target === qtyOverlay) closeQtyModal();
                    });
                }

                if (qtyConfirm && qtyInput) {
                    qtyConfirm.addEventListener('click', function () {
                        var qty = Math.min(99, Math.max(1, parseInt(qtyInput.value) || 1));
                        var productId = window._cartPendingId;
                        var btn = window._cartPendingBtn;
                        closeQtyModal();
                        qtyConfirm.disabled = true;
                        _cartDoAdd(productId, qty, btn);
                        setTimeout(function () { qtyConfirm.disabled = false; }, 1600);
                    });
                }

                /* Allow pressing Enter in the qty input to confirm */
                if (qtyInput) {
                    qtyInput.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter' && qtyConfirm) qtyConfirm.click();
                    });
                }
            @endauth
    });
    </script>

    @stack('scripts')
</body>

</html>



