<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review
     */
    public function store(Request $request, Product $product)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check if user already reviewed this product
        if (Review::where('user_id', $user->id)->where('product_id', $product->id)->exists()) {
            return back()->with('error', 'Ya has dejado una reseña para este producto');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:100',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'La calificación es obligatoria',
            'rating.min' => 'La calificación mínima es 1 estrella',
            'rating.max' => 'La calificación máxima es 5 estrellas',
        ]);

        // Check if verified purchase
        $isVerified = $user->hasPurchased($product->id);

        Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'comment' => $validated['comment'],
            'is_verified_purchase' => $isVerified,
            'is_approved' => true, // Auto-approve, can change to false for moderation
        ]);

        ActivityLog::log(
            'review_created',
            $product // Pass the model directly
        );

        return back()->with('success', '¡Gracias por tu reseña!');
    }

    /**
     * Delete a review
     */
    public function destroy(Review $review)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        
        // Users can only delete their own reviews
        if ($review->user_id !== Auth::id() && (!$user || !$user->is_admin)) {
            abort(403);
        }

        $productName = $review->product->name ?? 'Producto';
        $review->delete();

        ActivityLog::log('review_deleted', "Se eliminó una reseña de {$productName}");

        return back()->with('success', 'Reseña eliminada');
    }

    /**
     * Get reviews for a product (AJAX)
     */
    public function productReviews(Product $product, Request $request)
    {
        $reviews = $product->approvedReviews()
            ->with('user:id,name,avatar')
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'reviews' => $reviews,
            'average' => $product->average_rating,
            'total' => $product->reviews_count,
            'distribution' => $product->rating_distribution,
        ]);
    }
}
