<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Muestra la vista completa del carrito.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;

        if (!empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
            foreach ($cart as $productId => $qty) {
                if ($products->has($productId)) {
                    $product = $products[$productId];
                    
                    $hasStock = $product->stock >= $qty;
                    $isAvailable = $product->stock > 0;
                    
                    $subtotal = $product->price * $qty;
                    
                    // Solo sumar al total si hay stock suficiente
                    if ($hasStock) {
                        $total += $subtotal;
                    }

                    $items[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'image' => $product->image,
                        'qty' => $qty,
                        'subtotal' => $subtotal,
                        'stock' => $product->stock,
                        'has_stock' => $hasStock,
                        'is_available' => $isAvailable,
                    ];
                }
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Add a product to the session cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'nullable|integer|min:1|max:99',
        ]);

        $productId = $request->input('product_id');
        $qty = (int) $request->input('qty', 1);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId] += $qty;
        } else {
            $cart[$productId] = $qty;
        }

        session()->put('cart', $cart);
        $this->syncCartToDatabase();

        $totalCount = array_sum($cart);
        $product = Product::find($productId);

        return response()->json([
            'success' => true,
            'count' => $totalCount,
            'name' => $product ? $product->name : '',
            'message' => 'Producto anadido al carrito.',
        ]);
    }

    /**
     * Return the current cart item count.
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        return response()->json(['count' => array_sum($cart)]);
    }

    /**
     * Return full cart details for the dropdown panel.
     */
    public function items()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $items = [];

        if (!empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
            foreach ($cart as $productId => $qty) {
                if ($products->has($productId)) {
                    $product = $products[$productId];
                    $subtotal = $product->price * $qty;
                    $total += $subtotal;
                    $items[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'qty' => $qty,
                        'subtotal' => $subtotal,
                    ];
                }
            }
        }

        return response()->json([
            'items' => $items,
            'total' => $total,
            'count' => array_sum($cart),
        ]);
    }

    /**
     * Actualiza la cantidad de un producto en el carrito.
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'qty' => 'required|integer|min:1|max:99',
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado en el carrito.'], 404);
        }

        $cart[$productId] = (int) $request->input('qty');
        session()->put('cart', $cart);
        $this->syncCartToDatabase();

        $product = Product::find($productId);
        $subtotal = $product ? $product->price * $cart[$productId] : 0;
        $total = 0;

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        foreach ($cart as $pid => $qty) {
            if ($products->has($pid)) {
                $total += $products[$pid]->price * $qty;
            }
        }

        return response()->json([
            'success' => true,
            'qty' => $cart[$productId],
            'subtotal' => $subtotal,
            'total' => $total,
            'count' => array_sum($cart),
        ]);
    }

    /**
     * Elimina un producto del carrito.
     */
    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);
        $this->syncCartToDatabase();

        $total = 0;
        if (!empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
            foreach ($cart as $pid => $qty) {
                if ($products->has($pid)) {
                    $total += $products[$pid]->price * $qty;
                }
            }
        }

        return response()->json([
            'success' => true,
            'total' => $total,
            'count' => array_sum($cart),
        ]);
    }

    /**
     * Vacia completamente el carrito.
     */
    public function clear()
    {
        session()->forget('cart');
        $this->syncCartToDatabase();

        return response()->json([
            'success' => true,
            'count' => 0,
            'total' => 0,
        ]);
    }

    /**
     * Inicia checkout de pago unico con Stripe o PayPal.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'payment_provider' => 'required|in:stripe,paypal',
        ]);

        // --- Verificar que el usuario tenga dirección y teléfono ---
        $user = auth()->user();
        $missing = [];
        if (empty($user->phone))   $missing[] = 'número de teléfono';
        if (empty($user->address)) $missing[] = 'dirección de envío';

        if (!empty($missing)) {
            return redirect()->route('profile.edit')
                ->with('error', 'Para completar tu compra necesitas agregar tu ' . implode(' y ', $missing) . '. Por favor completa tu perfil.');
        }

        $provider = $request->input('payment_provider');
        $cartData = $this->getCartDetails();

        if (empty($cartData['items']) || $cartData['total'] <= 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito esta vacio. Agrega productos antes de finalizar tu compra.');
        }

        $bankReference = $this->generateBankReference();

        // --- MODIFICACIÓN: Comprobar Stock antes de procesar pago ---
        foreach ($cartData['items'] as $item) {
            $product = Product::find($item['id']);
            if (!$product || $product->stock < $item['qty']) {
                $stockAvailable = $product ? $product->stock : 0;
                return redirect()->route('cart.index')
                    ->with('error', "Lo sentimos, el producto '" . ($product ? $product->name : 'Desconocido') . "' no tiene suficiente stock (Disponible: {$stockAvailable}).");
            }
        }

        return $provider === 'stripe'
            ? $this->startStripeCheckout($cartData['items'], $cartData['total'], $bankReference)
            : $this->startPayPalCheckout($cartData['items'], $cartData['total'], $bankReference);
    }

    /**
     * Stripe return URL: valida pago y cierra la orden.
     */
    public function stripeSuccess(Request $request)
    {
        $sessionId = (string) $request->query('session_id');
        $secret = config('services.stripe.secret');

        if ($sessionId === '' || empty($secret)) {
            return redirect()->route('cart.index')
                ->with('error', 'No se pudo validar el pago en Stripe.');
        }

        $response = Http::withToken($secret)->get(
            "https://api.stripe.com/v1/checkout/sessions/{$sessionId}",
            ['expand' => ['payment_intent']]
        );

        if ($response->failed()) {
            Log::error('Stripe checkout session fetch failed', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return redirect()->route('cart.index')
                ->with('error', 'No se pudo confirmar tu pago de Stripe. Intenta nuevamente.');
        }

        $sessionData = $response->json();
        if (data_get($sessionData, 'payment_status') !== 'paid') {
            return redirect()->route('cart.index')
                ->with('error', 'Tu pago en Stripe no se completo.');
        }

        $bankReference = data_get($sessionData, 'payment_intent.metadata.bank_reference')
            ?? data_get($sessionData, 'metadata.bank_reference')
            ?? data_get(session('pending_checkout', []), 'bank_reference', 'N/A');

        $pending = session('pending_checkout', []);
        $items = $pending['items'] ?? [];
        $total = $pending['total'] ?? 0;

        if (!empty($items)) {
            $this->finalizePurchase($bankReference, $total, $items);
        }

        session()->forget('cart');
        session()->forget('pending_checkout');

        return redirect()->route('cart.index')
            ->with('success', "Compra realizada con exito. Referencia bancaria: {$bankReference}");
    }

    /**
     * PayPal return URL: captura orden y cierra checkout.
     */
    public function paypalSuccess(Request $request)
    {
        $orderId = (string) $request->query('token');
        if ($orderId === '') {
            return redirect()->route('cart.index')
                ->with('error', 'No se recibio la orden de PayPal.');
        }

        $accessToken = $this->getPayPalAccessToken();
        $baseUrl = rtrim((string) config('services.paypal.base_url'), '/');

        if (empty($accessToken) || empty($baseUrl)) {
            return redirect()->route('cart.index')
                ->with('error', 'No se pudo autenticar con PayPal.');
        }

        $captureResponse = Http::withToken($accessToken)
            ->withBody('{}', 'application/json')
            ->post("{$baseUrl}/v2/checkout/orders/{$orderId}/capture");

        if ($captureResponse->failed()) {
            Log::error('PayPal capture failed', [
                'status' => $captureResponse->status(),
                'body' => $captureResponse->json(),
            ]);

            return redirect()->route('cart.index')
                ->with('error', 'No se pudo capturar tu pago de PayPal. Intenta nuevamente.');
        }

        $captureData = $captureResponse->json();
        if (data_get($captureData, 'status') !== 'COMPLETED') {
            return redirect()->route('cart.index')
                ->with('error', 'Tu pago en PayPal no se completo.');
        }

        $bankReference = data_get($captureData, 'purchase_units.0.payments.captures.0.invoice_id')
            ?? data_get($captureData, 'purchase_units.0.reference_id')
            ?? data_get(session('pending_checkout', []), 'bank_reference', 'N/A');

        $pending = session('pending_checkout', []);
        $items = $pending['items'] ?? [];
        $total = $pending['total'] ?? 0;

        if (!empty($items)) {
            $this->finalizePurchase($bankReference, $total, $items);
        }

        session()->forget('cart');
        session()->forget('pending_checkout');

        return redirect()->route('cart.index')
            ->with('success', "Compra realizada con exito. Referencia bancaria: {$bankReference}");
    }

    /**
     * Maneja cancelacion del proveedor.
     */
    public function checkoutCancel()
    {
        session()->forget('pending_checkout');

        return redirect()->route('cart.index')
            ->with('error', 'El pago fue cancelado. Tu carrito sigue disponible.');
    }

    private function getCartDetails(): array
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0.0;

        if (!empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
            foreach ($cart as $productId => $qty) {
                if (!$products->has($productId)) {
                    continue;
                }

                $product = $products[$productId];
                $subtotal = (float) $product->price * (int) $qty;
                $total += $subtotal;

                $items[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'qty' => (int) $qty,
                    'unit_price' => (float) $product->price,
                ];
            }
        }

        return ['items' => $items, 'total' => round($total, 2)];
    }

    private function generateBankReference(): string
    {
        return 'LUD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(8));
    }

    private function startStripeCheckout(array $items, float $total, string $bankReference)
    {
        $secret = config('services.stripe.secret');
        $currency = strtolower((string) config('services.stripe.currency', 'usd'));

        if (empty($secret)) {
            return redirect()->route('cart.index')
                ->with('error', 'Configura STRIPE_SECRET antes de procesar pagos con Stripe.');
        }

        $payload = [
            'mode' => 'payment',
            'success_url' => route('cart.checkout.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cart.checkout.cancel'),
            'client_reference_id' => (string) auth()->id(),
            'metadata[bank_reference]' => $bankReference,
            'payment_intent_data[metadata][bank_reference]' => $bankReference,
        ];

        foreach ($items as $i => $item) {
            $payload["line_items[{$i}][quantity]"] = $item['qty'];
            $payload["line_items[{$i}][price_data][currency]"] = $currency;
            $payload["line_items[{$i}][price_data][unit_amount]"] = (int) round($item['unit_price'] * 100);
            $payload["line_items[{$i}][price_data][product_data][name]"] = $item['name'];
        }

        $response = Http::asForm()
            ->withToken($secret)
            ->post('https://api.stripe.com/v1/checkout/sessions', $payload);

        if ($response->failed()) {
            Log::error('Stripe checkout create failed', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return redirect()->route('cart.index')
                ->with('error', 'No fue posible iniciar el pago con Stripe.');
        }

        $checkoutUrl = data_get($response->json(), 'url');
        if (empty($checkoutUrl)) {
            return redirect()->route('cart.index')
                ->with('error', 'Stripe no devolvio la URL de pago.');
        }

        session()->put('pending_checkout', [
            'provider' => 'stripe',
            'bank_reference' => $bankReference,
            'total' => $total,
            'items' => $items,
        ]);

        return redirect()->away($checkoutUrl);
    }

    private function startPayPalCheckout(array $items, float $total, string $bankReference)
    {
        $accessToken = $this->getPayPalAccessToken();
        $baseUrl = rtrim((string) config('services.paypal.base_url'), '/');
        $currency = strtoupper((string) config('services.paypal.currency', 'USD'));

        if (empty($accessToken) || empty($baseUrl)) {
            return redirect()->route('cart.index')
                ->with('error', 'Configura PAYPAL_CLIENT_ID y PAYPAL_SECRET para usar PayPal.');
        }

        $response = Http::withToken($accessToken)->post("{$baseUrl}/v2/checkout/orders", [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => $bankReference,
                    'custom_id' => $bankReference,
                    'invoice_id' => $bankReference,
                    'description' => 'Compra en ' . config('app.name'),
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => number_format($total, 2, '.', ''),
                    ],
                ],
            ],
            'application_context' => [
                'return_url' => route('cart.checkout.paypal.success'),
                'cancel_url' => route('cart.checkout.cancel'),
                'user_action' => 'PAY_NOW',
                'shipping_preference' => 'NO_SHIPPING',
            ],
        ]);

        if ($response->failed()) {
            Log::error('PayPal order create failed', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return redirect()->route('cart.index')
                ->with('error', 'No fue posible iniciar el pago con PayPal.');
        }

        $orderData = $response->json();
        $approvalUrl = collect(data_get($orderData, 'links', []))->firstWhere('rel', 'approve')['href'] ?? null;
        if (empty($approvalUrl)) {
            return redirect()->route('cart.index')
                ->with('error', 'PayPal no devolvio la URL de aprobacion.');
        }

        session()->put('pending_checkout', [
            'provider' => 'paypal',
            'bank_reference' => $bankReference,
            'order_id' => data_get($orderData, 'id'),
            'total' => $total,
            'items' => $items,
        ]);

        return redirect()->away($approvalUrl);
    }

    private function getPayPalAccessToken(): ?string
    {
        $clientId = config('services.paypal.client_id');
        $secret = config('services.paypal.secret');
        $baseUrl = rtrim((string) config('services.paypal.base_url'), '/');

        if (empty($clientId) || empty($secret) || empty($baseUrl)) {
            return null;
        }

        $response = Http::asForm()
            ->withBasicAuth($clientId, $secret)
            ->post("{$baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->failed()) {
            Log::error('PayPal auth failed', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);
            return null;
        }

        return data_get($response->json(), 'access_token');
    }

    private function syncCartToDatabase()
    {
        if (!auth()->check()) return;

        $user = auth()->user();
        $cart = session()->get('cart', []);

        \App\Models\CartItem::where('user_id', $user->id)->delete();

        foreach ($cart as $productId => $qty) {
            \App\Models\CartItem::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $qty,
            ]);
        }
    }

    private function finalizePurchase($bankReference, $total, $items)
    {
        return DB::transaction(function () use ($bankReference, $total, $items) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'bank_reference' => $bankReference,
                'total' => $total,
                'status' => 'completed',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['unit_price'],
                ]);

                // Descontar stock
                $product = Product::find($item['id']);
                if ($product) {
                    $product->decrement('stock', $item['qty']);
                }
            }

            // Limpiar carrito en DB después de compra
            \App\Models\CartItem::where('user_id', auth()->id())->delete();

            return $order;
        });
    }
}
