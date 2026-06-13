<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TshirtImage;
use App\Models\Price;
use \App\Models\Color;

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

        $validColors = Color::pluck('code')->toArray();

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
                'color_name' => strtolower( Color::getNameByCode( $request->color_code ) ),
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
        $subtotal = 0;

        // Calcular subtotal normal (sem descontos por item)
        foreach ($cart as $item) {
            $subtotal += $item['unit_price'] * $item['quantity'];
        }

        // Lógica do Desconto Global: 
        // Se a quantidade total de itens no carrinho for >= qty_discount, aplica desconto
        $totalQty = array_sum(array_column($cart, 'quantity'));
        $totalFinal = $subtotal;
        $descontoAplicado = 0;

        if ($totalQty >= $priceConfig->qty_discount) {
            // Exemplo: desconta a diferença entre o preço normal e o de desconto
            $descontoAplicado = ($priceConfig->unit_price_catalog - $priceConfig->unit_price_catalog_discount) * $totalQty;
            $totalFinal = $subtotal - $descontoAplicado;
        }

        $colors = Color::all();
        return view('cart.index', compact('cart', 'subtotal', 'totalFinal', 'descontoAplicado', 'colors'));
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

        // 1. Verifica se o item existe no carrinho
        if (!isset($cart[$key])) {
            return back()->with('error', 'Item não encontrado.');
        }

        // 2. Se qtd for 0, remove
        if ($request->quantity <= 0) {
            unset($cart[$key]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Produto removido.');
        }

        $validColors = Color::pluck('code')->toArray();
        if (!in_array(strtolower($request->color_code), $validColors)) {
            return back()->with('error', 'Cor inválida!');
        }

        $newSize = $request->input('size', $cart[$key]['size']);
        $newColor = strtolower($request->input('color_code', $cart[$key]['color_code']));
        $newQuantity = $request->input('quantity', $cart[$key]['quantity']);
        $productId = $cart[$key]['tshirt_image_id']; 

        // O TRUQUE: Gerar a nova chave correta para onde este produto vai residir
        $newCartKey = $productId . '_' . $newColor . '_' . $newSize;

        // Guardamos temporariamente os dados antigos do produto antes de limpar a chave
        $oldItemData = $cart[$key];

        // Removemos a chave antiga para evitar resíduos e duplicados
        unset($cart[$key]);

        // 3. FUSÃO INTELIGENTE: Verificar se a nova chave já existe no carrinho
        if (isset($cart[$newCartKey])) {
            // Se já existe um produto com essa cor e tamanho, SOMAMOS a quantidade
            $cart[$newCartKey]['quantity'] += $newQuantity;
        } else {
            // Se for um item de combinação única, criamos/atualizamos na nova chave certa
            $cart[$newCartKey] = [
                'tshirt_image_id' => $productId,
                'name'            => $oldItemData['name'],
                'image_url'       => $oldItemData['image_url'],
                'size'            => $newSize,
                'color_code'      => $newColor,
                'color_name'      => strtolower(Color::getNameByCode($newColor)),
                'quantity'        => $newQuantity,
                'unit_price'      => $oldItemData['unit_price'],
            ];
        }

        // Gravar o estado limpo e perfeito na sessão
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Carrinho atualizado com sucesso.');
    }


    public function clear()
    {
        // REQUISITO G3: Limpeza total do carrinho
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'O seu carrinho foi totalmente esvaziado.');
    }
}
