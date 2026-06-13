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

        $price = Price::firstOrFail();

        return view('admin.prices.index', compact('price'));
    }

    /**
     * Atualiza os preços na base de dados.
     */
    public function update(Request $request)
    {
        $price = Price::firstOrFail();


        $price->fill($request->except(['_token', '_method']));
        $price->save();

        return redirect()->route('admin.prices.index')
            ->with('success', 'Regras de preços atualizadas com sucesso!');
    }
}