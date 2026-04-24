@extends('layouts.app')

@section('title', 'Pedido #{{ $order->id }} — Admin')

@push('styles')
<style>
    :root { --verde-selva:#1E6F5C; --verde-hoja:#69B578; --negro:#2C2C2C; --bg:#f2f5f0; }
    body { background:var(--bg); }

    .detail-hero {
        background: #1E6F5C ;
        border-bottom:2px solid rgba(105,181,120,.3);
        padding:36px 0 28px;
        color:#fff;
    }
    .detail-hero h1 { font-size:1.6rem; font-weight:900; margin:0 0 4px; }
    .detail-hero p  { color:rgba(255,255,255,.7); font-size:.87rem; margin:0; }
    .back-link { display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.8);font-size:.85rem;text-decoration:none;margin-bottom:12px;transition:color .2s; }
    .back-link:hover { color:#fff; }

    .section-card {
        background:#fff; border-radius:20px;
        box-shadow:0 6px 28px rgba(30,111,92,.08);
        border:1.5px solid #d6ead8; overflow:hidden;
        margin-bottom:24px;
    }
    .section-card__head {
        background: #1E6F5C ;
        padding:16px 24px;
        display:flex; align-items:center; gap:10px;
    }
    .section-card__head h2 { color:#fff; font-size:1rem; font-weight:800; margin:0; }
    .section-card__body { padding:24px; }

    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
    @media(max-width:600px){ .info-grid{grid-template-columns:1fr;} }

    .info-item label {
        display:block; font-size:.73rem; font-weight:700; color:#69B578;
        text-transform:uppercase; letter-spacing:.06em; margin-bottom:4px;
    }
    .info-item p {
        font-size:.95rem; font-weight:600; color:var(--negro);
        margin:0; word-break:break-word;
    }

    /* ITEMS TABLE */
    .items-table { width:100%; border-collapse:collapse; }
    .items-table th {
        background:#f7faf7; font-size:.75rem; font-weight:700; color:#888;
        text-transform:uppercase; letter-spacing:.05em;
        padding:11px 16px; text-align:left; border-bottom:1.5px solid #d6ead8;
    }
    .items-table td { padding:13px 16px; font-size:.9rem; color:#444; border-bottom:1px solid #f0f8f1; vertical-align:middle; }
    .items-table tr:last-child td { border-bottom:none; }
    .items-table tr:hover td { background:#fafff9; }
    .item-img { width:44px;height:44px;border-radius:8px;object-fit:cover;border:1.5px solid #d6ead8; }
    .item-img-ph { width:44px;height:44px;border-radius:8px;background:#eef6ef;display:flex;align-items:center;justify-content:center;border:1.5px solid #d6ead8; }

    /* STATUS FORM */
    .status-form { display:flex; flex-direction:column; gap:14px; }
    .form-label-sm { font-size:.78rem; font-weight:700; color:var(--verde-selva); text-transform:uppercase; letter-spacing:.05em; margin-bottom:6px; display:block; }
    .status-select {
        width:100%; padding:12px 16px; border:1.5px solid #b5d9bc; border-radius:12px;
        font-size:.95rem; outline:none; background:#f7faf7; cursor:pointer;
        transition:border-color .2s; font-weight:600;
    }
    .status-select:focus { border-color:var(--verde-selva); }
    .notes-area {
        width:100%; padding:12px 16px; border:1.5px solid #b5d9bc; border-radius:12px;
        font-size:.9rem; outline:none; background:#f7faf7; resize:vertical; min-height:90px;
        transition:border-color .2s; font-family:inherit; box-sizing:border-box;
    }
    .notes-area:focus { border-color:var(--verde-selva); }
    .btn-save {
        padding:13px 28px; background: #1E6F5C ;
        color:#fff; border:none; border-radius:50px; font-size:.95rem; font-weight:700;
        cursor:pointer; transition:opacity .2s, transform .15s;
        display:inline-flex; align-items:center; gap:8px;
    }
    .btn-save:hover { opacity:.88; transform:scale(1.02); }

    /* BADGES */
    .badge-ship { display:inline-flex;align-items:center;gap:5px;padding:5px 14px;border-radius:50px;font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:.05em; }
    .badge-pendiente  { background:#fef3c7;color:#92400e;border:1px solid #fde68a; }
    .badge-en_proceso { background:#dbeafe;color:#1d4ed8;border:1px solid #bfdbfe; }
    .badge-enviado    { background:#d1fae5;color:#065f46;border:1px solid #a7f3d0; }
    .badge-entregado  { background:#bbf7d0;color:#14532d;border:1px solid #6ee7b7; }
    .badge-cancelado  { background:#fee2e2;color:#991b1b;border:1px solid #fecaca; }

    /* ALERT */
    .alert-success { background:#f0fff6;border:1.5px solid #62d890;color:#1a6636;border-radius:12px;padding:13px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:.92rem;font-weight:500; }

    /* TOTAL ROW */
    .total-row { display:flex;justify-content:flex-end;align-items:center;gap:12px;padding:16px 24px;border-top:2px solid #d6ead8;background:#f7faf7; }
    .total-label { font-size:.9rem;font-weight:700;color:#888; }
    .total-value { font-size:1.4rem;font-weight:900;color:var(--verde-selva); }
</style>
@endpush

@section('content')

    <div class="detail-hero">
        <div class="container">
            <a href="{{ route('admin.orders.index') }}" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Volver a pedidos
            </a>
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                <h1>Pedido #{{ $order->id }}</h1>
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
            </div>
            <p>Referencia: <strong style="color:#69B578;font-family:monospace;">{{ $order->bank_reference }}</strong> · {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="container" style="padding-top:28px;padding-bottom:60px;">

        @if(session('success'))
        <div class="alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="row g-4">

            {{-- LEFT COLUMN --}}
            <div class="col-lg-7">

                {{-- CLIENTE INFO --}}
                <div class="section-card">
                    <div class="section-card__head">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <h2>Información del cliente</h2>
                    </div>
                    <div class="section-card__body">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Nombre</label>
                                <p>{{ $order->user?->name ?? '—' }}</p>
                            </div>
                            <div class="info-item">
                                <label>Correo electrónico</label>
                                <p>{{ $order->user?->email ?? '—' }}</p>
                            </div>
                            <div class="info-item">
                                <label>Teléfono</label>
                                <p>
                                    @if($order->user?->phone)
                                        <a href="tel:{{ $order->user->phone }}" style="color:var(--verde-selva);text-decoration:none;">
                                            📞 {{ $order->user->phone }}
                                        </a>
                                    @else
                                        <span style="color:#ccc;">No registrado</span>
                                    @endif
                                </p>
                            </div>
                            <div class="info-item">
                                <label>Dirección de envío</label>
                                <p>
                                    @if($order->user?->address)
                                        📍 {{ $order->user->address }}
                                    @else
                                        <span style="color:#ccc;">No registrada</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PRODUCTOS --}}
                <div class="section-card">
                    <div class="section-card__head">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        <h2>Productos pedidos ({{ $order->items->count() }})</h2>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Producto</th>
                                    <th>Precio unit.</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        @if($item->product?->hasImage())
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="item-img">
                                        @else
                                            <div class="item-img-ph">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#69B578" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $item->product?->name ?? 'Producto eliminado' }}</strong></td>
                                    <td>MXN ${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td style="font-weight:700;color:var(--verde-selva);">MXN ${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="total-row">
                            <span class="total-label">Total:</span>
                            <span class="total-value">MXN ${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN: STATUS UPDATE --}}
            <div class="col-lg-5">
                <div class="section-card" style="position:sticky;top:80px;">
                    <div class="section-card__head">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                        <h2>Actualizar estado de envío</h2>
                    </div>
                    <div class="section-card__body">
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="status-form">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="form-label-sm">Estado actual</label>
                                <select name="shipping_status" class="status-select">
                                    <option value="pendiente"  {{ $order->shipping_status === 'pendiente'  ? 'selected' : '' }}>⏳ Pendiente</option>
                                    <option value="en_proceso" {{ $order->shipping_status === 'en_proceso' ? 'selected' : '' }}>🔄 En proceso</option>
                                    <option value="enviado"    {{ $order->shipping_status === 'enviado'    ? 'selected' : '' }}>🚚 Enviado</option>
                                    <option value="entregado"  {{ $order->shipping_status === 'entregado'  ? 'selected' : '' }}>✅ Entregado</option>
                                    <option value="cancelado"  {{ $order->shipping_status === 'cancelado'  ? 'selected' : '' }}>❌ Cancelado</option>
                                </select>
                            </div>

                            <div>
                                <label class="form-label-sm">Notas de envío <span style="font-weight:400;color:#aaa;text-transform:none;">(opcional)</span></label>
                                <textarea name="shipping_notes" class="notes-area" placeholder="Ej: Número de guía, paquetería usada, comentarios...">{{ old('shipping_notes', $order->shipping_notes) }}</textarea>
                            </div>

                            <button type="submit" class="btn-save">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                Guardar estado
                            </button>
                        </form>

                        @if($order->shipping_notes)
                        <div style="margin-top:20px;padding:14px;background:#f7faf7;border-radius:12px;border:1.5px solid #d6ead8;">
                            <p style="font-size:.75rem;font-weight:700;color:#69B578;text-transform:uppercase;margin:0 0 6px;">Notas actuales:</p>
                            <p style="font-size:.88rem;color:#555;margin:0;line-height:1.5;">{{ $order->shipping_notes }}</p>
                        </div>
                        @endif

                        {{-- Timeline de estados --}}
                        <div style="margin-top:24px;border-top:1.5px solid #eef6ef;padding-top:18px;">
                            <p style="font-size:.75rem;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.05em;margin:0 0 14px;">Flujo de estados</p>
                            @php
                                $steps = [
                                    'pendiente'  => ['⏳','Pendiente',   '#92400e','#fef3c7'],
                                    'en_proceso' => ['🔄','En proceso',  '#1d4ed8','#dbeafe'],
                                    'enviado'    => ['🚚','Enviado',     '#065f46','#d1fae5'],
                                    'entregado'  => ['✅','Entregado',   '#14532d','#bbf7d0'],
                                ];
                                $statusOrder = array_keys($steps);
                                $currentIdx  = array_search($order->shipping_status, $statusOrder);
                            @endphp
                            <div style="display:flex;flex-direction:column;gap:8px;">
                                @foreach($steps as $key => [$icon, $label, $color, $bg])
                                @php $idx = array_search($key, $statusOrder); @endphp
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:32px;height:32px;border-radius:50%;background:{{ $currentIdx !== false && $idx <= $currentIdx ? $bg : '#f5f5f5' }};border:2px solid {{ $currentIdx !== false && $idx <= $currentIdx ? $color : '#ddd' }};display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0;">{{ $icon }}</div>
                                    <span style="font-size:.85rem;font-weight:{{ $order->shipping_status === $key ? '800' : '500' }};color:{{ $order->shipping_status === $key ? $color : '#aaa' }};">{{ $label }}</span>
                                    @if($order->shipping_status === $key)<span style="font-size:.7rem;background:{{ $bg }};color:{{ $color }};padding:2px 8px;border-radius:50px;font-weight:700;">actual</span>@endif
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
