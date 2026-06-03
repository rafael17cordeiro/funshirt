<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Mostra o formulário de configuração com os preços atuais.
     */
    public function index()
    {
        // Vai buscar a primeira (e única) linha de configuração de preços
        $price = Price::firstOrFail();
        
        return view('admin.prices.index', compact('price'));
    }

    /**
     * Atualiza os preços na base de dados.
     */
    public function update(Request $request)
    {
        $price = Price::firstOrFail();
        
        // O fill() injeta todos os dados do formulário de uma vez.
        // Como o teu modelo tem $guarded = [], isto é seguro e instantâneo!
        $price->fill($request->except(['_token', '_method']));
        $price->save();

        return redirect()->route('admin.prices.index')
            ->with('success', 'Regras de preços atualizadas com sucesso!');
    }
}