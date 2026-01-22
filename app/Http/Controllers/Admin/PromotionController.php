<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PromotionController extends Controller
{
    public function index()
    {
        $allPromotions = Product::with('category')
            ->whereNotNull('discount_percent')
            ->where('discount_percent', '>', 0)
            ->latest()
            ->get()
            ->map(function($product) {
                $product->promo_status = $product->promotion_status;
                return $product;
            });

        $activeCount = $allPromotions->where('promo_status', 'active')->count();
        $scheduledCount = $allPromotions->where('promo_status', 'scheduled')->count();
        $expiredCount = $allPromotions->where('promo_status', 'expired')->count();

        // Paginated products for display
        $products = Product::with('category')
            ->whereNotNull('discount_percent')
            ->where('discount_percent', '>', 0)
            ->latest()
            ->paginate(15);

        $categories = Category::all();
        $allProducts = Product::where('is_active', true)->get();

        return view('admin.promotions.index', compact(
            'products', 'activeCount', 'scheduledCount', 'expiredCount',
            'categories', 'allProducts'
        ));
    }

    public function bulkApply(Request $request)
    {
        $request->validate([
            'discount_percent' => 'required|integer|min:1|max:100',
            'promotion_label' => 'nullable|string|max:255',
            'promotion_starts' => 'nullable|date',
            'promotion_ends' => 'nullable|date|after:promotion_starts',
            'apply_to' => 'required|in:all,category,selected',
            'category_id' => 'required_if:apply_to,category|nullable|exists:categories,id',
            'product_ids' => 'required_if:apply_to,selected|nullable|array',
            'product_ids.*' => 'exists:products,id',
        ], [
            'discount_percent.required' => 'El porcentaje de descuento es obligatorio',
            'discount_percent.min' => 'El descuento debe ser al menos 1%',
            'discount_percent.max' => 'El descuento no puede ser mayor a 100%',
            'promotion_ends.after' => 'La fecha de fin debe ser posterior a la de inicio',
            'category_id.required_if' => 'Debes seleccionar una categoría',
            'product_ids.required_if' => 'Debes seleccionar al menos un producto',
        ]);

        $query = Product::query();

        if ($request->apply_to === 'category' && $request->category_id) {
            $query->where('category_id', $request->category_id);
        } elseif ($request->apply_to === 'selected' && $request->product_ids) {
            $query->whereIn('id', $request->product_ids);
        }

        $data = [
            'discount_percent' => $request->discount_percent,
            'promotion_label' => $request->promotion_label,
            'promotion_starts' => $request->promotion_starts ?: Carbon::now(),
            'promotion_ends' => $request->promotion_ends,
        ];

        // Si no tiene precio original, usar el precio actual
        $products = $query->get();
        foreach ($products as $product) {
            if (!$product->original_price) {
                $product->original_price = $product->price;
            }
            $product->discount_percent = $data['discount_percent'];
            $product->promotion_label = $data['promotion_label'];
            $product->promotion_starts = $data['promotion_starts'];
            $product->promotion_ends = $data['promotion_ends'];
            // Calcular nuevo precio
            $product->price = round($product->original_price * (1 - ($data['discount_percent'] / 100)), 2);
            $product->save();
        }

        $count = $products->count();

        return redirect()->route('admin.promotions.index')
            ->with('success', "Promoción aplicada a {$count} productos exitosamente.");
    }

    public function bulkRemove(Request $request)
    {
        $request->validate([
            'remove_from' => 'required|in:all,expired,selected',
            'product_ids' => 'required_if:remove_from,selected|nullable|array',
            'product_ids.*' => 'exists:products,id',
        ], [
            'product_ids.required_if' => 'Debes seleccionar al menos un producto',
        ]);

        $query = Product::whereNotNull('discount_percent');

        if ($request->remove_from === 'expired') {
            $query->where('promotion_ends', '<', Carbon::now());
        } elseif ($request->remove_from === 'selected' && $request->product_ids) {
            $query->whereIn('id', $request->product_ids);
        }

        // Restaurar precios originales
        $products = $query->get();
        foreach ($products as $product) {
            if ($product->original_price) {
                $product->price = $product->original_price;
            }
            $product->original_price = null;
            $product->discount_percent = null;
            $product->promotion_label = null;
            $product->promotion_starts = null;
            $product->promotion_ends = null;
            $product->save();
        }

        $count = $products->count();

        return redirect()->route('admin.promotions.index')
            ->with('success', "Promoción eliminada de {$count} productos.");
    }

    public function removePromotion(Product $product)
    {
        if ($product->original_price) {
            $product->price = $product->original_price;
        }
        $product->original_price = null;
        $product->discount_percent = null;
        $product->promotion_label = null;
        $product->promotion_starts = null;
        $product->promotion_ends = null;
        $product->save();

        return redirect()->route('admin.promotions.index')
            ->with('success', "Promoción eliminada de '{$product->name}'.");
    }
}
