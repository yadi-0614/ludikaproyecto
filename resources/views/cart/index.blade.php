@extends('layouts.app')

@section('content')

    {{-- ===== HERO ===== --}}
    <section class="cart-hero">
        <div class="container">
            <div class="cart-hero__inner">
                <div class="cart-hero__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>
                </div>
                <div>
                    <h1 class="cart-hero__title">Mi Carrito</h1>
                    <p class="cart-hero__sub">Revisa y gestiona tus productos seleccionados</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container cart-page">

        {{-- Flash success --}}
        @if(session('success'))
            <div class="cart-alert cart-alert--success">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="cart-alert cart-alert--error">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <circle cx="12" cy="16" r="1" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if(count($items) > 0)
            
            <div class="cart-layout">

                {{-- ===== PRODUCTS TABLE ===== --}}
                <div class="cart-table-wrap">

                    <div class="cart-table-header">
                        <h2 class="cart-table-title">
                            Productos
                            <span class="cart-count-pill" id="total-items-count">{{ array_sum(array_column($items, 'qty')) }}</span>
                        </h2>
                        <button id="btn-clear-cart" class="btn-clear">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6l-1 14H6L5 6" />
                                <path d="M10 11v6M14 11v6" />
                                <path d="M9 6V4h6v2" />
                            </svg>
                            Vaciar carrito
                        </button>
                    </div>

                    <div class="cart-items" id="cart-items-container">
                        @foreach($items as $item)
                            <div class="cart-item" id="cart-item-{{ $item['id'] }}" data-id="{{ $item['id'] }}">

                                {{-- Image --}}
                                <div class="cart-item__img-wrap">
                                    @if(!empty($item['image']) && \App\Services\FileService::resolveExistingPath($item['image']))
                                        <img src="{{ \App\Services\FileService::publicUrl($item['image']) }}"
                                             alt="{{ $item['name'] }}" class="cart-item__img">
                                    @else
                                        <div class="cart-item__img-placeholder">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                                fill="none" stroke="#69B578" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                                <circle cx="8.5" cy="8.5" r="1.5" />
                                                <polyline points="21 15 16 10 5 21" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="cart-item__info">
                                    <p class="cart-item__name">{{ $item['name'] }}</p>
                                    <div class="cart-item__meta">
                                        <p class="cart-item__price">MXN ${{ number_format($item['price'], 2) }} c/u</p>
                                        @if(!$item['is_available'])
                                            <span class="stock-badge stock-badge--out">Agotado</span>
                                        @elseif(!$item['has_stock'])
                                            <span class="stock-badge stock-badge--low">Stock insuficiente (Disponible: {{ $item['stock'] }})</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Qty controls --}}
                                <div class="cart-item__qty">
                                    <button class="qty-btn qty-btn--minus" onclick="changeQtyDelta({{ $item['id'] }}, -1)" title="Reducir">−</button>
                                    <input
                                        type="number"
                                        class="qty-input"
                                        id="qty-{{ $item['id'] }}"
                                        value="{{ $item['qty'] }}"
                                        min="1" max="99"
                                        onchange="setQty({{ $item['id'] }}, this.value)"
                                        onkeydown="if(event.key==='Enter'){this.blur();}"
                                    >
                                    <button class="qty-btn qty-btn--plus" onclick="changeQtyDelta({{ $item['id'] }}, 1)" title="Aumentar">+</button>
                                </div>

                                {{-- Subtotal --}}
                                <div class="cart-item__subtotal" id="subtotal-{{ $item['id'] }}">
                                    MXN ${{ number_format($item['subtotal'], 2) }}
                                </div>

                                {{-- Remove --}}
                                <button class="cart-item__remove" onclick="removeItem({{ $item['id'] }})" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18" />
                                        <line x1="6" y1="6" x2="18" y2="18" />
                                    </svg>
                                </button>

                            </div>
                        @endforeach
                    </div>

                    <div class="cart-back">
                        <a href="{{ route('home') }}" class="btn-back">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12" />
                                <polyline points="12 19 5 12 12 5" />
                            </svg>
                            Seguir comprando
                        </a>
                    </div>

                </div>

                {{-- ===== ORDER SUMMARY ===== --}}
                <div class="cart-summary" id="cart-summary">
                    <h3 class="cart-summary__title">Resumen del pedido</h3>

                    <div class="cart-summary__row">
                        <span>Subtotal</span>
                        <span id="summary-subtotal">MXN ${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="cart-summary__row">
                        <span>Envío</span>
                        <span class="cart-summary__free">Gratis</span>
                    </div>
                    <div class="cart-summary__divider"></div>
                    <div class="cart-summary__row cart-summary__row--total">
                        <span>Total</span>
                        <span id="summary-total">MXN ${{ number_format($total, 2) }}</span>
                    </div>

                    @php
                        $hasStockIssues = collect($items)->contains(fn($i) => !$i['has_stock']);
                    @endphp

                    @php
                        $missingProfile = [];
                        if (empty(Auth::user()->phone))   $missingProfile[] = 'teléfono';
                        if (empty(Auth::user()->address)) $missingProfile[] = 'dirección';
                    @endphp

                    @if(!empty($missingProfile))
                        <div style="margin: 16px 0; padding: 14px 16px; background: #fffbeb; border: 1.5px solid #f59e0b; border-radius: 12px; display: flex; gap: 12px; align-items: flex-start;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                            </svg>
                            <div>
                                <p style="font-size:0.85rem;font-weight:700;color:#92400e;margin:0 0 4px;">Completa tu perfil para poder comprar</p>
                                <p style="font-size:0.82rem;color:#78350f;margin:0 0 10px;">
                                    Necesitas agregar tu <strong>{{ implode(' y ', $missingProfile) }}</strong> antes de finalizar la compra.
                                </p>
                                <a href="{{ route('profile.edit') }}" style="display:inline-flex;align-items:center;gap:6px;background: #f59e0b ;color:#fff;font-size:0.82rem;font-weight:700;padding:7px 14px;border-radius:50px;text-decoration:none;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    Ir a mi perfil
                                </a>
                            </div>
                        </div>
                    @endif

                    <form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <div class="payment-methods">
                            <p class="payment-methods__title">Metodo de pago</p>
                            <label class="payment-method">
                                <input type="radio" name="payment_provider" value="stripe" {{ old('payment_provider', 'stripe') === 'stripe' ? 'checked' : '' }}>
                                <span>Stripe</span>
                            </label>
                            <label class="payment-method">
                                <input type="radio" name="payment_provider" value="paypal" {{ old('payment_provider') === 'paypal' ? 'checked' : '' }}>
                                <span>PayPal</span>
                            </label>

                            {{-- Audio Instructions --}}
                            <div class="audio-instructions-wrapper">
                                <p class="audio-instructions-text">
                                    ¿No sabes cómo pagar?
                                    <span class="audio-controls">
                                        <button type="button" class="audio-btn" id="play-audio-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                                <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                                            </svg>
                                            haz click aquí
                                        </button>
                                        <button type="button" class="audio-rewind" id="rewind-audio-btn" title="Retroceder 10 segundos">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/>
                                            </svg>
                                            <span>-10s</span>
                                        </button>
                                    </span>
                                </p>
                                <audio id="payment-audio" src="{{ asset('audio/instruccion.mp3') }}"></audio>
                            </div>
                            @error('payment_provider')
                                <p class="payment-methods__error">{{ $message }}</p>
                            @enderror
                        </div>

                        @if($hasStockIssues)
                            <div class="stock-error-notice">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><circle cx="12" cy="16" r="1"/></svg>
                                Algunos productos no tienen stock suficiente.
                            </div>
                        @endif

                        <button type="submit" class="btn-checkout" id="btn-checkout" {{ $hasStockIssues ? 'disabled' : '' }} title="{{ $hasStockIssues ? 'Corrige los productos sin stock antes de continuar' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                            Finalizar compra
                        </button>
                    </form>

                    <p class="cart-summary__note">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="#aaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        Pago seguro y encriptado
                    </p>
                </div>

            </div>

        @else

            {{-- ===== EMPTY STATE ===== --}}
            <div class="cart-empty" id="cart-empty-state">
                <div class="cart-empty__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none"
                        stroke="#69B578" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>
                </div>
                <h3 class="cart-empty__title">Tu carrito está vacío</h3>
                <p class="cart-empty__sub">Explora nuestro catálogo y agrega productos que te gusten.</p>
                <a href="{{ route('home') }}" class="btn-checkout" style="display:inline-flex;text-decoration:none;max-width:240px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Ir a la tienda
                </a>
            </div>

        @endif

    </div>

@endsection

@push('styles')
<style>
    :root {
        --verde-selva:  #1E6F5C;
        --verde-hoja:   #69B578;
        --dorado:       #C9A227;
        --negro-bosque: #2C2C2C;
        --beige-arena:  #EAD8B1;
        --bg-page:      #FAF6ED;
        --radius:       14px;
        --shadow:       0 4px 20px rgba(30, 111, 92, 0.08);
    }

    body { background: var(--bg-page); }

    /* HERO */
    .cart-hero {
        background: var(--verde-selva);
        padding: 44px 0 36px;
        border-bottom: 3px solid var(--dorado);
    }
    .cart-hero__inner {
        display: flex;
        align-items: center;
        gap: 18px;
    }
    .cart-hero__icon {
        width: 52px; height: 52px;
        background: var(--dorado);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 16px rgba(201, 162, 39, .45);
        flex-shrink: 0;
    }
    .cart-hero__title {
        font-size: 1.7rem;
        font-weight: 800;
        color: #fff;
        margin: 0 0 2px;
    }
    .cart-hero__sub {
        font-size: .9rem;
        color: rgba(255, 255, 255, .7);
        margin: 0;
    }

    /* ALERT */
    .cart-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 18px;
        border-radius: 10px;
        font-size: .93rem;
        font-weight: 500;
        margin: 22px 0 0;
    }
    .cart-alert--success {
        background: #f0fff6;
        border: 1.5px solid #62d890;
        color: #1a6636;
    }
    .cart-alert--error {
        background: #fff4f4;
        border: 1.5px solid #f1a5a5;
        color: #9f2e2e;
    }

    /* PAGE LAYOUT */
    .cart-page { padding-top: 32px; padding-bottom: 60px; }

    .cart-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 28px;
        align-items: start;
    }

    @media (max-width: 860px) {
        .cart-layout { grid-template-columns: 1fr; }
    }

    /* TABLE WRAP */
    .cart-table-wrap {
        background: #fff;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid rgba(105, 181, 120, .2);
        overflow: hidden;
    }

    .cart-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 22px 14px;
        border-bottom: 1.5px solid #d6ead8;
    }

    .cart-table-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #2C2C2C;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cart-count-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 24px;
        height: 24px;
        background: var(--dorado);
        color: var(--negro-bosque);
        font-size: .75rem;
        font-weight: 800;
        border-radius: 50px;
        padding: 0 7px;
    }

    .btn-clear {
        display: flex;
        align-items: center;
        gap: 6px;
        background: none;
        border: 1.5px solid #FFD0D0;
        color: #c0392b;
        font-size: .8rem;
        font-weight: 600;
        border-radius: 50px;
        padding: 6px 14px;
        cursor: pointer;
        transition: background .2s, border-color .2s;
    }
    .btn-clear:hover {
        background: #FFF5F5;
        border-color: #c0392b;
    }

    /* CART ITEM */
    .cart-items { padding: 8px 0; }

    .cart-item {
        display: grid;
        grid-template-columns: 70px 1fr auto auto auto;
        align-items: center;
        gap: 14px;
        padding: 14px 22px;
        border-bottom: 1px solid #eef6ef;
        transition: background .2s;
    }
    .cart-item:last-child { border-bottom: none; }
    .cart-item:hover { background: #f7faf7; }

    .cart-item__img-wrap {
        width: 70px; height: 70px;
        border-radius: 10px;
        overflow: hidden;
        border: 1.5px solid #d6ead8;
        flex-shrink: 0;
    }
    .cart-item__img {
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .cart-item__img-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        background: #FAF6ED ;
    }

    .cart-item__info { min-width: 0; }
    .cart-item__name {
        font-size: .9rem;
        font-weight: 700;
        color: #2C2C2C;
        margin: 0 0 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cart-item__price {
        font-size: .8rem;
        color: #999;
        margin: 0;
    }

    /* QTY */
    .cart-item__qty {
        display: flex;
        align-items: center;
        gap: 0;
        border: 1.5px solid #b5d9bc;
        border-radius: 50px;
        overflow: hidden;
    }
    .qty-btn {
        width: 32px; height: 34px;
        background: none;
        border: none;
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--negro-bosque);
        cursor: pointer;
        transition: background .15s;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .qty-btn:hover { background: #eef6ef; }
    .qty-input {
        width: 44px;
        height: 34px;
        text-align: center;
        font-size: .9rem;
        font-weight: 700;
        color: #2C2C2C;
        border: none;
        outline: none;
        background: #fff;
        -moz-appearance: textfield;
        padding: 0;
    }
    .qty-input::-webkit-inner-spin-button,
    .qty-input::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    .qty-input:focus { background: #eef6ef; }

    /* SUBTOTAL */
    .cart-item__subtotal {
        font-size: .92rem;
        font-weight: 700;
        color: var(--verde-selva);
        min-width: 72px;
        text-align: right;
    }

    /* REMOVE */
    .cart-item__remove {
        display: flex; align-items: center; justify-content: center;
        width: 30px; height: 30px;
        background: none;
        border: 1.5px solid #FFD0D0;
        border-radius: 50%;
        color: #e74c3c;
        cursor: pointer;
        transition: background .2s, border-color .2s;
    }
    .cart-item__remove:hover {
        background: #FFF5F5;
        border-color: #c0392b;
    }

    /* BACK */
    .cart-back {
        padding: 16px 22px;
        border-top: 1.5px solid #eef6ef;
    }
    .btn-back {
        display: inline-flex; align-items: center; gap: 7px;
        color: var(--verde-selva);
        font-size: .88rem;
        font-weight: 600;
        text-decoration: none;
        transition: gap .2s;
    }
    .btn-back:hover { gap: 11px; color: var(--negro-bosque); }

    /* SUMMARY */
    .cart-summary {
        background: #fff;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid rgba(105, 181, 120, .2);
        padding: 22px;
        position: sticky;
        top: 84px;
    }
    .cart-summary__title {
        font-size: 1rem;
        font-weight: 700;
        color: #2C2C2C;
        margin: 0 0 18px;
    }
    .cart-summary__row {
        display: flex;
        justify-content: space-between;
        font-size: .9rem;
        color: #555;
        margin-bottom: 11px;
    }
    .cart-summary__row--total {
        font-size: 1.05rem;
        font-weight: 700;
        color: #2C2C2C;
        margin-bottom: 0;
    }
    .cart-summary__row--total span:last-child { color: var(--verde-selva); font-size: 1.15rem; }
    .cart-summary__free { color: #27ae60; font-weight: 600; }
    .cart-summary__divider {
        border-top: 1.5px solid #d6ead8;
        margin: 14px 0;
    }

    .payment-methods {
        margin-top: 8px;
        display: grid;
        gap: 8px;
    }
    .payment-methods__title {
        margin: 0 0 2px;
        font-size: .8rem;
        font-weight: 700;
        color: #2C2C2C;
    }
    .payment-method {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .86rem;
        color: #444;
        border: 1px solid #dcebdd;
        border-radius: 10px;
        padding: 8px 10px;
    }
    .payment-method input {
        accent-color: #1E6F5C;
    }
    .payment-methods__error {
        margin: 2px 0 0;
        font-size: .78rem;
        color: #b53434;
    }

    .btn-checkout {
        width: 100%;
        margin-top: 20px;
        display: flex; align-items: center; justify-content: center; gap: 9px;
        background: var(--dorado);
        color: var(--negro-bosque);
        border: none;
        border-radius: 50px;
        padding: 13px 22px;
        font-size: .95rem;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 4px 18px rgba(201, 162, 39, .35);
        transition: opacity .2s, transform .15s, background .2s;
        text-align: center;
    }
    .btn-checkout:hover { background: var(--beige-arena); transform: scale(1.02); color: var(--negro-bosque); }

    /* AUDIO INSTRUCTIONS */
    .audio-instructions-wrapper {
        margin-top: 14px;
        padding: 12px 14px;
        background: rgba(105, 181, 120, 0.08);
        border: 1.5px solid rgba(105, 181, 120, 0.15);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .audio-instructions-wrapper:hover {
        background: rgba(105, 181, 120, 0.12);
        border-color: rgba(105, 181, 120, 0.25);
    }
    .audio-instructions-text {
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--verde-selva);
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .audio-btn {
        background: transparent;
        border: none;
        color: var(--dorado);
        font-weight: 700;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    .audio-btn:hover {
        background: rgba(201, 162, 39, 0.1);
        color: #b08d1e;
    }
    .audio-btn.is-playing {
        color: #e67e22;
        text-decoration: none;
    }
    .audio-btn.is-playing svg {
        animation: audioPulse 1.2s infinite;
    }

    .audio-controls {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-left: 4px;
    }

    .audio-rewind {
        background: rgba(30, 111, 92, 0.08);
        border: 1.2px solid rgba(30, 111, 92, 0.15);
        color: var(--verde-selva);
        font-size: 0.72rem;
        font-weight: 800;
        cursor: pointer;
        padding: 3px 8px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        transition: all 0.2s;
    }
    .audio-rewind:hover {
        background: var(--verde-selva);
        color: #fff;
        transform: scale(1.05);
    }
    .audio-rewind:active { transform: scale(0.95); }

    @keyframes audioPulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }

    /* TOP NAVIGATION */
    .cart-nav-top {
        margin-bottom: 20px;
    }
    .btn-back-simple {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--verde-selva);
        font-size: 0.92rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        padding: 4px 0;
    }
    .btn-back-simple:hover {
        color: var(--negro-bosque);
        transform: translateX(-5px);
    }

    .cart-summary__note {
        display: flex; align-items: center; justify-content: center;
        font-size: .78rem;
        color: #aaa;
        margin: 12px 0 0;
        text-align: center;
    }

    /* EMPTY */
    .cart-empty {
        text-align: center;
        padding: 70px 20px;
    }
    .cart-empty__icon {
        width: 100px; height: 100px;
        background: #FAF6ED ;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 24px;
        box-shadow: 0 4px 20px rgba(30, 111, 92, .10);
    }
    .cart-empty__title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2C2C2C;
        margin: 0 0 10px;
    }
    .cart-empty__sub {
        font-size: .93rem;
        color: #999;
        margin: 0 0 28px;
    }

    /* FADE OUT animation */
    .cart-item--removing {
        animation: fadeOut .35s forwards;
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateX(0); }
        to   { opacity: 0; transform: translateX(20px); }
    }

    /* STOCK BADGES */
    .cart-item__meta { display: flex; flex-direction: column; gap: 4px; }
    .stock-badge {
        font-size: 0.68rem;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 6px;
        display: inline-block;
        width: fit-content;
        text-transform: uppercase;
        letter-spacing: 0.2px;
    }
    .stock-badge--out {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .stock-badge--low {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }
    .stock-error-notice {
        margin-top: 15px;
        padding: 10px;
        background: #fff5f5;
        border: 1px dashed #feb2b2;
        border-radius: 8px;
        color: #c53030;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .btn-checkout:disabled {
        background: #cbd5e0;
        cursor: not-allowed;
        box-shadow: none;
        opacity: 0.7;
    }
    .btn-checkout:disabled:hover { transform: none; opacity: 0.7; }

    @media (max-width: 600px) {
        .cart-item {
            grid-template-columns: 54px 1fr;
            grid-template-rows: auto auto;
        }
        .cart-item__img-wrap { width: 54px; height: 54px; }
        .cart-item__qty, .cart-item__subtotal, .cart-item__remove {
            grid-column: 2;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    function formatMoney(v) {
        return 'MXN $' + parseFloat(v).toFixed(2);
    }

    function updateGlobalBadge(count) {
        var badge = document.getElementById('cart-badge');
        if (!badge) return;
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.style.display = 'inline-flex';
        } else {
            badge.style.display = 'none';
        }
        var pill = document.getElementById('total-items-count');
        if (pill) pill.textContent = count;
    }

    /* ---- CHANGE QTY (shared PATCH call) ---- */
    function patchQty(productId, newQty) {
        if (newQty < 1) newQty = 1;
        if (newQty > 99) newQty = 99;
        var qtyEl = document.getElementById('qty-' + productId);
        var oldQty = qtyEl ? qtyEl.value : newQty;

        fetch('/cart/' + productId, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ qty: newQty })
        })
        .then(r => {
            if (r.status === 422) {
                return r.json().then(data => {
                    alert(data.message);
                    // location.reload(); // Recargar para revertir y actualizar estados visuales de stock
                    if (qtyEl) {
                        // Intentamos revertir el valor del input para que no se vea la cantidad inválida
                        // Pero mejor recargar si queremos estar 100% seguros de los subtotales etc.
                        location.reload(); 
                    }
                    throw new Error(data.message);
                });
            }
            return r.json();
        })
        .then(data => {
            if (!data.success) return;
            if (qtyEl) qtyEl.value = data.qty;
            document.getElementById('subtotal-' + productId).textContent = formatMoney(data.subtotal);
            document.getElementById('summary-subtotal').textContent = formatMoney(data.total);
            document.getElementById('summary-total').textContent     = formatMoney(data.total);
            updateGlobalBadge(data.count);
            // Si el producto tenía aviso de falta de stock y ahora es válido, recargamos
            location.reload(); 
        })
        .catch(() => {});
    }

    /* ---- AUDIO INSTRUCTIONS ---- */
    document.addEventListener('DOMContentLoaded', function() {
        const playBtn = document.getElementById('play-audio-btn');
        const audio = document.getElementById('payment-audio');

        if (playBtn && audio) {
            playBtn.addEventListener('click', () => {
                if (audio.paused) {
                    audio.play().catch(e => {
                        console.error("Audio playback failed:", e);
                        alert("No se pudo reproducir el audio. Asegúrate de que el archivo exista.");
                    });
                    playBtn.classList.add('is-playing');
                    playBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="6" y="4" width="4" height="16"></rect>
                            <rect x="14" y="4" width="4" height="16"></rect>
                        </svg>
                        Pausar audio
                    `;
                } else {
                    audio.pause();
                    playBtn.classList.remove('is-playing');
                    playBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                            <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                        </svg>
                        haz click aquí
                    `;
                }
            });

            // Rewind logic
            const rewindBtn = document.getElementById('rewind-audio-btn');
            if (rewindBtn) {
                rewindBtn.addEventListener('click', () => {
                    audio.currentTime = Math.max(0, audio.currentTime - 10);
                });
            }

            audio.addEventListener('ended', () => {
                playBtn.classList.remove('is-playing');
                playBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                        <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                    </svg>
                    haz click aquí
                `;
            });
        }
    });

    /* Delta button click (+ / -) */
    function changeQtyDelta(productId, delta) {
        var qtyEl = document.getElementById('qty-' + productId);
        var current = parseInt(qtyEl.value, 10) || 1;
        patchQty(productId, current + delta);
    }

    /* Direct input change */
    function setQty(productId, value) {
        var newQty = parseInt(value, 10);
        if (isNaN(newQty) || newQty < 1) newQty = 1;
        patchQty(productId, newQty);
    }

    /* ---- REMOVE ITEM ---- */
    function removeItem(productId) {
        var row = document.getElementById('cart-item-' + productId);
        if (row) {
            row.classList.add('cart-item--removing');
            setTimeout(() => row.remove(), 360);
        }

        fetch('/cart/' + productId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(data => {
            document.getElementById('summary-subtotal').textContent = formatMoney(data.total);
            document.getElementById('summary-total').textContent     = formatMoney(data.total);
            updateGlobalBadge(data.count);

            if (data.count === 0) {
                setTimeout(() => location.reload(), 400);
            }
        })
        .catch(() => {});
    }

    /* ---- CLEAR CART ---- */
    const btnClear = document.getElementById('btn-clear-cart');
    if (btnClear) {
        btnClear.addEventListener('click', function () {
            if (!confirm('¿Estás seguro de que deseas vaciar el carrito?')) return;

            fetch('/cart/clear', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.json())
            .then(data => {
                updateGlobalBadge(0);
                location.reload();
            })
            .catch(() => {});
        });
    }

    /* ---- CHECKOUT BUTTON ---- */
    var checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function () {
            var btn = document.getElementById('btn-checkout');
            if (btn) { btn.disabled = true; btn.innerHTML = 'Procesando...'; }
        });
    }
</script>
@endpush
