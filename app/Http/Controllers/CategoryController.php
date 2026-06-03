<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        // Vai buscar todas as categorias não apagadas (o SoftDeletes ignora as removidas)
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        // 1. Validação
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'file_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = new Category();
        $category->name = $validated['name'];

        // 2. Lógica de Upload
        if ($request->hasFile('file_image')) {
            // Guarda na pasta storage/app/public/categories 
            $path = $request->file('file_image')->store('categories', 'public');
            // Guarda apenas o nome do ficheiro para manter consistência
            $category->image_url = basename($path);
        }

        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria criada com sucesso!'); // Feedback para o vosso Toast
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'file_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category->name = $validated['name'];

        if ($request->hasFile('file_image')) {
            // Remove a imagem antiga fisicamente se existir uma nova
            if ($category->image_url && Storage::disk('public')->exists('categories/' . $category->image_url)) {
                Storage::disk('public')->delete('categories/' . $category->image_url);
            }

            // Faz o upload da nova
            $path = $request->file('file_image')->store('categories', 'public');
            $category->image_url = basename($path);
        }

        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        // O SoftDeletes trata de preencher o deleted_at sem apagar fisicamente 
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria removida com sucesso!');
    }
}