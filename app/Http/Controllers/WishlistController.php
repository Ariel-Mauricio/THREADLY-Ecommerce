<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Get wishlist page
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $wishlistItems = $user
            ->wishlistProducts()
            ->with('category')
            ->where('is_active', true)
            ->paginate(12);
        
        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Toggle product in wishlist (AJAX)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $productId = $request->product_id;

        $existing = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            $inWishlist = false;
            $message = 'Producto eliminado de favoritos';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            $inWishlist = true;
            $message = 'Producto agregado a favoritos';
        }

        return response()->json([
            'success' => true,
            'in_wishlist' => $inWishlist,
            'message' => $message,
            'count' => $user->wishlist()->count(),
        ]);
    }

    /**
     * Add product to wishlist (AJAX)
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $productId = $request->product_id;

        $existing = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if (!$existing) {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado a favoritos',
            'count' => $user->wishlist()->count(),
        ]);
    }

    /**
     * Remove product from wishlist (AJAX)
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->delete();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado de favoritos',
            'count' => $user->wishlist()->count(),
        ]);
    }

    /**
     * Clear entire wishlist
     */
    public function clear()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->wishlist()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lista de favoritos vaciada',
            'count' => 0,
        ]);
    }

    /**
     * Get wishlist count (AJAX)
     */
    public function count()
    {
        $count = 0;
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $count = $user->wishlist()->count();
        }
        
        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }

    /**
     * Move all wishlist items to cart
     */
    public function moveToCart(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $wishlistItems = $user->wishlistProducts()->where('is_active', true)->get();
        
        $cartController = new CartController();
        $added = 0;

        foreach ($wishlistItems as $product) {
            if ($product->stock > 0) {
                // Add to cart
                $request->merge(['product_id' => $product->id, 'quantity' => 1]);
                $cartController->add($request);
                $added++;
            }
        }

        // Clear wishlist
        $user->wishlist()->delete();

        return response()->json([
            'success' => true,
            'message' => "$added productos movidos al carrito",
            'added' => $added,
        ]);
    }
}
