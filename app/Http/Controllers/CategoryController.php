<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }

    public function publicIndex(Request $request)
    {
        $search = $request->input('search', '');
        
        $query = Category::with('products')->orderBy('name');
        
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        $categories = $query->get();
        return view('categories.public', compact('categories', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
        ]);

        Category::create($validated);

        return redirect()->back()->with('success', 'Categoría creada exitosamente.');
    }

    public function update(Request $request, Category $category)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->back()->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar una categoría que tiene productos asociados.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Categoría eliminada exitosamente.');
    }
}
