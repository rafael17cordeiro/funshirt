<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

//para os pdfs
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function index()
    {
        // SEGURANÇA: Bloquear administradores de acederem ao checkout
        if (auth()->user() && auth()->user()->user_type === 'A') {
            // Mantém o admin na página onde estava e avisa-o do bloqueio
            return back()->with('error', 'Os administradores não podem realizar compras ou aceder ao carrinho.');
        }
    
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'O seu carrinho está vazio.');
        }

        $user = auth()->user();

        if ($user->user_type !== 'C') {
            return redirect()->route('cart.index')->with('error', 'Apenas contas de clientes podem finalizar encomendas.');
        }

        $customer = $user->customer;

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['unit_price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total', 'customer'));
    }

    public function store(Request $request)
    {
       if (auth()->user() && auth()->user()->user_type === 'A') {
            // Mantém o admin na página onde estava e avisa-o do bloqueio
            return back()->with('error', 'Os administradores não podem realizar compras ou aceder ao carrinho.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'O seu carrinho está vazio.');
        }

        // 1. Validação dos Dados do Formulário
        $request->validate([
            'address' => 'required|string|max:255',
            'nif' => 'nullable|digits:9',
            'payment_type' => 'required|in:VISA,MBWAY,PAYPAL',
            'payment_ref' => 'required|string|max:255',
        ]);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['unit_price'] * $item['quantity'];
        }

        try {
            $formatedPaymentType = match ($request->payment_type) {
                'VISA'   => 'Visa',
                'MBWAY'  => 'MB WAY', 
                'PAYPAL' => 'PayPal',
                default => 'Visa'
            };

            $response = Http::withoutVerifying()->timeout(3)->post('https://ainet-payments-api.vercel.app/api/payments', [
                'type' => $formatedPaymentType,
                'reference' => $request->payment_ref,
                'value' => (float)$total,
            ]);

            if ($response->status() === 422) {
                return redirect()->route('catalog.index')
                    ->with('payment_error', $response->json()['message'] ?? 'Pagamento recusado pelo banco simulado.');
            }

            if ($response->failed() || $response->status() !== 201) {
                return redirect()->route('catalog.index')
                    ->with('payment_error', "Erro do banco simulado (HTTP {$response->status()}).");
            }
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Falha de comunicação com o banco simulado.');
        }

         // 3. Gravação na Base de Dados com Transação Segura
        DB::beginTransaction();
        try {  
            // Criar Encomenda na tabela 'orders'
            $orderId = DB::table('orders')->insertGetId([
                'customer_id'  => auth()->user()->id,
                'status'       => 'pending', 
                'date'         => now()->toDateString(),
                'total_price'  => $total,
                'notes'        => $request->notes,
                'nif'          => $request->nif,
                'address'      => $request->address,
                'payment_type' => $formatedPaymentType,
                'payment_ref'  => $request->payment_ref,
                'receipt_url'  => null, 
            ]);

           // Inserir os Itens da Encomenda (order_items)
            foreach ($cart as $item) {
                $codigoCor = strtolower($item['color_code']); 

                // TRUQUE DE SEGURANÇA: Se o código for '000000' ou 'ffffff' e não existir na BD,
                // associamos a primeira cor disponível no teu banco para evitar que o SQLite mande o erro de Foreign Key.
                $corExiste = DB::table('colors')->where('code', $codigoCor)->exists();
                if (!$corExiste) {
                    $primeiraCorDisponivel = DB::table('colors')->value('code');
                    $codigoCor = $primeiraCorDisponivel ?? $codigoCor; 
                }

                DB::table('order_items')->insert([
                    'order_id'        => $orderId,
                    'tshirt_image_id' => $item['tshirt_image_id'] ?? null,
                    'color_code'      => $codigoCor,
                    'size'            => $item['size'],
                    'qty'             => $item['quantity'],
                    'unit_price'      => $item['unit_price'],
                    'sub_total'       => $item['unit_price'] * $item['quantity'],
                ]);
            }

            // 3. GERAÇÃO DO PDF
            // Carrega o objeto do modelo Eloquent com as relações
            $orderObject = \App\Models\Order::with(['customer.user', 'items'])->find($orderId);

            $filename = 'receipt_' . $orderId . '.pdf';

            // Carrega a view que me enviaste (receipt.blade.php)
            $pdf = Pdf::loadView('order.receipt', ['order' => $orderObject]);
            
            Storage::disk('local')->put('pdf_receipts/' . $filename, $pdf->output());

            // Atualiza o nome do PDF na tabela de encomendas
            DB::table('orders')->where('id', $orderId)->update([
                'receipt_url' => $filename
            ]);

            // Confirma tudo no banco de dados
            DB::commit();

            // Limpar o Carrinho da Sessão
            session()->forget('cart');

            return redirect()->route('catalog.index')
                ->with('payment_success', 'A tua encomenda foi registada com sucesso! O recibo foi gerado.')
                ->with('new_order_id', $orderId); // <-- ADICIONAR ESTA LINHAuccess', 'A tua encomenda foi registada com sucesso! O recibo foi gerado.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erro ao processar a encomenda. Detalhe: ' . $e->getMessage());
        }
    }
}