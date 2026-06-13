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
        // Vai buscar as imagens e junta logo as categorias
        $query = \App\Models\TshirtImage::with('category');

        // 1. Lógica da Barra de Pesquisa (Nome e Descrição)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // 2. Lógica do Filtro de Categorias
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Vai buscar os dados filtrados à Base de Dados
        $tshirts = $query->get(); // Se quiseres paginação muda get() para paginate(12)
        $categories = \App\Models\Category::all();
        $priceConfig = \App\Models\Price::first();

        // Envia as 3 variáveis exatas que a nossa View precisa!
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
