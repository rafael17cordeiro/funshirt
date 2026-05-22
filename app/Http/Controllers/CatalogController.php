<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use App\Models\Price;
use App\Models\Category; // <-- Importar o Model Category
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $tshirts = TshirtImage::whereNull('customer_id')->get();
        $priceConfig = Price::first();

        // Vai buscar todas as categorias à base de dados
        $categories = Category::orderBy('name')->get();

        return view('catalog.index', compact('tshirts', 'priceConfig', 'categories'));
    }
}