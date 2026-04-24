@extends('layouts.app')

@push('styles')
<style>
    :root {
        --verde-selva: #1E6F5C;
        --verde-hoja: #69B578;
        --dorado: #C9A227;
        --negro-bosque: #2C2C2C;
        --bg-page: #f2f5f0;
    }

    body { background: var(--bg-page); }

    .orders-page { padding: 3rem 0; }

    /* ── Hero ── */
    .orders-hero {
        background: #1E6F5C ;
        border-radius: 20px;
        padding: 35px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 8px 32px rgba(30,111,92,0.2);
        color: #fff;
    }
    .hero-icon {
        width: 60px; height: 60px;
        background: rgba(255,255,255,0.15);
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 15px;
        display: flex; align-items: center; justify-content: center;
    }
    .orders-hero h1 { font-size: 1.8rem; font-weight: 800; margin: 0; }
    .orders-hero p { color: rgba(255,255,255,0.7); font-size: 0.95rem; margin-top: 5px; }

    /* ── Table Container ── */
    .orders-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid #e1e8e1;
        overflow: hidden;
    }
    .orders-card-body { padding: 0; }

    .orders-table thead th {
        background: #f8faf8;
        padding: 18px 20px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        color: var(--verde-selva);
        border-bottom: 2px solid #eef3ee;
    }
    .orders-table tbody td {
        padding: 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f2f5f2;
    }

    /* ── Status Badge ── */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-completed { background: #eef6ef; color: #2e7d32; }
    .status-pending { background: #fff8e1; color: #f57c00; }

    /* ── Action Buttons ── */
    .btn-view {
        background: #eef6ef;
        color: var(--verde-selva);
        border: none;
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: 700;
        font-size: 0.82rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-view:hover {
        background: var(--verde-selva);
        color: #fff;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-icon { color: #d1d9d1; margin-bottom: 20px; }
    .btn-shop {
        background: var(--verde-selva);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(30,111,92,0.3);
        display: inline-block;
        margin-top: 20px;
    }

    .pagination-wrap { padding: 20px; }
</style>
@endpush

@section('content')
<div class="container orders-page">

    {{-- Hero --}}
    <div class="orders-hero">
        <div class="hero-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        </div>
        <div>
            <h1>Mis Compras</h1>
            <p>Aquí puedes ver el historial de todos tus pedidos realizados en Lúdika</p>
        </div>
    </div>

    <div class="orders-card">
        <div class="orders-card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table orders-table mb-0">
                        <thead>
                            <tr>
                                <th>Referencia</th>
                                <th>Fecha</th>
                                <th class="text-center">Estado</th>
                                <th class="text-end">Total</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $order->bank_reference }}</span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-status status-completed">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                            Completado
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold">
                                        MXN ${{ number_format($order->total, 2) }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn-view">
                                            Detalles
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination-wrap">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <h3 class="fw-bold">No tienes compras todavía</h3>
                    <p class="text-muted">Parece que aún no has realizado ningún pedido.</p>
                    <a href="{{ route('welcome') }}" class="btn-shop">Empezar a comprar</a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
