<x-app-layout>
    <x-slot name="header">
        {{ __('As Minhas Encomendas') }}
    </x-slot>

    <div class="py-4">
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
                                <th scope="col"
                                    class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider">Nº
                                    Encomenda</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider">Data
                                </th>
                                <th scope="col"
                                    class="px-8 py-4 text-left font-bold text-gray-900 uppercase tracking-wider">Estado
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider">Total
                                </th>
                                <th scope="col"
                                    class="px-10 py-4 text-right font-bold text-gray-900 uppercase tracking-wider">Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                        #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap text-gray-600">
                                        @if($order->created_at)
                                            {{ $order->created_at->format('d/m/Y H:i') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($order->status == 'pending')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">Enviada</span>
                                        @elseif($order->status == 'closed')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Entregue</span>
                                        @elseif($order->status == 'canceled')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Cancelada</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                        {{ number_format($order->total_price, 2, ',', ' ') }} €
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-3">
                                            <a href="{{ route('customer.orders.show', $order->id) }}"
                                                class="text-gray-400 hover:text-indigo-600 transition-colors"
                                                title="Ver Detalhes">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </a>
                                        </div>
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