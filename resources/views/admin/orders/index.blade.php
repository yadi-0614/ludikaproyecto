@extends('layouts.app')

@section('title', 'Gestión de Pedidos — Admin')

@push('styles')
<style>
    :root {
        --verde-selva: #1E6F5C;
        --verde-hoja: #69B578;
        --dorado: #C9A227;
        --negro: #2C2C2C;
        --bg: #f2f5f0;
    }
    body { background: var(--bg); }

    /* HERO */
    .orders-hero {
        background: #1E6F5C ;
        border-bottom: 2px solid rgba(105,181,120,.3);
        padding: 40px 0 32px;
    }
    .orders-hero h1 { color:#fff; font-size:1.8rem; font-weight:900; margin:0 0 4px; }
    .orders-hero p  { color:rgba(255,255,255,.7); font-size:.9rem; margin:0; }

    /* STAT CARDS */
    .stat-cards { display:flex; gap:14px; flex-wrap:wrap; margin:28px 0; }
    .stat-card {
        flex:1; min-width:130px;
        background:#fff; border-radius:16px; padding:18px 20px;
        border:1.5px solid #d6ead8;
        box-shadow:0 4px 16px rgba(30,111,92,.07);
        display:flex; flex-direction:column; gap:4px;
        cursor:pointer; transition:transform .2s, box-shadow .2s;
        text-decoration:none;
    }
    .stat-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(30,111,92,.15); }
    .stat-card__num { font-size:1.9rem; font-weight:900; line-height:1; }
    .stat-card__label { font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#888; }
    .stat-card--all    { border-color:#d6ead8; } .stat-card--all .stat-card__num    { color:var(--negro); }
    .stat-card--pend   { border-color:#fde68a; } .stat-card--pend .stat-card__num   { color:#92400e; }
    .stat-card--proc   { border-color:#bfdbfe; } .stat-card--proc .stat-card__num   { color:#1d4ed8; }
    .stat-card--sent   { border-color:#a7f3d0; } .stat-card--sent .stat-card__num   { color:#065f46; }
    .stat-card--done   { border-color:#bbf7d0; } .stat-card--done .stat-card__num   { color:#14532d; }
    .stat-card--cancel { border-color:#fecaca; } .stat-card--cancel .stat-card__num { color:#991b1b; }

    /* FILTERS */
    .filters-bar {
        display:flex; gap:10px; flex-wrap:wrap; align-items:center;
        margin-bottom:20px;
    }
    .filter-input {
        flex:1; min-width:200px;
        padding:10px 16px; border:1.5px solid #b5d9bc; border-radius:50px;
        font-size:.9rem; outline:none; background:#fff;
        transition:border-color .2s;
    }
    .filter-input:focus { border-color:var(--verde-selva); }
    .filter-select {
        padding:10px 14px; border:1.5px solid #b5d9bc; border-radius:50px;
        font-size:.87rem; font-weight:600; outline:none; background:#fff; cursor:pointer;
    }
    .btn-filter {
        padding:10px 22px; background: #1E6F5C ;
        color:#fff; border:none; border-radius:50px; font-size:.88rem; font-weight:700;
        cursor:pointer; transition:opacity .2s;
    }
    .btn-filter:hover { opacity:.88; }
    .btn-reset {
        padding:10px 18px; background:transparent; border:1.5px solid #b5d9bc;
        color:var(--verde-selva); border-radius:50px; font-size:.85rem; font-weight:600;
        text-decoration:none; transition:all .2s;
    }
    .btn-reset:hover { background:#f0fff4; }

    /* TABLE */
    .orders-table-wrap {
        background:#fff; border-radius:20px;
        box-shadow:0 6px 32px rgba(30,111,92,.08);
        border:1.5px solid #d6ead8; overflow:hidden;
    }
    .orders-table { width:100%; border-collapse:collapse; }
    .orders-table thead th {
        background: #1E6F5C ;
        color:#fff; font-size:.78rem; font-weight:700; text-transform:uppercase;
        letter-spacing:.05em; padding:14px 18px; text-align:left;
    }
    .orders-table tbody tr {
        border-bottom:1px solid #eef6ef;
        transition:background .15s;
    }
    .orders-table tbody tr:last-child { border-bottom:none; }
    .orders-table tbody tr:hover { background:#f7faf7; }
    .orders-table td { padding:14px 18px; font-size:.87rem; color:#444; vertical-align:middle; }

    /* BADGES */
    .badge-ship {
        display:inline-flex; align-items:center; gap:5px;
        padding:4px 12px; border-radius:50px; font-size:.72rem; font-weight:800;
        text-transform:uppercase; letter-spacing:.05em;
    }
    .badge-pendiente   { background:#fef3c7; color:#92400e; border:1px solid #fde68a; }
    .badge-en_proceso  { background:#dbeafe; color:#1d4ed8; border:1px solid #bfdbfe; }
    .badge-enviado     { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; }
    .badge-entregado   { background:#bbf7d0; color:#14532d; border:1px solid #6ee7b7; }
    .badge-cancelado   { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; }

    /* BUTTONS */
    .btn-view {
        display:inline-flex; align-items:center; gap:5px;
        padding:6px 16px; border-radius:50px;
        background: #1E6F5C ;
        color:#fff; font-size:.78rem; font-weight:700; text-decoration:none;
        transition:opacity .2s;
    }
    .btn-view:hover { opacity:.88; color:#fff; }

    /* CUSTOMER INFO */
    .customer-info { display:flex; flex-direction:column; gap:2px; }
    .customer-name { font-weight:700; color:var(--negro); font-size:.88rem; }
    .customer-email { font-size:.76rem; color:#888; }
    .customer-phone { font-size:.76rem; color:var(--verde-selva); font-weight:600; }

    /* ORDER REF */
    .ref-badge {
        font-family:monospace; font-size:.78rem; font-weight:700;
        background:#f0fff4; color:var(--verde-selva); padding:3px 10px;
        border-radius:6px; border:1px solid #b5d9bc;
    }

    /* EMPTY */
    .empty-orders { text-align:center; padding:60px 20px; color:#999; }
    .empty-orders svg { margin-bottom:16px; opacity:.4; }

    /* ALERT */
    .alert-success {
        background:#f0fff6; border:1.5px solid #62d890; color:#1a6636;
        border-radius:12px; padding:13px 18px; margin-bottom:20px;
        display:flex; align-items:center; gap:10px; font-size:.92rem; font-weight:500;
    }

    /* BACK LINK */
    .back-link {
        display:inline-flex; align-items:center; gap:6px;
        color:rgba(255,255,255,.8); font-size:.85rem; text-decoration:none;
        margin-bottom:12px; transition:color .2s;
    }
    .back-link:hover { color:#fff; }

    /* VENTAS SUMMARY */
    .ventas-panel {
        background:#fff; border-radius:20px;
        border:1.5px solid #d6ead8;
        box-shadow:0 4px 20px rgba(30,111,92,.07);
        padding:22px 28px;
        margin-bottom:24px;
    }
    .ventas-panel__title {
        font-size:.78rem; font-weight:800; text-transform:uppercase;
        letter-spacing:.07em; color:#888; margin-bottom:16px;
        display:flex; align-items:center; gap:8px;
    }
    .ventas-grid {
        display:grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap:16px;
    }
    .ventas-item {
        display:flex; flex-direction:column; gap:4px;
        padding:14px 16px; border-radius:14px;
        background:#f7faf7; border:1.5px solid #e4f0e6;
    }
    .ventas-item__icon { font-size:1.3rem; line-height:1; }
    .ventas-item__value {
        font-size:1.45rem; font-weight:900; color:var(--verde-selva); line-height:1.1;
    }
    .ventas-item__label {
        font-size:.72rem; font-weight:700; text-transform:uppercase;
        letter-spacing:.05em; color:#aaa;
    }
    .ventas-item--highlight { background:#f0fff6; border-color:#a7f3d0; }
    .ventas-item--highlight .ventas-item__value { color:#065f46; }
</style>
@endpush

@section('content')

    {{-- HERO --}}
    <div class="orders-hero">
        <div class="container">
            <a href="{{ route('home.admin') }}" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Volver al panel
            </a>
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:52px;height:52px;background:rgba(255,255,255,.15);border-radius:14px;display:flex;align-items:center;justify-content:center;border:1.5px solid rgba(255,255,255,.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                </div>
                <div>
                    <h1>Gestión de Pedidos</h1>
                    <p>Administra y actualiza el estado de envío de todas las compras</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="padding-top:24px;padding-bottom:60px;">

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- STAT CARDS --}}
        <div class="stat-cards">
            <a href="{{ route('admin.orders.index') }}" class="stat-card stat-card--all">
                <span class="stat-card__num">{{ $counts['total'] }}</span>
                <span class="stat-card__label">📦 Total</span>
            </a>
            <a href="{{ route('admin.orders.index', ['status'=>'pendiente']) }}" class="stat-card stat-card--pend">
                <span class="stat-card__num">{{ $counts['pendiente'] }}</span>
                <span class="stat-card__label">⏳ Pendientes</span>
            </a>
            <a href="{{ route('admin.orders.index', ['status'=>'en_proceso']) }}" class="stat-card stat-card--proc">
                <span class="stat-card__num">{{ $counts['en_proceso'] }}</span>
                <span class="stat-card__label">🔄 En proceso</span>
            </a>
            <a href="{{ route('admin.orders.index', ['status'=>'enviado']) }}" class="stat-card stat-card--sent">
                <span class="stat-card__num">{{ $counts['enviado'] }}</span>
                <span class="stat-card__label">🚚 Enviados</span>
            </a>
            <a href="{{ route('admin.orders.index', ['status'=>'entregado']) }}" class="stat-card stat-card--done">
                <span class="stat-card__num">{{ $counts['entregado'] }}</span>
                <span class="stat-card__label">✅ Entregados</span>
            </a>
            <a href="{{ route('admin.orders.index', ['status'=>'cancelado']) }}" class="stat-card stat-card--cancel">
                <span class="stat-card__num">{{ $counts['cancelado'] }}</span>
                <span class="stat-card__label">❌ Cancelados</span>
            </a>
        </div>

        {{-- RESUMEN DE VENTAS --}}
        <div class="ventas-panel">
            <div class="ventas-panel__title">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
                Resumen de ventas
            </div>
            <div class="ventas-grid">
                <div class="ventas-item ventas-item--highlight">
                    <span class="ventas-item__icon">💰</span>
                    <span class="ventas-item__value">MXN ${{ number_format($ventas['ingresos_total'], 2) }}</span>
                    <span class="ventas-item__label">Ingresos totales</span>
                </div>
                <div class="ventas-item">
                    <span class="ventas-item__icon">📅</span>
                    <span class="ventas-item__value">MXN ${{ number_format($ventas['ingresos_mes'], 2) }}</span>
                    <span class="ventas-item__label">Ingresos este mes</span>
                </div>
                <div class="ventas-item">
                    <span class="ventas-item__icon">🛍️</span>
                    <span class="ventas-item__value">{{ $ventas['pedidos_mes'] }}</span>
                    <span class="ventas-item__label">Pedidos este mes</span>
                </div>
                <div class="ventas-item">
                    <span class="ventas-item__icon">🎯</span>
                    <span class="ventas-item__value">MXN ${{ number_format($ventas['ticket_promedio'], 2) }}</span>
                    <span class="ventas-item__label">Ticket promedio</span>
                </div>
                <div class="ventas-item">
                    <span class="ventas-item__icon">📦</span>
                    <span class="ventas-item__value">{{ number_format($ventas['articulos_total']) }}</span>
                    <span class="ventas-item__label">Artículos vendidos</span>
                </div>
            </div>
        </div>

        {{-- FILTERS --}}
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <div class="filters-bar">
                <input type="text" name="search" class="filter-input" placeholder="🔍 Buscar por referencia, nombre o correo..." value="{{ $search }}">
                <select name="status" class="filter-select">
                    <option value="">Todos los estados</option>
                    <option value="pendiente"  {{ $status === 'pendiente'  ? 'selected' : '' }}>⏳ Pendiente</option>
                    <option value="en_proceso" {{ $status === 'en_proceso' ? 'selected' : '' }}>🔄 En proceso</option>
                    <option value="enviado"    {{ $status === 'enviado'    ? 'selected' : '' }}>🚚 Enviado</option>
                    <option value="entregado"  {{ $status === 'entregado'  ? 'selected' : '' }}>✅ Entregado</option>
                    <option value="cancelado"  {{ $status === 'cancelado'  ? 'selected' : '' }}>❌ Cancelado</option>
                </select>
                <button type="submit" class="btn-filter">Filtrar</button>
                <a href="{{ route('admin.orders.index') }}" class="btn-reset">Limpiar</a>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="orders-table-wrap">
            @if($orders->count() > 0)
            <div style="overflow-x:auto;">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Referencia</th>
                            <th>Cliente</th>
                            <th>Dirección de envío</th>
                            <th>Productos</th>
                            <th>Total</th>
                            <th>Estado envío</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td style="font-weight:700;color:#aaa;font-size:.8rem;">{{ $order->id }}</td>
                            <td><span class="ref-badge">{{ $order->bank_reference }}</span></td>
                            <td>
                                <div class="customer-info">
                                    <span class="customer-name">{{ $order->user?->name ?? 'Usuario eliminado' }}</span>
                                    <span class="customer-email">{{ $order->user?->email }}</span>
                                    @if($order->user?->phone)
                                        <span class="customer-phone">📞 {{ $order->user->phone }}</span>
                                    @endif
                                </div>
                            </td>
                            <td style="max-width:180px;">
                                @if($order->user?->address)
                                    <span style="font-size:.82rem;color:#555;">📍 {{ $order->user->address }}</span>
                                @else
                                    <span style="font-size:.78rem;color:#ccc;">Sin dirección</span>
                                @endif
                            </td>
                            <td>
                                <span style="font-size:.82rem;color:#666;">
                                    {{ $order->items->count() }} {{ $order->items->count() === 1 ? 'artículo' : 'artículos' }}
                                </span>
                            </td>
                            <td style="font-weight:800;color:var(--verde-selva);">
                                MXN ${{ number_format($order->total, 2) }}
                            </td>
                            <td>
                                <span class="badge-ship badge-{{ $order->shipping_status }}">
                                    {{ match($order->shipping_status) {
                                        'pendiente'  => '⏳ Pendiente',
                                        'en_proceso' => '🔄 En proceso',
                                        'enviado'    => '🚚 Enviado',
                                        'entregado'  => '✅ Entregado',
                                        'cancelado'  => '❌ Cancelado',
                                        default      => $order->shipping_status,
                                    } }}
                                </span>
                            </td>
                            <td style="font-size:.8rem;color:#888;white-space:nowrap;">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn-view">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Ver detalle
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:16px 20px;border-top:1px solid #eef6ef;">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
            @else
                <div class="empty-orders">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#69B578" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                    <p style="font-size:1rem;font-weight:700;margin:0;">No hay pedidos con ese filtro.</p>
                </div>
            @endif
        </div>

    </div>

@endsection
