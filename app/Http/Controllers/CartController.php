<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Obtener o crear el carrito del usuario/sesión
     */
    private function getCart()
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        // Buscar carrito existente
        $cart = Cart::where(function ($query) use ($sessionId, $userId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->first();

        // Si el usuario se logueó, migrar carrito de sesión a usuario
        if ($userId && !$cart) {
            $sessionCart = Cart::where('session_id', $sessionId)->whereNull('user_id')->first();
            if ($sessionCart) {
                $sessionCart->update(['user_id' => $userId]);
                $cart = $sessionCart;
            }
        }

        // Crear nuevo carrito si no existe
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
            ]);
        }

        return $cart;
    }

    /**
     * Formatear datos del carrito para respuesta JSON
     */
    private function formatCartResponse($cart)
    {
        $cart->load('items.product');

        $items = $cart->items->filter(function ($item) {
            return $item->product && $item->product->is_active;
        })->map(function ($item) {
            $imageUrl = $item->product->image;
            if ($imageUrl && !str_starts_with($imageUrl, 'http')) {
                $imageUrl = asset('storage/' . $imageUrl);
            } elseif (!$imageUrl) {
                $imageUrl = 'https://via.placeholder.com/100';
            }

            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'slug' => $item->product->slug,
                    'image' => $imageUrl,
                    'stock' => $item->product->stock,
                ],
                'name' => $item->product->name,
                'price' => (float) $item->product->final_price,
                'image' => $imageUrl,
                'size' => $item->size,
                'color' => $item->color,
                'quantity' => (int) $item->quantity,
                'subtotal' => (float) ($item->product->final_price * $item->quantity),
            ];
        })->values();

        $total = $items->sum('subtotal');
        $count = $items->sum('quantity');

        return [
            'success' => true,
            'items' => $items,
            'count' => $count,
            'total' => round($total, 2),
        ];
    }

    /**
     * Obtener contenido del carrito
     */
    public function get()
    {
        try {
            $cart = $this->getCart();
            return response()->json($this->formatCartResponse($cart));
        } catch (\Exception $e) {
            Log::error('Error al obtener carrito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el carrito',
                'items' => [],
                'count' => 0,
                'total' => 0
            ], 500);
        }
    }

    /**
     * Agregar producto al carrito
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:100',
            'size' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::where('id', $request->product_id)
                ->where('is_active', true)
                ->lockForUpdate()
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no disponible'
                ], 404);
            }

            $quantity = $request->quantity ?? 1;

            // Validar stock disponible
            if ($product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Solo hay {$product->stock} unidades disponibles"
                ], 400);
            }

            // Validar talla si el producto tiene tallas definidas
            if ($product->sizes && is_array($product->sizes) && count($product->sizes) > 0) {
                if (!$request->size) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Por favor selecciona una talla'
                    ], 400);
                }
                if (!in_array($request->size, $product->sizes)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Talla no válida'
                    ], 400);
                }
            }

            // Validar color si el producto tiene colores definidos
            if ($product->colors && is_array($product->colors) && count($product->colors) > 0) {
                if (!$request->color) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Por favor selecciona un color'
                    ], 400);
                }
                if (!in_array($request->color, $product->colors)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Color no válido'
                    ], 400);
                }
            }

            $cart = $this->getCart();

            // Buscar si ya existe el item con mismas características
            $existingItem = $cart->items()
                ->where('product_id', $request->product_id)
                ->where('size', $request->size)
                ->where('color', $request->color)
                ->first();

            if ($existingItem) {
                $newQuantity = $existingItem->quantity + $quantity;
                
                // Validar que la cantidad total no exceda el stock
                if ($newQuantity > $product->stock) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Solo puedes agregar {$product->stock} unidades de este producto"
                    ], 400);
                }

                $existingItem->update(['quantity' => $newQuantity]);
            } else {
                $cart->items()->create([
                    'product_id' => $request->product_id,
                    'size' => $request->size,
                    'color' => $request->color,
                    'quantity' => $quantity,
                ]);
            }

            DB::commit();

            // Recargar el carrito para obtener datos actualizados
            $cart->refresh();
            $response = $this->formatCartResponse($cart);
            $response['message'] = 'Producto agregado al carrito';

            return response()->json($response);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al agregar al carrito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar el producto al carrito'
            ], 500);
        }
    }

    /**
     * Actualizar cantidad de un item del carrito
     */
    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:cart_items,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        try {
            DB::beginTransaction();

            $cart = $this->getCart();
            
            // Verificar que el item pertenece al carrito del usuario
            $cartItem = $cart->items()->where('id', $request->item_id)->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item no encontrado en tu carrito'
                ], 404);
            }

            // Verificar stock disponible
            $product = Product::where('id', $cartItem->product_id)
                ->where('is_active', true)
                ->lockForUpdate()
                ->first();

            if (!$product) {
                $cartItem->delete();
                DB::commit();
                $cart->refresh();
                return response()->json(array_merge(
                    $this->formatCartResponse($cart),
                    ['message' => 'El producto ya no está disponible y fue removido']
                ));
            }

            if ($product->stock < $request->quantity) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Solo hay {$product->stock} unidades disponibles"
                ], 400);
            }

            $cartItem->update(['quantity' => $request->quantity]);

            DB::commit();

            $cart->refresh();
            $response = $this->formatCartResponse($cart);
            $response['message'] = 'Carrito actualizado';

            return response()->json($response);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar carrito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el carrito'
            ], 500);
        }
    }

    /**
     * Eliminar item del carrito
     */
    public function remove(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:cart_items,id',
        ]);

        try {
            $cart = $this->getCart();
            
            // Verificar que el item pertenece al carrito del usuario
            $cartItem = $cart->items()->where('id', $request->item_id)->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item no encontrado en tu carrito'
                ], 404);
            }

            $cartItem->delete();

            $cart->refresh();
            $response = $this->formatCartResponse($cart);
            $response['message'] = 'Producto eliminado del carrito';

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error al eliminar del carrito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el producto'
            ], 500);
        }
    }

    /**
     * Vaciar carrito completo
     */
    public function clear()
    {
        try {
            $cart = $this->getCart();
            $cart->items()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Carrito vaciado',
                'items' => [],
                'count' => 0,
                'total' => 0
            ]);

        } catch (\Exception $e) {
            Log::error('Error al vaciar carrito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al vaciar el carrito'
            ], 500);
        }
    }
}
