<!doctype html>
<html lang="en">

<head>
    <title>Lúdika 's Store</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/logo-dice-v2.png?v=2.0">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">

    <!-- Slot para CSS personalizado -->
    @yield('css')
    <style>
        /* ── x-layout navbar override ── */
        .x-navbar {
            background: #1E6F5C ;
            padding: 0 0;
            border-bottom: 2px solid rgba(105, 181, 120, 0.35);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.35);
        }

        .x-navbar .container {
            min-height: 62px;
        }

        .x-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .x-brand-icon {
            width: 34px;
            height: 34px;
            background: #1E6F5C ;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(30, 111, 92, 0.4);
            flex-shrink: 0;
            border: 1.5px solid rgba(105, 181, 120, 0.4);
        }

        .x-brand-name {
            font-size: 1.1rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.01em;
        }

        .x-nav-user {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(255, 255, 255, 0.18);
            border-radius: 50px;
            padding: 6px 14px 6px 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s;
            color: #fff !important;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .x-nav-user:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff !important;
        }

        .x-nav-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(105, 181, 120, 0.6);
        }

        .x-dropdown-menu {
            border-radius: 14px !important;
            border: 1.5px solid #d6ead8 !important;
            box-shadow: 0 8px 28px rgba(30, 111, 92, 0.15) !important;
            padding: 8px !important;
            min-width: 180px;
        }

        .x-dropdown-menu .dropdown-item {
            border-radius: 9px;
            padding: 9px 14px;
            font-size: 0.88rem;
            font-weight: 600;
            color: #1E6F5C;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background .15s;
        }

        .x-dropdown-menu .dropdown-item:hover {
            background: #eef6ef;
            color: #1E6F5C;
        }

        .x-dropdown-menu .dropdown-divider {
            border-color: #d6ead8;
            margin: 4px 0;
        }

        .x-admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(201, 162, 39, 0.18);
            border: 1.5px solid rgba(201, 162, 39, 0.4);
            color: #C9A227;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 2px 9px;
            border-radius: 50px;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
    </style>
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <nav class="navbar x-navbar">
            <div class="container">
                <a class="x-brand" href="{{ route('home.admin') }}">
                    <div class="x-brand-icon">
                        <img src="{{ asset('images/logo-dice-v2.png') }}" alt="Logo" style="width: 24px; height: 100%; object-fit: contain;">
                    </div>
                    <span class="x-brand-name">Lúdika 's Store</span>
                </a>

                <div class="x-admin-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    Admin
                </div>

                <div class="dropdown">
                    <a class="x-nav-user dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        @if(Auth::user()->hasAvatar())
                            <img class="x-nav-avatar" src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}">
                        @else
                            <span class="x-nav-avatar"
                                style="display:flex;align-items:center;justify-content:center;background: #1E6F5C ;color:#fff;font-weight:700;font-size:0.82rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        @endif
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end x-dropdown-menu" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                Mi Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('orders.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
                                </svg>
                                Mis compras
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('categories.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                    <line x1="7" y1="7" x2="7.01" y2="7"/>
                                </svg>
                                Categorías
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('home.admin') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                                    <line x1="3" y1="6" x2="21" y2="6" />
                                    <path d="M16 10a4 4 0 0 1-8 0" />
                                </svg>
                                Tienda
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider x-dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" style="color:#c0392b !important;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <polyline points="16 17 21 12 16 7" />
                                    <line x1="21" y1="12" x2="9" y2="12" />
                                </svg>
                                Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        {{ $slot }}
    </main>
    <footer style="
        background: #1E6F5C ;
        border-top: 2px solid rgba(105,181,120,0.35);
        box-shadow: 0 -2px 20px rgba(0,0,0,0.25);
        padding: 20px 0 12px;
        margin-top: 40px;
        font-family: 'Segoe UI', system-ui, sans-serif;
    ">
        <div class="container">
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:18px;">

                {{-- Brand --}}
                <div style="display:flex;align-items:center;gap:10px;">
                    <div
                        style="width:34px;height:34px;background:rgba(255,255,255,0.12);border:1.5px solid rgba(105,181,120,0.45);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;padding:2px;">
                        <img src="{{ asset('images/logo-dice-v2.png') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                    <div>
                        <div style="color:#fff;font-weight:800;font-size:1rem;letter-spacing:-.01em;">Lúdika 's Store</div>
                        <div style="color:rgba(255,255,255,0.55);font-size:0.73rem;">Panel de gestión</div>
                    </div>
                </div>

                {{-- Links --}}
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    <a href="{{ route('products.index') }}" style="color:rgba(255,255,255,0.78);font-size:0.82rem;font-weight:600;text-decoration:none;
                               padding:5px 12px;border-radius:50px;border:1.5px solid rgba(255,255,255,0.18);
                               transition:background .2s;display:inline-flex;align-items:center;gap:5px;"
                        onmouseover="this.style.background='rgba(255,255,255,0.12)'"
                        onmouseout="this.style.background='transparent'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                            <line x1="3" y1="6" x2="21" y2="6" />
                        </svg>
                        Productos
                    </a>
                    <a href="{{ route('profile.edit') }}" style="color:rgba(255,255,255,0.78);font-size:0.82rem;font-weight:600;text-decoration:none;
                               padding:5px 12px;border-radius:50px;border:1.5px solid rgba(255,255,255,0.18);
                               transition:background .2s;display:inline-flex;align-items:center;gap:5px;"
                        onmouseover="this.style.background='rgba(255,255,255,0.12)'"
                        onmouseout="this.style.background='transparent'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        Mi Perfil
                    </a>
                    <a href="{{ route('home.admin') }}" style="color:rgba(255,255,255,0.78);font-size:0.82rem;font-weight:600;text-decoration:none;
                               padding:5px 12px;border-radius:50px;border:1.5px solid rgba(255,255,255,0.18);
                               transition:background .2s;display:inline-flex;align-items:center;gap:5px;"
                        onmouseover="this.style.background='rgba(255,255,255,0.12)'"
                        onmouseout="this.style.background='transparent'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1" />
                            <circle cx="20" cy="21" r="1" />
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                        </svg>
                        Tienda
                    </a>
                </div>

            </div>

            {{-- Divider --}}
            <div style="border-top:1px solid rgba(105,181,120,0.25);margin:18px 0 12px;"></div>

            {{-- Copyright --}}
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                <span style="color:rgba(255,255,255,0.48);font-size:0.76rem;">
                    &copy; {{ date('Y') }} Lúdika · Todos los derechos reservados
                </span>
                <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(201,162,39,0.15);
                             border:1.5px solid rgba(201,162,39,0.35);color:#C9A227;font-size:0.71rem;font-weight:700;
                             text-transform:uppercase;letter-spacing:.05em;padding:2px 10px;border-radius:50px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    Admin Panel
                </span>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>

    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>
    <!-- Slot para JS personalizado -->
    {{-- {{ $js ?? '' }} --}}
    @yield('js')
</body>

</html>
