<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use App\Models\Price;
use App\Models\Category; // <-- Importar o Model Category
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $priceConfig = Price::first();
        $categories = Category::orderBy('name')->get();

        // 1. Preparamos a "pergunta" à base de dados (apenas imagens públicas)
        $query = TshirtImage::whereNull('customer_id');

        // 2. Verificamos se o utilizador clicou numa categoria (?category=ID)
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // 3. Executamos a pergunta e guardamos os resultados
        $tshirts = $query->get();

        return view('catalog.index', compact('tshirts', 'priceConfig', 'categories'));
    }
}