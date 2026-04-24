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

    .order-page { padding: 3rem 0; }

    /* ── Hero ── */
    .order-hero {
        background: #1E6F5C ;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        box-shadow: 0 8px 32px rgba(30,111,92,0.2);
        color: #fff;
    }
    .order-hero h1 { font-size: 1.5rem; font-weight: 800; margin: 0; }
    .order-hero p { color: rgba(255,255,255,0.7); font-size: 0.85rem; margin-top: 5px; }

    .btn-back {
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50px;
        padding: 10px 22px;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        backdrop-filter: blur(5px);
        transition: background 0.2s;
    }
    .btn-back:hover {
        background: rgba(255,255,255,0.25);
        color: #fff;
    }

    /* ── Detail Card ── */
    .detail-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        border: 1px solid #e1e8e1;
        overflow: hidden;
    }
    .detail-card-header {
        background: #f8faf8;
        padding: 24px 30px;
        border-bottom: 1.5px solid #eef3ee;
        font-weight: 700;
        color: var(--verde-selva);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .detail-card-body { padding: 30px; }

    /* ── Items Table ── */
    .items-table thead th {
        background: transparent;
        padding: 12px 10px;
        font-size: 0.72rem;
        text-transform: uppercase;
        color: #888;
        border-bottom: 1px solid #eee;
    }
    .items-table tbody td {
        padding: 15px 10px;
        vertical-align: middle;
        border-bottom: 1px solid #f9f9f9;
        font-size: 0.92rem;
    }

    .prod-img {
        width: 45px; height: 45px;
        border-radius: 10px;
        object-fit: cover;
        background: #f0f4f0;
        margin-right: 12px;
    }

    /* ── Summary ── */
    .summary-box {
        background: #f8faf8;
        border-radius: 15px;
        padding: 24px;
        margin-top: 30px;
        border: 1.5px solid #eef3ee;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .total-row {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1.5px dashed #d6ead8;
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--negro-bosque);
    }

</style>
@endpush

@section('content')

<div class="container order-page">

    {{-- Hero --}}
    <div class="order-hero">
        <div>
            <h1>Detalle del Pedido</h1>
            <p>ID Referencia: <strong>{{ $order->bank_reference }}</strong></p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Volver al historial
        </a>
    </div>

    <div class="detail-card">
        <div class="detail-card-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Fecha de Compra: {{ $order->created_at->format('d/m/Y H:i') }}
        </div>
        <div class="detail-card-body">
            <div class="table-responsive">
                <table class="table items-table mb-0">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cant.</th>
                            <th class="text-end">Precio Un.</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product && $item->product->hasImage())
                                            <img src="{{ $item->product->image_url }}" class="prod-img">
                                        @else
                                            <div class="prod-img d-flex align-items-center justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#69B578" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                            </div>
                                        @endif
                                        <span class="fw-bold">{{ $item->product ? $item->product->name : 'Producto no disponible' }}</span>
                                    </div>
                                </td>
                                <td class="text-center">x{{ $item->quantity }}</td>
                                <td class="text-end">MXN ${{ number_format($item->price, 2) }}</td>
                                <td class="text-end fw-bold">MXN ${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end">
                <div class="col-lg-5">
                    <div class="summary-box">
                        <div class="summary-row">
                            <span class="text-muted">Estado del pedido:</span>
                            <span class="fw-bold text-success">Completado</span>
                        </div>
                        <div class="summary-row">
                            <span class="text-muted">Método de pago:</span>
                            <span class="fw-bold">Tarjeta / PayPal</span>
                        </div>
                        <div class="total-row summary-row">
                            <span>TOTAL PAGADO:</span>
                            <span>MXN ${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
