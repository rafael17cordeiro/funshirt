<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Procura as encomendas paginadas (15 por página) da mais recente para a mais antiga
        // Carrega também a relação com o utilizador/cliente para evitar consultas repetidas (N+1 problem)
        $orders = Order::with('customer.user')->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Carrega as relações necessárias para os detalhes.
        // Assumi que a relação para os itens se chama 'orderItems' ou 'items'. Ajusta se necessário!
        // Carrega também a estampa (tshirtImage) e a cor se estiverem associadas ao item.
        $order->load(['customer.user', 'orderItems.tshirtImage', 'orderItems.color']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        // 1. Validar o estado enviado
        $request->validate([
            'status' => 'required|in:closed,canceled',
            'reason' => 'required_if:status,canceled|nullable|string|min:5'
        ], [
            'reason.required_if' => 'É obrigatório introduzir uma justificação para anular a encomenda.',
            'reason.min' => 'A justificação deve ter pelo menos 5 caracteres.'
        ]);

        $newStatus = $request->status;
        $userType = auth()->user()->user_type;

        // 2. Proteção de Segurança (Apenas Admin 'A' pode cancelar)
        if ($newStatus === 'canceled' && $userType !== 'A') {
            return back()->withErrors(['error' => 'Apenas os Administradores podem anular encomendas.']);
        }

        // 3. Atualizar a encomenda
        $order->status = $newStatus;

        // Se for anulada, gravamos a justificação. 
        // Assumi que a coluna na base de dados se chama 'reason' ou 'notes'. Ajusta se necessário!
        if ($newStatus === 'canceled') {
            $order->reason_for_cancellation = $request->reason;
        }

        $order->save();

        // Mensagem de sucesso para o nosso Toast animado
        $statusPt = $newStatus === 'closed' ? 'concluída' : 'anulada';
        return redirect()->route('admin.orders.index')
            ->with('success', "Encomenda #{$order->id} foi {$statusPt} com sucesso!");
    }

    public function myOrders()
    {
        // Vai buscar APENAS as encomendas cujo cliente é o utilizador autenticado
        $orders = Order::where('customer_id', auth()->id())
            ->with('orderItems') // Carrega os itens caso queiras mostrar resumos
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }
}