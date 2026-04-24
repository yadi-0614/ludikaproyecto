<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Notifications\PedidoEnviado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Lista todos los pedidos con info del cliente.
     */
    public function index(Request $request)
    {
        $status  = $request->input('status', '');
        $search  = $request->input('search', '');

        $query = Order::with(['user', 'items.product'])
            ->latest();

        if ($status) {
            $query->where('shipping_status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('bank_reference', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%"));
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        $counts = [
            'pendiente'   => Order::where('shipping_status', 'pendiente')->count(),
            'en_proceso'  => Order::where('shipping_status', 'en_proceso')->count(),
            'enviado'     => Order::where('shipping_status', 'enviado')->count(),
            'entregado'   => Order::where('shipping_status', 'entregado')->count(),
            'cancelado'   => Order::where('shipping_status', 'cancelado')->count(),
            'total'       => Order::count(),
        ];

        // Resumen de ventas
        $ventas = [
            'ingresos_total'   => Order::whereNotIn('shipping_status', ['cancelado'])->sum('total'),
            'ingresos_mes'     => Order::whereNotIn('shipping_status', ['cancelado'])
                                       ->whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->sum('total'),
            'pedidos_mes'      => Order::whereNotIn('shipping_status', ['cancelado'])
                                       ->whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->count(),
            'ticket_promedio'  => Order::whereNotIn('shipping_status', ['cancelado'])->avg('total') ?? 0,
            'articulos_total'  => OrderItem::sum('quantity'),
        ];

        return view('admin.orders.index', compact('orders', 'counts', 'status', 'search', 'ventas'));
    }

    /**
     * Detalle de un pedido.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Actualiza el estado de envío de un pedido.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'shipping_status' => 'required|in:pendiente,en_proceso,enviado,entregado,cancelado',
            'shipping_notes'  => 'nullable|string|max:500',
        ]);

        $estadoAnterior = $order->shipping_status;

        $order->update([
            'shipping_status' => $request->shipping_status,
            'shipping_notes'  => $request->shipping_notes,
        ]);

        // Notificar al usuario por correo solo cuando se marca como "enviado"
        if ($request->shipping_status === 'enviado' && $estadoAnterior !== 'enviado') {
            $order->user->notify(new PedidoEnviado($order));
        }

        return back()->with('success', 'Estado del pedido actualizado correctamente.');
    }
}
