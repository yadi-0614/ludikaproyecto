@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} — Lúdika</title>
    <meta name="description" content="{{ Str::limit($product->description, 150) }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --verde-selva: #1E6F5C;
            --verde-hoja: #69B578;
            --dorado: #C9A227;
            --negro-bosque: #2C2C2C;
            --beige-arena: #EAD8B1;
            --bg-page: #FAF6ED;
        }

        * { box-sizing: border-box; }
        body {
            background: var(--bg-page);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── NAVBAR ── */
        .top-nav {
            background: #1E6F5C ;
            border-bottom: 3px solid #C9A227;
            box-shadow: 0 4px 25px rgba(30,111,92,0.4);
            padding: 0;
        }
        .top-nav .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 60px;
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .nav-brand-icon {
            width: 38px; height: 38px;
            background: #C9A227;
            border: none;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 3px 12px rgba(201,162,39,0.4);
        }
        .nav-brand-name {
            color: #EAD8B1;
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
        }
        .nav-actions { display: flex; align-items: center; gap: 8px; }
        .nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 16px;
            border-radius: 50px;
            font-size: 0.87rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }
        .nav-btn-ghost {
            color: rgba(234, 216, 177, 0.85);
            border: 1.5px solid transparent;
            background: transparent;
        }
        .nav-btn-ghost:hover { background: rgba(234, 216, 177, 0.15); color: #fff; }
        .nav-btn-solid {
            background: #C9A227;
            border: none;
            color: #2C2C2C;
            box-shadow: 0 4px 14px rgba(201, 162, 39, 0.35);
        }
        .nav-btn-solid:hover { background: #EAD8B1; color: #2C2C2C; transform: translateY(-2px); }
        .nav-avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            border: 2px solid rgba(105,181,120,0.7);
            object-fit: cover;
        }

        /* Responsive Navbar */
        @media (max-width: 768px) {
            .top-nav .container {
                min-height: 56px;
                padding: 0 12px;
            }
            .nav-brand-icon {
                width: 32px; height: 32px;
            }
            .nav-brand-name {
                font-size: 1rem;
            }
            .nav-actions {
                gap: 6px;
                flex-wrap: wrap;
            }
            .nav-btn {
                padding: 6px 12px;
                font-size: 0.75rem;
            }
            .nav-btn:nth-child(1) {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .top-nav .container {
                min-height: 52px;
                padding: 0 10px;
                flex-wrap: wrap;
                gap: 8px;
            }
            .nav-brand {
                gap: 6px;
            }
            .nav-brand-icon {
                width: 28px; height: 28px;
            }
            .nav-brand-name {
                font-size: 0.95rem;
                letter-spacing: 0;
            }
            .nav-actions {
                width: 100%;
                gap: 4px;
                order: 3;
            }
            .nav-btn {
                padding: 5px 10px;
                font-size: 0.7rem;
                flex: 1;
                justify-content: center;
            }
            .nav-btn:nth-child(1) {
                display: none;
            }
            span[style*="color:rgba(255,255,255,0.7)"] {
                display: none;
            }
        }

        /* ── BREADCRUMB ── */
        .breadcrumb-bar {
            background: #fff;
            border-bottom: 1px solid #e8f2ea;
            padding: 10px 0;
        }
        .breadcrumb-bar .breadcrumb {
            margin: 0;
            font-size: 0.83rem;
        }
        .breadcrumb-bar .breadcrumb-item a {
            color: var(--verde-selva);
            text-decoration: none;
            font-weight: 500;
        }
        .breadcrumb-bar .breadcrumb-item.active { color: #888; }
        .breadcrumb-bar .breadcrumb-item + .breadcrumb-item::before { color: #bbb; }

        /* ── MAIN CONTENT ── */
        .product-detail-page {
            flex: 1;
            padding: 2.5rem 0 3rem;
        }

        /* ── PRODUCT CARD ── */
        .detail-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 6px 32px rgba(30,111,92,0.12);
            border: 1.5px solid #d6ead8;
            overflow: hidden;
        }

        /* Image side */
        .detail-img-wrap {
            position: relative;
            background: #eef6ef;
            min-height: 340px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .detail-img {
            width: 100%;
            height: 100%;
            min-height: 340px;
            object-fit: cover;
            display: block;
        }
        .detail-img-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 40px;
        }
        .detail-price-badge {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: var(--dorado);
            color: var(--negro-bosque);
            font-weight: 800;
            font-size: 1.3rem;
            padding: 8px 22px;
            border-radius: 50px;
            box-shadow: 0 4px 16px rgba(201, 162, 39, 0.4);
            letter-spacing: -.01em;
        }

        /* Info side */
        .detail-info {
            padding: 36px 40px;
        }
        .detail-label {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(201,162,39,0.12);
            border: 1.5px solid rgba(201,162,39,0.35);
            color: var(--dorado);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            padding: 3px 12px;
            border-radius: 50px;
            margin-bottom: 14px;
        }
        .detail-name {
            font-size: 2rem;
            font-weight: 800;
            color: var(--negro-bosque);
            margin: 0 0 10px;
            letter-spacing: -.03em;
            line-height: 1.2;
        }
        .detail-divider {
            width: 44px;
            height: 4px;
            background: #C9A227;
            border-radius: 4px;
            margin-bottom: 18px;
        }
        .detail-rating {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }
        .detail-rating .stars {
            display: flex;
            gap: 3px;
        }
        .detail-rating .rating-text {
            color: #777;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .detail-desc {
            color: #555;
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        /* Price display */
        .detail-price-display {
            display: flex;
            align-items: baseline;
            gap: 6px;
            margin-bottom: 28px;
            padding: 16px 20px;
            background: #f7faf7;
            border: 1.5px solid #d6ead8;
            border-radius: 14px;
        }
        .price-prefix { color: var(--verde-selva); font-size: 1.2rem; font-weight: 600; }
        .price-value { color: var(--negro-bosque); font-size: 2.4rem; font-weight: 900; letter-spacing: -.03em; }
        .price-decimals { color: #888; font-size: 1rem; font-weight: 500; }

        /* Auth CTA (for guests) */
        .auth-cta {
            background: #f7faf7;
            border: 1.5px solid #d6ead8;
            border-radius: 16px;
            padding: 22px 24px;
            margin-bottom: 20px;
        }
        .auth-cta h6 {
            color: var(--negro-bosque);
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 6px;
        }
        .auth-cta p {
            color: #777;
            font-size: 0.84rem;
            margin-bottom: 14px;
        }
        .cta-btns { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #1E6F5C ;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 11px 24px;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(30,111,92,0.3);
            transition: opacity .2s, transform .15s;
        }
        .btn-login:hover { opacity: .88; color: #fff; transform: scale(1.02); }
        .btn-register {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: transparent;
            color: var(--verde-selva);
            border: 1.5px solid var(--verde-hoja);
            border-radius: 50px;
            padding: 10px 22px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-register:hover { background: #eef6ef; color: var(--verde-selva); }

        /* Cart button (for auth users) */
        .btn-add-cart {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: var(--dorado);
            color: var(--negro-bosque);
            border: none;
            border-radius: 50px;
            padding: 14px 32px;
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 4px 18px rgba(201, 162, 39, 0.35);
            transition: opacity .2s, transform .15s, background .2s;
            width: 100%;
            justify-content: center;
            text-decoration: none;
            margin-bottom: 10px;
        }
        .btn-add-cart:hover { background: var(--beige-arena); color: var(--negro-bosque); transform: scale(1.02); }
        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            background: transparent;
            color: var(--verde-selva);
            border: 1.5px solid var(--verde-hoja);
            border-radius: 50px;
            padding: 11px 24px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
            width: 100%;
        }
        .btn-back:hover { background: #eef6ef; color: var(--verde-selva); }

        /* ── FOOTER ── */
        footer {
            background: #1E6F5C ;
            border-top: 3px solid #C9A227;
            padding: 18px 0;
            text-align: center;
        }
        footer span {
            color: rgba(234, 216, 177, 0.9);
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .detail-card {
                border-radius: 16px !important;
                box-shadow: 0 2px 12px rgba(30,111,92,0.08) !important;
            }
            .detail-info { 
                padding: 20px 16px !important; 
            }
            .detail-name { 
                font-size: 1.3rem !important;
                margin-bottom: 8px;
            }
            .detail-img-wrap { 
                min-height: 280px !important;
            }
            .detail-price-badge {
                font-size: 1.1rem;
                padding: 6px 18px;
                bottom: 12px;
                right: 12px;
            }
            .detail-desc {
                font-size: 0.95rem;
                margin-bottom: 20px;
            }
            .detail-price-display {
                padding: 14px 16px !important;
                margin-bottom: 20px !important;
            }
            .price-value {
                font-size: 2rem;
            }
            .btn-add-cart {
                width: 100% !important;
                padding: 12px 16px !important;
                font-size: 0.88rem !important;
            }
            .auth-cta {
                padding: 18px 20px !important;
                margin-bottom: 16px !important;
            }
            .reviews-section {
                margin-top: 2rem !important;
                padding: 24px 16px !important;
                border-radius: 18px !important;
            }
            .review-form {
                padding: 18px !important;
            }
            .replies-list {
                margin-left: 20px;
                padding-left: 16px;
            }
        }

        @media (max-width: 576px) {
            .top-nav .container {
                min-height: 56px;
                padding: 0 12px;
            }
            .nav-brand-name {
                font-size: 1.1rem;
            }
            .nav-btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
            .detail-card {
                border-radius: 12px !important;
                overflow: hidden;
            }
            .detail-info { 
                padding: 16px 12px !important;
            }
            .detail-name { 
                font-size: 1.15rem !important;
                margin-bottom: 6px;
            }
            .detail-label {
                font-size: 0.65rem;
                padding: 2px 10px;
                margin-bottom: 10px;
            }
            .detail-divider {
                width: 36px;
                height: 3px;
                margin-bottom: 12px;
            }
            .detail-img-wrap { 
                min-height: 240px !important;
            }
            .detail-price-badge {
                font-size: 1rem;
                padding: 5px 14px;
                bottom: 8px;
                right: 8px;
            }
            .detail-desc {
                font-size: 0.9rem;
                line-height: 1.6;
                margin-bottom: 16px;
            }
            .detail-price-display {
                padding: 12px 14px !important;
                margin-bottom: 16px !important;
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }
            .price-prefix {
                font-size: 1rem;
            }
            .price-value {
                font-size: 1.8rem;
            }
            .price-decimals {
                font-size: 0.85rem;
            }
            .btn-add-cart {
                width: 100% !important;
                padding: 10px 14px !important;
                font-size: 0.85rem !important;
                gap: 6px;
            }
            .btn-add-cart svg {
                width: 14px;
                height: 14px;
            }
            .auth-cta {
                padding: 14px 16px !important;
                margin-bottom: 12px !important;
            }
            .auth-cta h6 {
                font-size: 0.88rem;
                margin-bottom: 4px;
            }
            .auth-cta p {
                font-size: 0.8rem;
                margin-bottom: 10px;
            }
            .cta-btns {
                flex-direction: column;
                gap: 8px;
            }
            .btn-login, .btn-register {
                width: 100%;
                justify-content: center;
                padding: 10px 12px !important;
                font-size: 0.85rem !important;
            }
            .detail-rating {
                gap: 8px;
                margin-bottom: 12px;
            }
            .detail-rating .stars {
                gap: 2px;
            }
            .detail-rating .stars svg {
                width: 14px;
                height: 14px;
            }
            .detail-rating .rating-text {
                font-size: 0.8rem;
            }
            .reviews-section {
                margin-top: 1.5rem !important;
                padding: 20px 12px !important;
                border-radius: 16px !important;
            }
            .reviews-title {
                font-size: 1.2rem;
                margin-bottom: 1.5rem;
                gap: 6px;
            }
            .review-form {
                padding: 16px !important;
                margin-bottom: 2rem !important;
                border-radius: 12px !important;
            }
            .review-item {
                padding: 16px 0;
            }
            .review-user {
                font-size: 0.8rem;
            }
            .review-text {
                font-size: 0.85rem;
            }
            .replies-list {
                margin-left: 16px;
                padding-left: 12px;
            }
            .reply-item {
                padding: 10px 0;
            }
            .reply-user {
                font-size: 0.78rem;
            }
            .reply-text {
                font-size: 0.8rem;
            }
            .btn-reply {
                font-size: 0.75rem;
            }
            .reply-form-container {
                padding: 12px !important;
            }
            #qty-modal {
                width: 90vw;
                max-width: 280px;
            }
            .qty-label {
                font-size: 0.78rem;
            }
            .qty-stepper button {
                width: 36px;
                height: 36px;
                font-size: 1.1rem;
            }
            .qty-stepper input {
                width: 50px;
                font-size: 1rem;
            }
            #qty-modal-confirm {
                padding: 10px;
                font-size: 0.88rem;
            }
        }

        /* ── REVIEWS SECTION ── */
        .reviews-section {
            margin-top: 3rem;
            background: #fff;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 6px 32px rgba(30,111,92,0.08);
            border: 1.5px solid #d6ead8;
        }
        .reviews-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--negro-bosque);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .review-form {
            background: #f7faf7;
            padding: 24px;
            border-radius: 18px;
            border: 1.5px solid #d6ead8;
            margin-bottom: 3rem;
        }
        .review-item {
            padding: 20px 0;
            border-bottom: 1px solid #eef6ef;
        }
        .review-item:last-child { border-bottom: none; }
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .review-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: var(--verde-selva);
        }
        .review-date {
            font-size: 0.8rem;
            color: #888;
        }
        .review-stars {
            display: flex;
            gap: 2px;
            margin-bottom: 8px;
        }
        .review-text {
            color: #555;
            font-size: 0.92rem;
            line-height: 1.6;
        }
        .no-reviews {
            text-align: center;
            padding: 30px;
            color: #888;
            font-style: italic;
        }
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 5px;
        }
        .star-rating input { display: none; }
        .star-rating label {
            cursor: pointer;
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23ddd' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'%3E%3C/polygon%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
        }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='%23C9A227' stroke='%23C9A227' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'%3E%3C/polygon%3E%3C/svg%3E");
        }

        /* ===== REPLIES ===== */
        .replies-list {
            margin-left: 40px;
            margin-top: 15px;
            border-left: 2px solid #eef6ef;
            padding-left: 20px;
        }
        .reply-item {
            padding: 12px 0;
            border-bottom: 1px dotted #eef6ef;
        }
        .reply-item:last-child { border-bottom: none; }
        .reply-user {
            font-size: 0.85rem;
            color: var(--verde-selva);
            font-weight: 700;
        }
        .reply-text {
            font-size: 0.88rem;
            color: #666;
            margin-top: 4px;
        }
        .btn-reply {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--verde-hoja);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 8px;
            cursor: pointer;
            transition: color 0.2s;
        }
        .btn-reply:hover { color: var(--verde-selva); }
        .reply-form-container {
            display: none;
            margin-top: 15px;
            padding: 15px;
            background: #f7faf7;
            border-radius: 12px;
            border: 1px solid #d6ead8;
        }
        .reply-form-container.open { display: block; }

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
            from { opacity: 0; transform: scale(0.85) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
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

        #qty-modal-close:hover { color: #fff; }

        #qty-modal-body { padding: 22px 22px 20px; }
        
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

        .qty-stepper button:hover { background: #d6ead8; }

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

        #qty-modal-confirm {
            width: 100%;
            padding: 11px;
            background: #1E6F5C ;
            color: #fff;
            border: none;
            border-radius: 50px;
            font-size: 0.93rem;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            box-shadow: 0 4px 14px rgba(30, 111, 92, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        #qty-modal-confirm:hover { opacity: 0.9; transform: scale(1.02); }

        #qty-modal-confirm:disabled { opacity: 0.65; cursor: wait; transform: none; }
        
        .navbar-cart-badge {
            display: none;
            min-width: 18px;
            height: 18px;
            background: #C9A227;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            border-radius: 50px;
            align-items: center;
            justify-content: center;
            line-height: 1;
            padding: 0 4px;
            border: 1.5px solid #2C2C2C;
            margin-left: -8px;
            margin-top: -12px;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="top-nav">
        <div class="container">
            <a href="{{ route('welcome') }}" class="nav-brand">
                <div class="nav-brand-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                </div>
                <span class="nav-brand-name">Lúdika</span>
            </a>

            <div class="nav-actions">
                @auth
                    <a href="{{ route('cart.index') }}" class="nav-btn nav-btn-ghost" title="Ver mi carrito">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        <span id="cart-badge" class="navbar-cart-badge">0</span>
                    </a>
                    <a href="{{ route('home') }}" class="nav-btn nav-btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        Inicio
                    </a>
                    <span style="color:rgba(255,255,255,0.7);font-size:0.87rem;font-weight:600;display:flex;align-items:center;gap:6px;">
                        @if(Auth::user()->hasAvatar())
                            <img src="{{ Auth::user()->avatar_url }}"
                                class="nav-avatar"
                                alt="{{ Auth::user()->name }}">
                        @else
                            <div class="nav-avatar" style="background:rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;color:#fff;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        {{ Auth::user()->name }}
                    </span>
                @else
                    <a href="{{ route('login') }}" class="nav-btn nav-btn-ghost">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="nav-btn nav-btn-solid">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Breadcrumb --}}
    <div class="breadcrumb-bar">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('welcome') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                style="margin-right:3px;margin-top:-2px;">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                            Tienda
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Main --}}
    <main class="product-detail-page">
        <div class="container">
            <div class="detail-card">
                <div class="row g-0">

                    {{-- Image column --}}
                    <div class="col-12 col-md-5">
                        <div class="detail-img-wrap">
                            @if($product->hasImage())
                                <img src="{{ $product->image_url }}"
                                    alt="{{ $product->name }}"
                                    class="detail-img">
                            @else
                                <div class="detail-img-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none"
                                        stroke="#69B578" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <polyline points="21 15 16 10 5 21"/>
                                    </svg>
                                    <span style="color:#69B578;font-size:0.82rem;font-weight:600;">Sin imagen</span>
                                </div>
                            @endif
                            <div class="detail-price-badge">
                                ${{ number_format($product->price, 2) }}
                            </div>
                        </div>
                    </div>

                    {{-- Info column --}}
                    <div class="col-12 col-md-7">
                        <div class="detail-info">

                            <div class="detail-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                    <line x1="7" y1="7" x2="7.01" y2="7"/>
                                </svg>
                                {{ $product->category ? $product->category->name : 'Producto Lúdika' }}
                            </div>

                             <h1 class="detail-name">{{ $product->name }}</h1>
                             <div class="detail-rating">
                                 <div class="stars">
                                     @for($i = 1; $i <= 5; $i++)
                                         @if($i <= round($product->rating))
                                             <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#C9A227" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                         @else
                                             <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                         @endif
                                     @endfor
                                 </div>
                                 <span class="rating-text">{{ number_format($product->rating, 1) }} ({{ $product->reviews_count }} comentarios)</span>
                             </div>
                            <div class="detail-divider"></div>
                            
                            {{-- Stock Status --}}
                            <div style="margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                                @if($product->stock > 0)
                                    <div style="width: 8px; height: 8px; border-radius: 50%; background: #28a745; box-shadow: 0 0 8px #28a745;"></div>
                                    <span style="color: #28a745; font-size: 0.85rem; font-weight: 700;">Stock disponible: {{ $product->stock }}</span>
                                @else
                                    <div style="width: 8px; height: 8px; border-radius: 50%; background: #dc3545; box-shadow: 0 0 8px #dc3545;"></div>
                                    <span style="color: #dc3545; font-size: 0.85rem; font-weight: 700;">Agotado temporalmente</span>
                                @endif
                            </div>

                            <p class="detail-desc">{{ $product->description }}</p>

                            {{-- Price display --}}
                            <div class="detail-price-display">
                                <span class="price-prefix">MXN $</span>
                                @php
                                    $parts = explode('.', number_format($product->price, 2));
                                @endphp
                                <span class="price-value">{{ $parts[0] }}</span>
                                <span class="price-decimals">.{{ $parts[1] }}</span>
                            </div>

                            {{-- Auth-based CTA --}}
                            @if($product->stock > 0)
                                @auth
                                    <button type="button" class="btn-add-cart" id="addCartBtn"
                                        onclick="addToCart({{ $product->id }}, this, '{{ addslashes($product->name) }}', {{ $product->price }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                        </svg>
                                        Añadir al carrito
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="btn-add-cart">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                        </svg>
                                        Añadir al carrito
                                    </a>
                                @endauth
                            @else
                                <div style="background: #fffafa; border: 1.5px solid #ffeded; border-radius: 14px; padding: 15px; color: #dc3545; font-size: 0.85rem; font-weight: 600; text-align: center; margin-bottom: 12px;">
                                    Lo sentimos, este artículo no tiene existencias por el momento.
                                </div>
                            @endif
                            <a href="{{ route('welcome') }}" class="btn-back">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                                </svg>
                                Volver a la tienda
                            </a>

                        </div>
                    </div>

                </div>
            </div>

            {{-- Reviews Section --}}
            <div class="reviews-section" id="reviews-section">
                <h3 class="reviews-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    Reseñas y Comentarios ({{ $product->reviews_count }})
                </h3>

                @auth
                    <div class="review-form">
                        <h5 style="font-weight:700; color:var(--negro-bosque); margin-bottom:15px;">Dejar un comentario</h5>
                        <form action="{{ route('products.reviews.store', $product->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" style="font-weight:600; font-size:0.85rem;">Calificación</label>
                                <div class="star-rating">
                                    <input type="radio" id="star5" name="rating" value="5"/><label for="star5"></label>
                                    <input type="radio" id="star4" name="rating" value="4"/><label for="star4"></label>
                                    <input type="radio" id="star3" name="rating" value="3"/><label for="star3"></label>
                                    <input type="radio" id="star2" name="rating" value="2"/><label for="star2"></label>
                                    <input type="radio" id="star1" name="rating" value="1"/><label for="star1"></label>
                                </div>
                                @error('rating')
                                    <div style="color: #c0392b; font-size: 0.8rem; font-weight: 600; margin-top: 5px;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label" style="font-weight:600; font-size:0.85rem;">Tu comentario</label>
                                <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Cuéntanos qué te pareció este producto..." style="border-radius:12px; border:1.5px solid #d6ead8;">{{ old('comment') }}</textarea>
                            </div>
                            <button type="submit" class="btn-login" style="width:auto; padding:10px 30px;">Enviar comentario</button>
                        </form>
                    </div>
                @endauth

                <div class="reviews-list">
                    @forelse($product->reviews as $review)
                        <div class="review-item" id="review-{{ $review->id }}">
                            <div class="review-header">
                                <div class="review-user">
                                    @if($review->user->hasAvatar())
                                        <img src="{{ $review->user->avatar_url }}" style="width:30px; height:30px; border-radius:50%; object-fit:cover;">
                                    @else
                                        <div style="width:30px; height:30px; border-radius:50%; background:var(--verde-selva); color:#fff; display:flex; align-items:center; justify-content:center; font-size:0.7rem;">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    {{ $review->user->name }}
                                </div>
                                <div>
                                    <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                                    @if(Auth::check() && Auth::user()->hasRole('admin'))
                                        <form id="delete-form-{{ $review->id }}" action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" class="btn btn-link text-danger p-0 ms-2" title="Eliminar comentario" onclick="confirmDeleteReview({{ $review->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="review-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#C9A227" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    @endif
                                @endfor
                            </div>
                            <p class="review-text">{{ $review->comment }}</p>

                            {{-- Botón Responder --}}
                            @auth
                                <a href="javascript:void(0)" class="btn-reply" onclick="toggleReplyBox({{ $review->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 17 4 12 9 7"/><path d="M20 18v-2a4 4 0 0 0-4-4H4"/></svg>
                                    Responder
                                </a>

                                <div class="reply-form-container" id="reply-box-{{ $review->id }}">
                                    <form action="{{ route('products.reviews.store', $product->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $review->id }}">
                                        <textarea class="form-control mb-2" name="comment" rows="2" placeholder="Escribe tu respuesta..." style="border-radius:10px; font-size:0.85rem; border:1px solid #d6ead8;"></textarea>
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-sm btn-light" onclick="toggleReplyBox({{ $review->id }})" style="border-radius:50px; font-size:0.75rem;">Cancelar</button>
                                            <button type="submit" class="btn btn-sm btn-success" style="background:var(--verde-selva); border-radius:50px; font-size:0.75rem; border:none; padding:5px 15px;">Responder</button>
                                        </div>
                                    </form>
                                </div>
                            @endauth

                            {{-- Respuestas --}}
                            @if($review->replies->count() > 0)
                                <div class="replies-list" style="margin-left:50px;">
                                    @foreach($review->replies as $reply)
                                        <div class="reply-item" id="review-{{ $reply->id }}">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <div class="reply-user d-flex align-items-center gap-2">
                                                    @if($reply->user->hasAvatar())
                                                        <img src="{{ $reply->user->avatar_url }}" style="width:20px; height:20px; border-radius:50%; object-fit:cover;">
                                                    @else
                                                        <div style="width:20px; height:20px; border-radius:50%; background:var(--verde-hoja); color:#fff; display:flex; align-items:center; justify-content:center; font-size:0.6rem;">
                                                            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    {{ $reply->user->name }}
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="review-date" style="font-size:0.75rem;">{{ $reply->created_at->diffForHumans() }}</span>
                                                    @if(Auth::check() && Auth::user()->hasRole('admin'))
                                                        <form id="delete-form-{{ $reply->id }}" action="{{ route('reviews.destroy', $reply->id) }}" method="POST" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button type="button" class="btn btn-link text-danger p-0" style="margin-top:-2px;" title="Eliminar respuesta" onclick="confirmDeleteReview({{ $reply->id }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="reply-text">{{ $reply->comment }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="no-reviews">
                            Aún no hay reseñas para este producto. ¡Sé el primero en comentar!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer>
        <div class="container">
            <span>&copy; {{ date('Y') }} Lúdika · Todos los derechos reservados</span>
        </div>
    </footer>

    {{-- ===== QUANTITY MODAL ===== --}}
    <div id="qty-modal-overlay">
        <div id="qty-modal">
            <div id="qty-modal-header">
                <p id="qty-modal-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1" /><circle cx="20" cy="21" r="1" />
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
                        <circle cx="9" cy="21" r="1" /><circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>
                    Confirmar agregar
                </button>
            </div>
        </div>
    </div>

    {{-- ===== TOAST ===== --}}
    <div id="cart-toast" style="pointer-events:none;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:34px;height:34px;background:#eef6ef;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#69B578;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div>
                <p style="margin:0;font-size:0.9rem;font-weight:700;color:#2C2C2C;">¡Producto añadido!</p>
                <p id="cart-toast-name" style="margin:2px 0 0;font-size:0.82rem;color:#1E6F5C;"></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <script>
        /* ── helpers ────────────────────────────────────────── */
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

        /* ── GLOBAL addToCart ──────────────────────────────── */
        window.addToCart = function (productId, btn, name, price) {
            var overlay = document.getElementById('qty-modal-overlay');
            var inp = document.getElementById('qty-input');
            if (!overlay || !inp) {
                _cartDoAdd(productId, 1, btn);
                return;
            }
            window._cartPendingId = productId;
            window._cartPendingBtn = btn;
            inp.value = 1;
            var nameEl = document.getElementById('qty-modal-product-name');
            var priceEl = document.getElementById('qty-modal-product-price');
            if (nameEl) nameEl.textContent = name || '';
            if (priceEl) priceEl.textContent = price ? 'MXN $' + parseFloat(price).toFixed(2) : '';
            overlay.classList.add('open');
            inp.focus();
        };

        /* ── actual POST to /cart/add ──────────────────────── */
        function _cartDoAdd(productId, qty, btn) {
            if (btn) {
                btn.disabled = true;
                var oldText = btn.innerHTML;
                btn.innerHTML = 'Añadiendo...';
            }
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ product_id: productId, qty: qty })
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                _cartUpdateBadge(data.count);
                _cartShowToast(data.name || '');
                if (btn) {
                    btn.innerHTML = oldText;
                    btn.disabled = false;
                }
            })
            .catch(function (err) { 
                console.error(err);
                if (btn) {
                    btn.innerHTML = oldText;
                    btn.disabled = false;
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            @auth
                /* ── cart badge on load ── */
                fetch('/cart/count', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function (r) { return r.json(); })
                    .then(function (data) { _cartUpdateBadge(data.count); })
                    .catch(function () { });
            @endauth

            /* ── qty modal wiring ── */
            var qtyOverlay = document.getElementById('qty-modal-overlay');
            var qtyInput = document.getElementById('qty-input');
            var qtyMinus = document.getElementById('qty-minus');
            var qtyPlus = document.getElementById('qty-plus');
            var qtyConfirm = document.getElementById('qty-modal-confirm');
            var qtyModalClose = document.getElementById('qty-modal-close');

            function closeQtyModal() {
                if (qtyOverlay) qtyOverlay.classList.remove('open');
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
                    _cartDoAdd(productId, qty, btn);
                });
            }

            /* Show success message if present */
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Hecho!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#1E6F5C',
                    timer: 3500,
                    timerProgressBar: true
                });
            @endif

            /* Scroll to reviews if needed */
            @if($errors->has('rating') || $errors->has('comment') || session('success'))
                var reviewsSection = document.getElementById('reviews-section');
                if(reviewsSection) {
                    reviewsSection.scrollIntoView({ behavior: 'smooth' });
                }
            @endif
        });

        /* ── Delete Confirmation ───────────────────────────── */
        window.confirmDeleteReview = function(reviewId) {
            Swal.fire({
                title: '¿Eliminar comentario?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1E6F5C',
                cancelButtonColor: '#c0392b',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                background: '#fff',
                color: '#2C2C2C',
                customClass: {
                    popup: 'premium-swal-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading before submit
                    Swal.fire({
                        title: 'Eliminando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById('delete-form-' + reviewId).submit();
                }
            })
        };

        window.toggleReplyBox = function(reviewId) {
            const box = document.getElementById('reply-box-' + reviewId);
            if(box) {
                box.classList.toggle('open');
                if(box.classList.contains('open')) {
                    box.querySelector('textarea').focus();
                }
            }
        };
    </script>
</body>
</html>
