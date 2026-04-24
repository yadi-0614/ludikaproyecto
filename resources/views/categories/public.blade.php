@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="section-header mb-5 text-center">
        <h1 class="section-title text-uppercase" style="font-weight: 800; letter-spacing: -0.02em; color: var(--verde-selva);">Nuestras Categorías</h1>
        <div class="section-divider mx-auto" style="width: 60px; height: 4px; background: #C9A227; border-radius: 10px; margin: 15px auto;"></div>
        <p class="section-subtitle mx-auto" style="max-width: 600px; color: #6b7566; font-size: 1.05rem;">
            Explora nuestra amplia variedad de juegos organizados por categorías para que encuentres exactamente la diversión que buscas.
        </p>
    </div>

    {{-- Category Search Bar --}}
    <div class="search-section mb-5" style="max-width: 500px; margin: 0 auto;">
        <form method="GET" action="{{ route('categories.public') }}">
            <div class="search-bar">
                <span class="search-bar__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="7" />
                        <line x1="16.5" y1="16.5" x2="22" y2="22" />
                    </svg>
                </span>
                <input type="text" name="search" id="cat-search" class="search-bar__input"
                    placeholder="Buscar una categoría..." value="{{ $search }}" autocomplete="off">
                @if($search)
                    <a href="{{ route('categories.public') }}" class="search-bar__clear" title="Limpiar búsqueda">
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
                <p class="search-hint text-center mt-2">
                    Resultados para: <strong>"{{ $search }}"</strong>
                    &mdash; <a href="{{ route('categories.public') }}">Ver todas</a>
                </p>
            @endif
        </form>
    </div>

    @if($categories->count() > 0)
        @foreach($categories as $cat)
        @if($cat->products->count() > 0)
                <div class="category-group mb-5 pb-4 border-bottom" style="border-bottom-style: dashed !important; border-bottom-color: #d6ead8 !important; border-bottom-width: 2px !important;">
                <div class="category-group__header d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-baseline gap-3">
                        <h3 class="category-group__title m-0">{{ $cat->name }}</h3>
                        <span class="category-group__badge">{{ $cat->products->count() }} {{ $cat->products->count() == 1 ? 'juego' : 'juegos' }}</span>
                    </div>
                    <a href="{{ route('welcome', ['category' => $cat->id]) }}" class="category-link">Ver todo</a>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
                    @foreach($cat->products as $product)
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
                                        <span class="rating-text">{{ number_format($product->rating, 1) }}</span>
                                    </div>
                                    <p class="product-card__desc">{{ Str::limit($product->description, 60) }}</p>
                                    <div class="product-card__footer">
                                        <a href="{{ route('product.show', $product->id) }}"
                                            class="product-card__btn product-card__btn--solid">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round" style="margin-right:5px;">
                                                <circle cx="11" cy="11" r="8" />
                                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                            </svg>
                                            Ver
                                        </a>
                                        @auth
                                            <button type="button" class="product-card__cart-btn" title="Añadir al carrito"
                                                onclick="addToCart({{ $product->id }}, this, '{{ addslashes($product->name) }}', {{ $product->price }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <circle cx="9" cy="21" r="1" />
                                                    <circle cx="20" cy="21" r="1" />
                                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                                                </svg>
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}" class="product-card__cart-btn" title="Inicia sesión para agregar al carrito">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <circle cx="9" cy="21" r="1" />
                                                    <circle cx="20" cy="21" r="1" />
                                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                                                </svg>
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
    @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#69B578"
                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7" />
                <line x1="16.5" y1="16.5" x2="22" y2="22" />
            </svg>
            @if($search)
                <p>No se encontraron categorías con el nombre <strong>"{{ $search }}"</strong>.</p>
                <a href="{{ route('categories.public') }}" class="empty-state__link">Ver todo el catálogo</a>
            @else
                <p>No hay categorías disponibles en este momento.</p>
            @endif
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Estilos sincronizados con home.blade.php */
    :root {
        --verde-selva: #1E6F5C;
        --verde-hoja: #69B578;
        --beige-arena: #EAD8B1;
        --dorado: #C9A227;
        --negro-bosque: #2C2C2C;
        --radius-card: 14px;
        --shadow-card: 0 4px 20px rgba(30, 111, 92, 0.10);
        --shadow-hover: 0 10px 32px rgba(30, 111, 92, 0.20);
    }

    /* SEARCH STYLES FROM HOME */
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
        color: var(--negro-bosque);
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

    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        color: #6b7566;
    }

    .empty-state svg {
        margin-bottom: 1.2rem;
        opacity: 0.7;
    }

    .empty-state__link {
        color: var(--verde-selva);
        font-weight: 600;
        text-decoration: none;
    }

    .empty-state__link:hover {
        text-decoration: underline;
    }

    .category-group__title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--verde-selva);
        border-left: 5px solid var(--verde-hoja);
        padding-left: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .category-group__badge {
        font-size: 0.82rem;
        background: #eef6ef;
        color: var(--verde-selva);
        padding: 4px 12px;
        border-radius: 50px;
        font-weight: 700;
        border: 1px solid #d6ead8;
    }

    .category-link {
        color: var(--verde-hoja);
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        transition: color 0.2s;
    }

    .category-link:hover {
        color: var(--verde-selva);
        text-decoration: underline;
    }

    /* Product Card Re-styling for categories page */
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
        height: 160px;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-card__img {
        transform: scale(1.06);
    }

    .product-card__img-placeholder {
        width: 100%;
        height: 160px;
        background: #f7faf7;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-card__badge {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: #1E6F5C ;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.2rem 0.6rem;
        border-radius: 50px;
    }

    .product-card__body {
        padding: 0.85rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .product-card__title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #2C2C2C;
        margin-bottom: 0.25rem;
        line-height: 1.3;
    }

    .product-card__rating {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 0.4rem;
    }

    .product-card__rating .rating-text {
        font-size: 0.7rem;
        color: #6b7566;
        font-weight: 600;
    }

    .product-card__desc {
        font-size: 0.78rem;
        color: #6b7566;
        line-height: 1.4;
        flex: 1;
        margin-bottom: 0.6rem;
    }

    .product-card__footer {
        display: flex;
        gap: 0.4rem;
        align-items: center;
        margin-top: auto;
    }

    .product-card__btn {
        flex: 1;
        display: block;
        text-align: center;
        padding: 0.4rem 0;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .product-card__btn--solid {
        background: #1E6F5C ;
        color: #fff;
    }

    .product-card__cart-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #eef6ef;
        border: 1.5px solid var(--verde-hoja);
        color: var(--verde-selva);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.2s;
    }

    .product-card__cart-btn:hover {
        background: var(--verde-selva);
        border-color: var(--verde-selva);
        color: #fff;
        transform: scale(1.1);
    }

    .section-header { text-align: center; }
    .section-title { font-size: 1.85rem; font-weight: 700; color: #2C2C2C; margin-bottom: 0.5rem; }
    .section-divider { width: 56px; height: 4px; background: #C9A227; border-radius: 4px; margin: 0.5rem auto 0.9rem; }
    .section-subtitle { color: #6b7566; font-size: 0.97rem; }
</style>
@endpush
