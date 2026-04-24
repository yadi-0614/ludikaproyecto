@extends('layouts.app')

@push('styles')
    <style>
        :root {
            --verde-selva: #1E6F5C;
            --verde-lima: #69B578;
            --negro-bosque: #0d1f18;
            --text-muted: #666;
            --white: #ffffff;
            --bg-page: #f7f4ee;
        }

        body {
            background-color: var(--bg-page);
        }

        /* HERO SECTION */
        .hero-section {
            background: #1E6F5C ;
            padding: 80px 0 60px;
            color: #fff;
            position: relative;
            text-align: center;
            border-bottom: 2px solid rgba(105, 181, 120, 0.3);
            margin-bottom: 40px;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(30, 111, 92, 0.2) 0%, rgba(13, 31, 24, 0.4) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 2.6rem;
            font-weight: 900;
            margin-bottom: 0.8rem;
            letter-spacing: -0.5px;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        }

        .hero-subtitle {
            font-size: 1.15rem;
            opacity: 0.95;
            max-width: 650px;
            margin: 0 auto;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            font-weight: 500;
        }

        .hero-btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.88rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .hero-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            opacity: 0.95;
        }

        /* SECTION HEADERS */
        .section-header {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--negro-bosque);
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .section-divider {
            width: 80px;
            height: 4px;
            background: #1E6F5C ;
            margin: 0.8rem auto 1.2rem;
            border-radius: 20px;
        }

        .section-subtitle {
            font-size: 0.95rem;
            color: var(--text-muted);
            max-width: 500px;
            margin: 0 auto;
            font-weight: 500;
        }

        /* SEARCH BAR */
        .search-section {
            margin-bottom: 3rem;
            max-width: 850px;
            margin-left: auto;
            margin-right: auto;
        }

        .search-bar {
            display: flex;
            background: #fff;
            padding: 4px;
            border-radius: 50px;
            box-shadow: 0 4px 20px rgba(30, 111, 92, 0.12);
            border: 1.5px solid #eef6ef;
            transition: all 0.3s ease;
            position: relative;
        }

        .search-bar:focus-within {
            border-color: var(--verde-lima);
            box-shadow: 0 6px 25px rgba(30, 111, 92, 0.22);
        }

        .search-bar__icon {
            padding: 0 16px;
            display: flex;
            align-items: center;
            color: #999;
        }

        .search-bar__input {
            flex: 1;
            border: none;
            padding: 10px 0;
            outline: none;
            font-size: 0.95rem;
            font-weight: 500;
            color: #333;
            background-color: transparent;
        }

        .search-bar__clear {
            padding: 0 12px;
            display: flex;
            align-items: center;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }

        .search-bar__clear:hover {
            color: #999;
        }

        .search-bar__btn {
            background: #1E6F5C ;
            color: #fff;
            border: none;
            padding: 10px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .search-bar__btn:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        /* PRODUCT CARDS */
        .product-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #f1f4f1;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(30, 111, 92, 0.18);
            border-color: #e5ede5;
        }

        .product-card__img-wrap {
            position: relative;
            overflow: hidden;
            background: #f8faf8;
        }

        .product-card__img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .product-card:hover .product-card__img {
            transform: scale(1.08);
        }

        .product-card__img-placeholder {
            width: 100%;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f4f0;
        }

        .product-card__badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.95);
            color: var(--verde-selva);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(4px);
            border: 1.5px solid var(--verde-lima);
        }

        .product-card__body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-card__title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--negro-bosque);
            margin-bottom: 0.6rem;
            line-height: 1.3;
            min-height: 2.6rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-card__rating {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 0.8rem;
        }

        .stars {
            display: flex;
            color: #C9A227;
        }

        .rating-text {
            font-size: 0.72rem;
            color: #888;
            font-weight: 500;
        }

        .product-card__desc {
            font-size: 0.84rem;
            color: #666;
            line-height: 1.5;
            margin-bottom: 1.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-card__footer {
            margin-top: auto;
            display: flex;
            gap: 8px;
        }

        .product-card__btn {
            flex: 1;
            padding: 9px 0;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-card__btn--solid {
            background-color: #C9A227;
            color: #fff;
            border: none;
        }

        .product-card__btn--solid:hover {
            background-color: var(--negro-bosque);
            transform: translateY(-1px);
        }

        /* PAGINATION */
        .pagination-wrapper {
            margin-top: 4rem;
            display: flex;
            justify-content: center;
        }

        .pagination .page-link {
            border-radius: 12px;
            margin: 0 4px;
            padding: 10px 18px;
            color: var(--verde-selva);
            border: 1.5px solid #eef6ef;
            font-weight: 600;
            transition: all 0.2s;
        }

        .pagination .page-link:hover {
            background: var(--verde-selva);
            border-color: var(--verde-selva);
            color: #fff;
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background: #1E6F5C ;
            border-color: var(--negro-bosque);
            color: #fff;
            font-weight: 700;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            color: var(--text-muted);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 1.7rem;
            }
            .hero-section {
                padding: 50px 0 40px;
            }
            .product-card__img, .product-card__img-placeholder {
                height: 150px;
            }
        }
    </style>
@endpush

@section('content')

    @if(!$selected_category && !$search)
    {{-- ===== HERO SECTION ===== --}}
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1 class="hero-title">¡Hola, {{ Auth::user()->name }}!</h1>
            <p class="hero-subtitle">Explora nuestra colección de productos exclusivos.</p>
            <div style="margin-top: 1.5rem; display:flex; gap:0.75rem; justify-content:center; flex-wrap:wrap;">
                <a href="#productos-grid" class="hero-btn"
                    style="background: #1E6F5C ; color: #fff; border: none; display:inline-flex; align-items:center; gap:6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" /><rect x="14" y="3" width="7" height="7" /><rect x="14" y="14" width="7" height="7" /><rect x="3" y="14" width="7" height="7" /></svg>
                    Ver productos
                </a>
                <a href="{{ route('products.index') }}" class="hero-btn"
                    style="background: #1E6F5C ; color: #fff; border: none; display:inline-flex; align-items:center; gap:6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" /><line x1="3" y1="6" x2="21" y2="6" /><path d="M16 10a4 4 0 0 1-8 0" /></svg>
                    Ver tabla de productos
                </a>
                <a href="{{ route('users.index') }}" class="hero-btn"
                    style="background: linear-gradient(135deg, #C9A227, #d4a017); color: #fff; border: none; display:inline-flex; align-items:center; gap:6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M23 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /></svg>
                    Gestión de usuarios
                </a>
                <a href="{{ route('admin.orders.index') }}" class="hero-btn"
                    style="background: linear-gradient(135deg, #1d4ed8, #1e3a8a); color: #fff; border: none; display:inline-flex; align-items:center; gap:6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                    Gestión de pedidos
                </a>
            </div>
        </div>
    </section>
    @endif

    <div class="container products-container" id="productos-grid">
        @if(!$selected_category && !$search)
        <div class="section-header">
            <h2 class="section-title">Nuestros Productos</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Encuentra lo que buscas entre nuestra selección</p>
        </div>
        @endif

        <div class="search-section">
            <form method="GET" action="{{ route('home') }}">
                <div class="search-bar">
                    <span class="search-bar__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7" /><line x1="16.5" y1="16.5" x2="22" y2="22" /></svg>
                    </span>
                    <input type="text" name="search" id="search" class="search-bar__input" placeholder="Buscar producto por nombre..." value="{{ $search }}" autocomplete="off">
                    @if($search)
                        <a href="{{ route('home') }}" class="search-bar__clear">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
                        </a>
                    @endif
                    <button type="submit" class="search-bar__btn">Buscar</button>
                </div>
            </form>
        </div>

        @if($products->count() > 0)
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
                @foreach($products as $product)
                    <div class="col">
                        <div class="product-card">
                            <div class="product-card__img-wrap">
                                @if($product->hasImage())
                                    <img src="{{ $product->image_url }}" class="product-card__img" alt="{{ $product->name }}">
                                @else
                                    <div class="product-card__img-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#69B578" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2" /><circle cx="8.5" cy="8.5" r="1.5" /><polyline points="21 15 16 10 5 21" /></svg>
                                    </div>
                                @endif
                                <div class="product-card__badge">MXN ${{ number_format($product->price, 2) }}</div>
                            </div>
                            <div class="product-card__body">
                                <h5 class="product-card__title">{{ $product->name }}</h5>
                                <div class="product-card__rating">
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="{{ $i <= round($product->rating) ? '#C9A227' : 'none' }}" stroke="{{ $i <= round($product->rating) ? '#C9A227' : '#ddd' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        @endfor
                                    </div>
                                    <span class="rating-text">{{ number_format($product->rating, 1) }}</span>
                                </div>
                                <p class="product-card__desc">{{ Str::limit($product->description, 60) }}</p>
                                <div class="product-card__footer">
                                    <a href="{{ route('product.show', $product->id) }}" class="product-card__btn product-card__btn--solid">Ver producto</a>
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
                <p>No se encontraron productos.</p>
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Animación suave de carga
            $('.product-card').each(function(i) {
                $(this).delay(100 * i).animate({opacity: 1}, 500);
            });
        });
    </script>
@endpush
