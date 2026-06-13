<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ColorController extends Controller
{
    /**
     * Display a listing of the colors.
     */
    public function index()
    {
        $colors = Color::all();
        return view('admin.colors.index', compact('colors'));
    }

    /**
     * Show the form for creating a new color.
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Store a newly created color in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:colors,code',
            'name' => 'required|string|max:255',
            'file_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $color = new Color();
        $color->code = $validated['code'];
        $color->name = $validated['name'];
        $color->save();


        if ($request->hasFile('file_image')) {
            $file = $request->file('file_image');

            $filename = str_replace('#', '', $color->code) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('tshirt_base', $filename, 'public');
        }

        return redirect()->route('admin.colors.index')
            ->with('success', 'Cor registada com sucesso!');
    }

    /**
     * Show the form for editing the specified color.
     */
    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    /**
     * Update the specified color in storage.
     */
    public function update(Request $request, Color $color)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'file_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $color->name = $validated['name'];
        $color->save();

        if ($request->hasFile('file_image')) {
            $file = $request->file('file_image');
            $filename = str_replace('#', '', $color->code) . '.' . $file->getClientOriginalExtension();


            $file->storeAs('tshirt_base', $filename, 'public');
        }

        return redirect()->route('admin.colors.index')
            ->with('success', 'Cor atualizada com sucesso!');
    }

    /**
     * Remove the specified color from storage.
     */
    public function destroy(Color $color)
    {
        // O SoftDeletes trata de preencher o deleted_at
        $color->delete();

        return redirect()->route('admin.colors.index')
            ->with('success', 'Cor removida com sucesso!');
    }
}