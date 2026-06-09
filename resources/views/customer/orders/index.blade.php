<x-app-layout>
    <x-slot name="header">
        {{ __('As Minhas Encomendas') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Histórico de Compras</h2>
                    <p class="mt-1 text-sm text-gray-600">Acompanha o estado das tuas encomendas e faturas.</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th scope="col" class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider">Nº Encomenda</th>
                                <th scope="col" class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider">Data</th>
                                <th scope="col" class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-4 text-right font-bold text-gray-900 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                        #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                        @if(!empty($order->created_at))
                                            {{ date('d/m/Y', strtotime($order->created_at)) }} às {{ date('H:i', strtotime($order->created_at)) }}
                                        @else
                                            Data indisponível
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($order->status == 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pendente</span>
                                        @elseif($order->status == 'paid')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Em Processamento</span>
                                        @elseif($order->status == 'closed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Enviada</span>
                                        @elseif($order->status == 'canceled')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Anulada</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                        {{ number_format($order->total_price, 2, ',', ' ') }} €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('customer.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">
                                            Ver Detalhes
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        Ainda não realizaste nenhuma encomenda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>