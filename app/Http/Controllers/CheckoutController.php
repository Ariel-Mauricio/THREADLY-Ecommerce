<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Obtener el carrito del usuario/sesión
     */
    private function getCart()
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        return Cart::where(function ($query) use ($sessionId, $userId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->with('items.product')->first();
    }

    /**
     * Validar que los items del carrito están disponibles
     */
    private function validateCartItems($cart)
    {
        $errors = [];
        $validItems = [];

        foreach ($cart->items as $item) {
            // Verificar que el producto existe y está activo
            if (!$item->product || !$item->product->is_active) {
                $productName = $item->product->name ?? 'Desconocido';
                $errors[] = "El producto '{$productName}' ya no está disponible";
                continue;
            }

            // Verificar stock
            if ($item->product->stock < $item->quantity) {
                if ($item->product->stock > 0) {
                    $errors[] = "Solo hay {$item->product->stock} unidades de '{$item->product->name}'";
                } else {
                    $errors[] = "'{$item->product->name}' está agotado";
                }
                continue;
            }

            $validItems[] = $item;
        }

        return [
            'valid' => count($errors) === 0,
            'errors' => $errors,
            'validItems' => $validItems
        ];
    }

    /**
     * Mostrar página de checkout
     */
    public function index()
    {
        $cart = $this->getCart();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('products.index')
                ->with('error', 'Tu carrito está vacío');
        }

        // Validar items del carrito
        $validation = $this->validateCartItems($cart);
        
        if (!$validation['valid']) {
            // Eliminar items inválidos
            foreach ($cart->items as $item) {
                if (!in_array($item, $validation['validItems'])) {
                    $item->delete();
                }
            }
            
            if (empty($validation['validItems'])) {
                return redirect()->route('products.index')
                    ->with('error', 'Los productos de tu carrito ya no están disponibles');
            }

            $cart->refresh();
        }

        // Calcular totales
        $subtotal = $cart->total;
        $shipping = $subtotal >= 50 ? 0 : 5;
        $tax = round($subtotal * 0.12, 2);
        $total = round($subtotal + $shipping + $tax, 2);

        // Preparar items formateados para la vista
        $cartItems = $cart->items->filter(function ($item) {
            return $item->product && $item->product->is_active;
        })->map(function ($item) {
            return (object) [
                'id' => $item->id,
                'product' => $item->product,
                'size' => $item->size,
                'color' => $item->color,
                'quantity' => $item->quantity,
                'price' => $item->product->final_price,
                'subtotal' => $item->subtotal,
            ];
        });

        return view('checkout', compact('cart', 'cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    /**
     * Procesar el checkout y crear la orden
     */
    public function process(Request $request)
    {
        // Validación exhaustiva de todos los campos
        $validated = $request->validate([
            'first_name' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'required|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'address' => 'required|string|max:500',
            'address_reference' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'payment_method' => 'required|in:card,transfer,cash',
            'payment_voucher' => 'required_if:payment_method,transfer|nullable|file|mimes:jpeg,jpg,png,gif,webp,pdf|max:5120',
            'notes' => 'nullable|string|max:1000',
        ], [
            'first_name.required' => 'El nombre es obligatorio',
            'first_name.regex' => 'El nombre solo puede contener letras',
            'last_name.required' => 'El apellido es obligatorio',
            'last_name.regex' => 'El apellido solo puede contener letras',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'Ingresa un email válido',
            'phone.required' => 'El teléfono es obligatorio',
            'phone.regex' => 'Ingresa un número de teléfono válido',
            'address.required' => 'La dirección es obligatoria',
            'city.required' => 'La ciudad es obligatoria',
            'province.required' => 'La provincia es obligatoria',
            'payment_method.required' => 'Selecciona un método de pago',
            'payment_method.in' => 'Método de pago no válido',
            'payment_voucher.required_if' => 'Debes subir el comprobante de transferencia',
            'payment_voucher.mimes' => 'El comprobante debe ser una imagen (JPG, PNG, GIF, WEBP) o PDF',
            'payment_voucher.max' => 'El comprobante no debe superar los 5MB',
        ]);

        try {
            DB::beginTransaction();

            $cart = $this->getCart();

            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('products.index')
                    ->with('error', 'Tu carrito está vacío');
            }

            // Validar items del carrito nuevamente (doble verificación)
            $validation = $this->validateCartItems($cart);
            
            if (!$validation['valid']) {
                DB::rollBack();
                return back()
                    ->withInput()
                    ->with('error', implode('. ', $validation['errors']));
            }

            // Calcular totales
            $subtotal = 0;
            foreach ($cart->items as $item) {
                $subtotal += $item->product->final_price * $item->quantity;
            }

            $shippingCost = $subtotal >= 50 ? 0 : 5;
            $tax = round($subtotal * 0.12, 2);
            $total = round($subtotal + $shippingCost + $tax, 2);

            // Generar número de orden único
            $orderNumber = 'ORD-' . strtoupper(Str::random(8)) . '-' . time();

            // Procesar comprobante de transferencia si existe
            $voucherPath = null;
            if ($validated['payment_method'] === 'transfer' && $request->hasFile('payment_voucher')) {
                $voucher = $request->file('payment_voucher');
                $voucherName = 'voucher_' . $orderNumber . '_' . time() . '.' . $voucher->getClientOriginalExtension();
                $voucherPath = $voucher->storeAs('vouchers', $voucherName, 'public');
            }

            // Crear orden
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'customer_name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
                'customer_email' => strtolower(trim($validated['email'])),
                'customer_phone' => preg_replace('/\s+/', '', $validated['phone']),
                'shipping_address' => trim($validated['address']),
                'address_reference' => $validated['address_reference'] ? trim($validated['address_reference']) : null,
                'city' => trim($validated['city']),
                'province' => trim($validated['province']),
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_voucher' => $voucherPath,
                'notes' => $validated['notes'] ? trim($validated['notes']) : null,
                'status' => $validated['payment_method'] === 'transfer' ? 'pending_verification' : 'pending',
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent(), 0, 255),
            ]);

            // Crear items de la orden y actualizar stock
            foreach ($cart->items as $item) {
                // Bloquear el producto para actualizar el stock de forma segura
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();
                
                if (!$product || $product->stock < $item->quantity) {
                    DB::rollBack();
                    return back()
                        ->withInput()
                        ->with('error', "El producto '{$item->product->name}' ya no tiene suficiente stock");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'size' => $item->size,
                    'color' => $item->color,
                    'quantity' => $item->quantity,
                    'price' => $product->final_price,
                    'total' => round($product->final_price * $item->quantity, 2),
                ]);

                // Decrementar stock
                $product->decrement('stock', $item->quantity);
            }

            // Limpiar carrito
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            Log::info('Orden creada exitosamente', ['order_id' => $order->id, 'order_number' => $orderNumber]);

            // Enviar email de confirmación
            try {
                Mail::to($order->customer_email)->send(new \App\Mail\OrderConfirmation($order));
            } catch (\Exception $e) {
                Log::error('Error enviando email de confirmación: ' . $e->getMessage());
            }

            // Redirigir según método de pago
            if ($validated['payment_method'] === 'card') {
                return redirect()->route('payment.payphone', $order);
            }

            return redirect()->route('orders.success', $order)
                ->with('success', '¡Pedido realizado con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al procesar checkout: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al procesar tu pedido. Por favor intenta nuevamente.');
        }
    }
}
