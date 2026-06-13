<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Listar encomendas do cliente logado
     */
    public function myOrders()
    {
        // Forçamos a ordenação pelo campo 'date' que existe na tua tabela
        $orders = DB::table('orders')
            ->where('customer_id', auth()->user()->id)
            ->orderBy('date', 'desc')
            ->paginate(10);

        // Mapeamos o campo 'date' para o 'created_at' que a tua view index espera ler
        foreach ($orders as $order) {
            if (isset($order->date)) {
                $order->created_at = $order->date;
            }
        }

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Mostrar detalhes de uma encomenda específica
     */
    public function showOrder($id)
    {
        $order = DB::table('orders')
            ->where('id', $id)
            ->where('customer_id', auth()->user()->id)
            ->first();

        if (!$order) {
            abort(404, 'Encomenda não encontrada.');
        }

        // Mapeamento idêntico para a página de detalhes
        if (isset($order->date)) {
            $order->created_at = $order->date;
        }

        $items = DB::table('order_items')
            ->join('tshirt_images', 'order_items.tshirt_image_id', '=', 'tshirt_images.id')
            ->where('order_items.order_id', $id)
            ->select('order_items.*', 'tshirt_images.name as tshirt_name')
            ->get();

        return view('customer.orders.show', compact('order', 'items'));
    }

    
    public function downloadReceipt($id)
    {
        // Garante que a encomenda pertence de facto ao cliente logado
        $order = DB::table('orders')
            ->where('id', $id)
            ->where('customer_id', auth()->user()->id)
            ->first();

        if (!$order || !$order->receipt_url) {
            return back()->with('error', 'O recibo digital ainda não está disponível para esta encomenda.');
        }

        $filePath = 'pdf_receipts/' . $order->receipt_url;

        if (!Storage::disk('local')->exists($filePath)) {
            return back()->with('error', 'O ficheiro do recibo não foi localizado no servidor.');
        }

        return Storage::disk('local')->download($filePath, $order->receipt_url, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}