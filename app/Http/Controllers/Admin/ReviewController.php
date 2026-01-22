<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product'])
            ->latest();

        if ($request->has('rating') && $request->rating !== '') {
            $query->where('rating', $request->rating);
        }

        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        $reviews = $query->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        
        return redirect()->back()->with('success', 'Reseña aprobada correctamente.');
    }

    public function reject(Review $review)
    {
        $review->update(['is_approved' => false]);
        
        return redirect()->back()->with('success', 'Reseña rechazada correctamente.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        
        return redirect()->back()->with('success', 'Reseña eliminada correctamente.');
    }
}
