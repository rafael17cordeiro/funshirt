<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TshirtImage;
use App\Models\Price;

class CartController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validar se o cliente preencheu tudo corretamente
        $request->validate([
            'tshirt_image_id' => 'required|exists:tshirt_images,id',
            'size' => 'required|string',
            'color_code' => 'required|exists:colors,code',
            'quantity' => 'required|integer|min:1|max:50',
        ]);

        $tshirt = TshirtImage::findOrFail($request->tshirt_image_id);
        $priceConfig = Price::first();

        // 2. Vai buscar o carrinho atual à sessão (se não existir, cria um array vazio)
        $cart = session()->get('cart', []);

        // 3. Criar um ID único para este item na sessão (ex: "1_#FFFFFF_M")
        // Se a pessoa adicionar a mesma t-shirt, da mesma cor e tamanho, apenas somamos a quantidade!
        $cartKey = $request->tshirt_image_id . '_' . $request->color_code . '_' . $request->size;

        if (isset($cart[$cartKey])) {
            // Já existe no carrinho? Apenas atualiza a quantidade
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            // É um produto novo? Adiciona com todos os detalhes
            $cart[$cartKey] = [
                'tshirt_image_id' => $tshirt->id,
                'name' => $tshirt->name,
                'image_url' => $tshirt->image_url,
                'size' => $request->size,
                'color_code' => $request->color_code,
                'quantity' => $request->quantity,
                'unit_price' => $priceConfig->unit_price_catalog,
            ];
        }

        // 4. Guarda o carrinho atualizado de volta na Sessão
        session()->put('cart', $cart);

        // 5. Devolve o cliente à página onde estava com uma mensagem de sucesso
        return back()->with('success', 'T-shirt adicionada ao carrinho com sucesso!');
    }
}