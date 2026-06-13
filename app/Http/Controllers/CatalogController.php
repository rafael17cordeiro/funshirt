<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use App\Models\Color;
use App\Models\Price;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {

        $query = \App\Models\TshirtImage::with('category');


        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }


        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }


        $tshirts = $query->get();
        $categories = \App\Models\Category::all();
        $priceConfig = \App\Models\Price::first();


        return view('catalog.index', compact('tshirts', 'categories', 'priceConfig'));
    }




    public function show($id)
    {

        $tshirt = TshirtImage::findOrFail($id);

        $priceConfig = Price::first();
        $colors = \App\Models\Color::all();


        return view('catalog.show', compact('tshirt', 'priceConfig', 'colors'));
    }
}
