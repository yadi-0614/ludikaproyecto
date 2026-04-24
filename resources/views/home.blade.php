@extends('layouts.app')

@section('content')

    @if(!$selected_category && !$search)
    {{-- ===== HERO SECTION (FLYER) ===== --}}
    <section class="hero-section">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            {{-- Indicators --}}
            <div class="carousel-indicators">
                @foreach($products->take(4) as $index => $heroProd)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" 
                        class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" 
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>

            <div class="carousel-inner">
                @foreach($products->take(4) as $index => $heroProd)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        @if($heroProd->hasImage())
                            <img src="{{ $heroProd->image_url }}" class="d-block w-100 hero-carousel-img" alt="{{ $heroProd->name }}">
                        @else
                            <div class="hero-carousel-img d-flex align-items-center justify-content-center" style="background: #1E6F5C ;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                        @endif
                        
                        <div class="hero-overlay"></div>
                        <div class="carousel-caption hero-content">
                            @if($index == 0)
                                <h1 class="hero-title">¡Hola, {{ Auth::user()->name }}!</h1>
                                <p class="hero-subtitle">Explora nuestra colección de juegos exclusivos.</p>
                            @else
                                <h1 class="hero-title">{{ $heroProd->name }}</h1>
                                <p class="hero-subtitle">{{ Str::limit($heroProd->description, 100) }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Controls --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </section>

    @endif

    {{-- ===== PRODUCTS SECTION ===== --}}
    <div class="container products-container" id="productos-grid">

        {{-- Section Header - Only visible on main home view --}}
        @if(!$selected_category && !$search)
        <div class="section-header">
            <h2 class="section-title">Nuestros Productos</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Encuentra lo que buscas entre nuestra selección</p>
        </div>
        @endif

        {{-- Search Bar --}}
        <div class="search-section">
            <form method="GET" action="{{ route('home') }}">
                <div class="search-bar">
                    <span class="search-bar__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="7" />
                            <line x1="16.5" y1="16.5" x2="22" y2="22" />
                        </svg>
                    </span>
                    <input type="text" name="search" id="search" class="search-bar__input"
                        placeholder="Buscar producto por nombre..." value="{{ $search }}" autocomplete="off">
                    @if($search)
                        <a href="{{ route('home') }}" class="search-bar__clear" title="Limpiar búsqueda">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </a>
                    @endif
                    <button type="submit" class="search-bar__btn">Buscar</button>
                </div>
                @if($search)
                    <p class="search-hint">
                        Resultados para: <strong>"{{ $search }}"</strong>
                        &mdash; <a href="{{ route('home') }}">Ver todos</a>
                    </p>
                @endif
            </form>
        </div>

        {{-- Products Grid --}}
        @if($products->count() > 0)
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
                @foreach($products as $product)
                    <div class="col">
                        <div class="product-card">
                            <div class="product-card__img-wrap">
                                @if($product->hasImage())
                                    <img src="{{ $product->image_url }}" class="product-card__img"
                                        alt="{{ $product->name }}">
                                @else
                                    <div class="product-card__img-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            stroke="#69B578" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                            <circle cx="8.5" cy="8.5" r="1.5" />
                                            <polyline points="21 15 16 10 5 21" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="product-card__badge">MXN ${{ number_format($product->price, 2) }}</div>
                            </div>

                            <div class="product-card__body">
                                <h5 class="product-card__title">{{ $product->name }}</h5>
                                <div class="product-card__rating">
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($product->rating))
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#C9A227" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="rating-text">{{ number_format($product->rating, 1) }} ({{ $product->reviews_count }} comentarios)</span>
                                </div>
                                <p class="product-card__desc">{{ Str::limit($product->description, 80) }}</p>
                                <div class="product-card__footer">
                                    <a href="{{ route('product.show', $product->id) }}"
                                        class="product-card__btn product-card__btn--solid">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round" style="margin-right:5px;">
                                            <circle cx="11" cy="11" r="8" />
                                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                        </svg>
                                        Ver producto
                                    </a>
                                    <button type="button" class="product-card__cart-btn" title="Añadir al carrito"
                                        onclick="addToCart({{ $product->id }}, this, '{{ addslashes($product->name) }}', {{ $product->price }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="9" cy="21" r="1" />
                                            <circle cx="20" cy="21" r="1" />
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>

        @else
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#69B578"
                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7" />
                    <line x1="16.5" y1="16.5" x2="22" y2="22" />
                </svg>
                @if($search)
                    <p>No se encontraron productos con el nombre <strong>"{{ $search }}"</strong>.</p>
                    <a href="{{ route('home') }}" class="empty-state__link">Ver todos los productos</a>
                @else
                    <p>No hay productos disponibles en este momento.</p>
                @endif
            </div>
        @endif

    </div>
@endsection

@push('styles')
    <style>
        :root {
            --verde-selva: #1E6F5C;
            --verde-hoja: #69B578;
            --beige-arena: #EAD8B1;
            --dorado: #C9A227;
            --negro-bosque: #2C2C2C;
            --text-dark: #2C2C2C;
            --text-muted: #6b7566;
            --bg-page: #f7f4ee;
            --radius-card: 14px;
            --shadow-card: 0 4px 20px rgba(30, 111, 92, 0.10);
            --shadow-hover: 0 10px 32px rgba(30, 111, 92, 0.20);
        }

        body {
            background-color: var(--bg-page);
        }

        /* HERO */
        .hero-section {
            position: relative;
            background: #0d1f18;
            padding: 0;
            text-align: center;
            overflow: hidden;
            min-height: 450px;
        }

        .hero-carousel-img {
            height: 450px;
            object-fit: cover;
            filter: brightness(0.7);
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(13, 31, 24, 0.4), rgba(13, 31, 24, 0.7));
            z-index: 1;
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 100%;
            padding: 0 20px;
            margin-bottom: 0 !important;
            bottom: auto !important;
        }

        .hero-title {
            font-size: 2.4rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.6rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            letter-spacing: -0.5px;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.88);
            margin-bottom: 0;
        }

        .hero-btn {
            display: inline-block;
            background: #fff;
            color: var(--verde-selva);
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .hero-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            color: var(--negro-bosque);
        }

        /* PRODUCTS */
        .products-container {
            padding-top: 56px;
            padding-bottom: 60px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .section-title {
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .section-divider {
            width: 56px;
            height: 4px;
            background: #1E6F5C ;
            border-radius: 4px;
            margin: 0.5rem auto 0.9rem;
        }

        .section-subtitle {
            color: var(--text-muted);
            font-size: 0.97rem;
        }

        /* SEARCH */
        .search-section {
            max-width: 580px;
            margin: 0 auto 2.5rem;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: #fff;
            border: 2px solid var(--verde-hoja);
            border-radius: 50px;
            padding: 0.3rem 0.3rem 0.3rem 1.1rem;
            box-shadow: 0 4px 18px rgba(30, 111, 92, 0.10);
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .search-bar:focus-within {
            border-color: var(--verde-selva);
            box-shadow: 0 4px 22px rgba(30, 111, 92, 0.20);
        }

        .search-bar__icon {
            color: var(--verde-selva);
            display: flex;
            align-items: center;
            flex-shrink: 0;
            margin-right: 0.5rem;
        }

        .search-bar__input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 0.95rem;
            background: transparent;
            color: var(--text-dark);
            min-width: 0;
        }

        .search-bar__input::placeholder {
            color: #bbb;
        }

        .search-bar__clear {
            color: var(--verde-hoja);
            display: flex;
            align-items: center;
            padding: 0 0.5rem;
            text-decoration: none;
            transition: color 0.2s;
            flex-shrink: 0;
        }

        .search-bar__clear:hover {
            color: var(--verde-selva);
        }

        .search-bar__btn {
            background: #1E6F5C ;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.6rem 1.4rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            flex-shrink: 0;
        }

        .search-bar__btn:hover {
            opacity: 0.9;
            transform: scale(1.03);
        }

        .category-pills {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 1.2rem;
        }

        .category-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.5rem 1.1rem;
            background: #fff;
            color: var(--text-muted);
            border: 1.5px solid #eee;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.25s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .category-pill:hover {
            border-color: var(--verde-hoja);
            color: var(--verde-selva);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30,111,92,0.12);
        }

        .category-pill.active {
            background: var(--verde-selva);
            color: #fff;
            border-color: var(--verde-selva);
            box-shadow: 0 4px 14px rgba(30,111,92,0.3);
        }

        .category-count {
            font-size: 0.7rem;
            background: rgba(0,0,0,0.06);
            padding: 1px 6px;
            border-radius: 10px;
            color: inherit;
            opacity: 0.8;
        }

        .search-hint {
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 0.6rem;
        }

        .search-hint a {
            color: var(--verde-selva);
            text-decoration: none;
            font-weight: 500;
        }

        .search-hint a:hover {
            text-decoration: underline;
        }

        /* PRODUCT CARD */
        .product-card {
            background: #fff;
            border-radius: var(--radius-card);
            overflow: hidden;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(105, 181, 120, 0.25);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover);
            border-color: var(--verde-hoja);
        }

        .product-card__img-wrap {
            position: relative;
            overflow: hidden;
        }

        .product-card__img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-card__img {
            transform: scale(1.06);
        }

        .product-card__img-placeholder {
            width: 100%;
            height: 180px;
            background: #FAF6ED ;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-card__badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: #1E6F5C ;
            color: #fff;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 0.25rem 0.65rem;
            border-radius: 50px;
            box-shadow: 0 2px 8px rgba(30, 111, 92, 0.3);
        }

        .product-card__body {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .product-card__title {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.35rem;
            line-height: 1.3;
        }

        .product-card__rating {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 0.5rem;
        }

        .product-card__rating .stars {
            display: flex;
            gap: 2px;
        }

        .product-card__rating .rating-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .product-card__desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.5;
            flex: 1;
            margin-bottom: 0.75rem;
        }

        .product-card__footer {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            margin-top: auto;
        }

        .product-card__btn {
            flex: 1;
            display: block;
            text-align: center;
            padding: 0.5rem 0;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .product-card__btn--solid {
            background: #C9A227;
            color: #fff;
            border: 2px solid transparent;
        }

        .product-card__btn--solid:hover {
            opacity: 0.88;
            color: #fff;
            transform: scale(1.02);
        }

        .product-card__cart-btn {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #eef6ef;
            border: 2px solid var(--verde-hoja);
            color: var(--verde-selva);
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 0;
        }

        .product-card__cart-btn:hover {
            background: var(--verde-selva);
            border-color: var(--verde-selva);
            color: #fff;
            transform: scale(1.12);
        }

        .product-card__cart-btn.cart-added {
            background: var(--negro-bosque);
            border-color: var(--negro-bosque);
            color: #fff;
        }

        .product-card__cart-btn:disabled {
            opacity: 0.7;
            cursor: wait;
        }

        /* PAGINATION */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        .pagination {
            gap: 0.4rem;
            margin-bottom: 0;
        }

        .pagination .page-item {
            margin: 0;
        }

        .pagination .page-link {
            color: var(--verde-selva);
            background: #fff;
            border: 1.5px solid var(--verde-hoja);
            padding: 0.55rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            min-width: 42px;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            box-shadow: 0 1px 4px rgba(30, 111, 92, 0.08);
        }

        .pagination .page-link:hover {
            background: var(--verde-selva);
            border-color: var(--verde-selva);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 111, 92, 0.28);
        }

        .pagination .page-item.active .page-link {
            background: #1E6F5C ;
            border-color: var(--negro-bosque);
            color: #fff;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(30, 111, 92, 0.35);
            transform: translateY(-1px);
        }

        .pagination .page-item.disabled .page-link {
            color: #ccc;
            background: #fafafa;
            border-color: #eee;
            box-shadow: none;
            cursor: not-allowed;
        }

        .pagination .page-item.disabled .page-link:hover {
            transform: none;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            color: var(--text-muted);
        }

        .empty-state svg {
            margin-bottom: 1.2rem;
            opacity: 0.7;
        }

        .empty-state p {
            font-size: 1rem;
            margin-bottom: 0.75rem;
        }

        .empty-state__link {
            color: var(--verde-selva);
            font-weight: 600;
            text-decoration: none;
        }

        .empty-state__link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 1.7rem;
            }

            .hero-section {
                padding: 50px 0 40px;
            }

            .product-card__img,
            .product-card__img-placeholder {
                height: 150px;
            }
        }

    </style>
@endpush

