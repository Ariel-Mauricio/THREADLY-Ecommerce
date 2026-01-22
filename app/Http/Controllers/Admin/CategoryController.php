<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100|unique:categories,name',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|url|max:500',
        ], [
            'name.required' => 'El nombre de la categoría es obligatorio',
            'name.min' => 'El nombre debe tener al menos 2 caracteres',
            'name.max' => 'El nombre no puede superar los 100 caracteres',
            'name.unique' => 'Ya existe una categoría con este nombre',
            'description.max' => 'La descripción no puede superar los 1000 caracteres',
            'image.url' => 'La imagen debe ser una URL válida',
        ]);

        $data = $request->only(['name', 'description', 'image']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = true;

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría creada exitosamente');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|url|max:500',
        ], [
            'name.required' => 'El nombre de la categoría es obligatorio',
            'name.min' => 'El nombre debe tener al menos 2 caracteres',
            'name.max' => 'El nombre no puede superar los 100 caracteres',
            'name.unique' => 'Ya existe una categoría con este nombre',
            'description.max' => 'La descripción no puede superar los 1000 caracteres',
            'image.url' => 'La imagen debe ser una URL válida',
        ]);

        $data = $request->only(['name', 'description', 'image']);

        if ($category->name !== $request->name) {
            $data['slug'] = Str::slug($request->name);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'No se puede eliminar una categoría con productos');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría eliminada exitosamente');
    }
}
