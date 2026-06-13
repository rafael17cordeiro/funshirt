<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TshirtImage;
use App\Models\Price;

class CartController extends Controller
{
    public function store(Request $request)
    {
        if (auth()->user() && auth()->user()->user_type === 'A') {
            // Mantém o admin na página onde estava e avisa-o do bloqueio
            return back()->with('error', 'Os administradores não podem realizar compras ou aceder ao carrinho.');
        }

        $request->validate([
            'tshirt_image_id' => 'required|exists:tshirt_images,id',
            'size' => 'required|string',
            'color_code' => 'required|exists:colors,code',
            'quantity' => 'required|integer|min:1|max:50',
        ]);

        $tshirt = TshirtImage::findOrFail($request->tshirt_image_id);
        $priceConfig = Price::first();

        $cart = session()->get('cart', []);


        $cartKey = $request->tshirt_image_id . '_' . $request->color_code . '_' . $request->size;

        $validColors = \App\Models\Color::pluck('code')->toArray();

        // Quando o utilizador escolhe uma cor:
        if (!in_array(strtolower($request->color_code), $validColors)) {
            return back()->with('error', 'Cor inválida!');
        }

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = [
                'tshirt_image_id' => $tshirt->id,
                'name' => $tshirt->name,
                'image_url' => $tshirt->image_url,
                'size' => $request->size,
                'color_code' => strtolower($request->color_code),
                'quantity' => $request->quantity,
                'unit_price' => $priceConfig->unit_price_catalog,
            ];
        }


        session()->put('cart', $cart);


        return back()->with('success', 'T-shirt adicionada ao carrinho com sucesso!');
    }

    public function index()
    {
        if (auth()->user() && auth()->user()->user_type === 'A') {
            return back()->with('error', 'Os administradores não podem realizar compras.');
        }

        $cart = session()->get('cart', []);
        $priceConfig = Price::first();
        $total = 0;

        // No CartController.php, dentro do método index():
        foreach ($cart as $key => $item) {
            $cart[$key]['original_price'] = $priceConfig->unit_price_catalog;
            
            if ($item['quantity'] >= $priceConfig->qty_discount) {
                $cart[$key]['unit_price'] = $priceConfig->unit_price_catalog_discount;
                $cart[$key]['has_discount'] = true;
            } else {
                $cart[$key]['unit_price'] = $priceConfig->unit_price_catalog;
                $cart[$key]['has_discount'] = false;
            }
            
            $total += $cart[$key]['unit_price'] * $item['quantity'];
        }

        session()->put('cart', $cart);

        $colors = \App\Models\Color::all();
        return view('cart.index', compact('cart', 'total', 'colors'));
    }

    public function destroy($key)
    {

        $cart = session()->get('cart', []);


        if (isset($cart[$key])) {
            unset($cart[$key]);


            session()->put('cart', $cart);
        }


        return back()->with('success', 'Produto removido com sucesso.');
    }

    public function update(Request $request, $key)
    {
        $cart = session()->get('cart', []);

        // 1. Verifica se o item existe na chave antiga
        if (!isset($cart[$key])) {
            return back()->with('error', 'Item não encontrado.');
        }

        // 2. Se qtd for 0, remove (G3)
        if ($request->quantity <= 0) {
            unset($cart[$key]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Produto removido.');
        }

        $validColors = \App\Models\Color::pluck('code')->toArray();

        // Quando o utilizador escolhe uma cor:
        if (!in_array(strtolower($request->color_code), $validColors)) {
            return back()->with('error', 'Cor inválida!');
        }

        // 3. Lógica da nova chave (se mudou tamanho ou cor)
        $newKey = $cart[$key]['tshirt_image_id'] . '_' . strtolower($request->color_code) . '_' . $request->size;

        if ($key !== $newKey) {
            $itemData = $cart[$key];
            $itemData['quantity'] = $request->quantity;
            $itemData['size'] = $request->size;
            $itemData['color_code'] = strtolower($request->color_code);

            unset($cart[$key]);
            $cart[$newKey] = $itemData;
        } else {
            $cart[$key]['quantity'] = $request->quantity;
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Carrinho atualizado.');
    }

    public function clear()
    {
        // REQUISITO G3: Limpeza total do carrinho
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'O seu carrinho foi totalmente esvaziado.');
    }
}
