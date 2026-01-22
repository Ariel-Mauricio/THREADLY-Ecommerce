<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0.01|max:999999.99',
            'original_price' => 'nullable|numeric|min:0|max:999999.99|gte:price',
            'stock' => 'required|integer|min:0|max:99999',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'image' => 'nullable|url|max:500',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'promotion_label' => 'nullable|string|max:50',
            'promotion_starts' => 'nullable|date|after_or_equal:today',
            'promotion_ends' => 'nullable|date|after:promotion_starts',
            'sizes' => 'nullable|array',
            'sizes.*' => 'string|max:10',
            'colors' => 'nullable|array',
            'colors.*' => 'string|max:20',
        ], [
            'name.required' => 'El nombre del producto es obligatorio',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'category_id.required' => 'Selecciona una categoría',
            'category_id.exists' => 'La categoría seleccionada no existe',
            'price.required' => 'El precio es obligatorio',
            'price.min' => 'El precio debe ser mayor a 0',
            'original_price.gte' => 'El precio original debe ser mayor o igual al precio de venta',
            'stock.required' => 'El stock es obligatorio',
            'stock.min' => 'El stock no puede ser negativo',
            'sku.unique' => 'Este SKU ya está en uso',
            'image.url' => 'La imagen debe ser una URL válida',
            'discount_percent.max' => 'El descuento no puede superar el 100%',
            'promotion_starts.after_or_equal' => 'La promoción debe iniciar hoy o después',
            'promotion_ends.after' => 'La fecha de fin debe ser posterior a la de inicio',
        ]);

        $data = $request->only([
            'name', 'category_id', 'description', 'price', 
            'original_price', 'stock', 'image', 'sku',
            'discount_percent', 'promotion_label', 'promotion_starts', 'promotion_ends'
        ]);
        
        // Generate slug
        $data['slug'] = Str::slug($request->name);
        
        // Make slug unique
        $count = Product::where('slug', 'like', $data['slug'] . '%')->count();
        if ($count > 0) {
            $data['slug'] .= '-' . ($count + 1);
        }

        // Handle sizes (checkboxes)
        $data['sizes'] = $request->sizes ?? ['S', 'M', 'L', 'XL'];

        // Handle colors (checkboxes)
        $data['colors'] = $request->colors ?? ['Negro', 'Blanco'];

        // Handle checkboxes
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');
        $data['is_new'] = $request->has('is_new');

        // Handle promotion dates
        if (empty($data['promotion_starts'])) {
            $data['promotion_starts'] = null;
        }
        if (empty($data['promotion_ends'])) {
            $data['promotion_ends'] = null;
        }
        if (empty($data['discount_percent'])) {
            $data['discount_percent'] = null;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado exitosamente');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0.01|max:999999.99',
            'original_price' => 'nullable|numeric|min:0|max:999999.99',
            'stock' => 'required|integer|min:0|max:99999',
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $product->id,
            'image' => 'nullable|url|max:500',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'promotion_label' => 'nullable|string|max:50',
            'promotion_starts' => 'nullable|date',
            'promotion_ends' => 'nullable|date|after:promotion_starts',
            'sizes' => 'nullable|array',
            'sizes.*' => 'string|max:10',
            'colors' => 'nullable|array',
            'colors.*' => 'string|max:20',
        ], [
            'name.required' => 'El nombre del producto es obligatorio',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'category_id.required' => 'Selecciona una categoría',
            'category_id.exists' => 'La categoría seleccionada no existe',
            'price.required' => 'El precio es obligatorio',
            'price.min' => 'El precio debe ser mayor a 0',
            'stock.required' => 'El stock es obligatorio',
            'stock.min' => 'El stock no puede ser negativo',
            'sku.unique' => 'Este SKU ya está en uso',
            'image.url' => 'La imagen debe ser una URL válida',
            'discount_percent.max' => 'El descuento no puede superar el 100%',
            'promotion_ends.after' => 'La fecha de fin debe ser posterior a la de inicio',
        ]);

        $data = $request->only([
            'name', 'category_id', 'description', 'price', 
            'original_price', 'stock', 'image', 'sku',
            'discount_percent', 'promotion_label', 'promotion_starts', 'promotion_ends'
        ]);

        // Update slug if name changed
        if ($product->name !== $request->name) {
            $data['slug'] = Str::slug($request->name);
            $count = Product::where('slug', 'like', $data['slug'] . '%')
                           ->where('id', '!=', $product->id)
                           ->count();
            if ($count > 0) {
                $data['slug'] .= '-' . ($count + 1);
            }
        }

        // Handle sizes
        $data['sizes'] = $request->sizes ?? [];

        // Handle colors
        $data['colors'] = $request->colors ?? [];

        // Handle checkboxes
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');
        $data['is_new'] = $request->has('is_new');

        // Handle promotion dates
        if (empty($data['promotion_starts'])) {
            $data['promotion_starts'] = null;
        }
        if (empty($data['promotion_ends'])) {
            $data['promotion_ends'] = null;
        }
        if (empty($data['discount_percent'])) {
            $data['discount_percent'] = null;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}
