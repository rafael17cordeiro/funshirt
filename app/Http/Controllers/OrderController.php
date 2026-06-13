<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    // ==========================================
    // ÁREA DE CLIENTES
    // ==========================================

    public function myOrders()
    {
        $orders = Order::where('customer_id', auth()->id())
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with(['orderItems.tshirtImage', 'orderItems.color'])
            ->where('id', $id)
            ->where('customer_id', auth()->id())
            ->firstOrFail();

        return view('customer.orders.show', compact('order'));
    }

    public function downloadReceipt($id)
    {
        $order = Order::where('id', $id)->where('customer_id', auth()->id())->firstOrFail();

        if (!$order->receipt_url || !Storage::disk('local')->exists('pdf_receipts/' . $order->receipt_url)) {
            return back()->with('error', 'O recibo não está disponível.');
        }

        return Storage::disk('local')->download('pdf_receipts/' . $order->receipt_url, $order->receipt_url, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    // ==========================================
    // BACKOFFICE (ADMIN / FUNCIONÁRIOS)
    // ==========================================

    public function index()
    {
        // O Eloquent (Modelo) vai buscar as encomendas e junta automaticamente os dados do cliente
        $orders = Order::with('customer.user')
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['orderItems.tshirtImage', 'orderItems.color', 'customer.user']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:20',
            'reason' => 'nullable|string',
        ]);

        $order->status = $validated['status'];

        if ($validated['status'] === 'canceled' && $request->filled('reason')) {
            $order->reason_for_cancellation = $validated['reason'];
        }

        $order->save();

        return back()->with('success', 'Estado da encomenda atualizado com sucesso!');
    }
}