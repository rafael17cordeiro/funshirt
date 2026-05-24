<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use App\Models\Color;
use App\Models\Price;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $priceConfig = Price::first();
        $categories = Category::orderBy('name')->get();


        $query = TshirtImage::whereNull('customer_id');


        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }


        $tshirts = $query->get();

        return view('catalog.index', compact('tshirts', 'priceConfig', 'categories'));
    }



    public function show($id)
    {

        $tshirt = TshirtImage::findOrFail($id);

        $priceConfig = Price::first();
        $colors = \App\Models\Color::all();


        return view('catalog.show', compact('tshirt', 'priceConfig', 'colors'));
    }
}
