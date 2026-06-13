<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TshirtImageController extends Controller
{
    public function index()
    {

        $images = TshirtImage::with('category')->latest()->get();
        return view('admin.tshirt_images.index', compact('images'));
    }

    public function create()
    {

        $categories = Category::all();
        return view('admin.tshirt_images.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'file_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096', // Máx 4MB
        ]);

        $tshirtImage = new TshirtImage();
        $tshirtImage->name = $validated['name'];
        $tshirtImage->description = $validated['description'] ?? null;
        $tshirtImage->category_id = $validated['category_id'];


        if ($request->hasFile('file_image')) {

            $path = $request->file('file_image')->store('tshirt_images', 'public');


            $tshirtImage->image_url = basename($path);
        }

        $tshirtImage->save();

        return redirect()->route('admin.tshirt_images.index')
            ->with('success', 'Imagem adicionada ao catálogo com sucesso!');
    }

    public function edit(TshirtImage $tshirtImage)
    {
        $categories = Category::all();
        return view('admin.tshirt_images.edit', compact('tshirtImage', 'categories'));
    }

    public function update(Request $request, TshirtImage $tshirtImage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'file_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $tshirtImage->name = $validated['name'];
        $tshirtImage->description = $validated['description'] ?? null;
        $tshirtImage->category_id = $validated['category_id'];


        if ($request->hasFile('file_image')) {

            if ($tshirtImage->image_url) {
                Storage::disk('public')->delete('tshirt_images/' . $tshirtImage->image_url);
            }


            $path = $request->file('file_image')->store('tshirt_images', 'public');
            $tshirtImage->image_url = basename($path);
        }

        $tshirtImage->save();

        return redirect()->route('admin.tshirt_images.index')
            ->with('success', 'Imagem do catálogo atualizada com sucesso!');
    }

    public function destroy(TshirtImage $tshirtImage)
    {
        $tshirtImage->delete(); // Soft delete entra em ação!

        return redirect()->route('admin.tshirt_images.index')
            ->with('success', 'Imagem removida do catálogo com sucesso!');
    }
}