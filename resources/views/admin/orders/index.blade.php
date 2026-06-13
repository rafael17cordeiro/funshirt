<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestão de Encomendas') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Gestão de Encomendas</h2>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Acompanhamento, alteração de estados e faturação
                        das encomendas.</p>
                </div>
            </div>

            @if(session('success'))
                <div x-data="{ show: false }"
                    x-init="setTimeout(() => show = true, 50); setTimeout(() => show = false, 5000)" x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-x-8"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform translate-x-8"
                    class="fixed bottom-6 right-6 bg-white p-4 shadow-xl border border-gray-100 border-l-4 border-l-green-500 flex items-start space-x-4 z-50 w-full max-w-sm rounded-lg">

                    <div class="flex-shrink-0 pt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-6 h-6 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <div class="flex-1">
                        <p class="text-sm font-black uppercase tracking-wider text-gray-900 mb-0.5">Sucesso</p>
                        <p class="text-xs text-gray-500 mb-0">{{ session('success') }}</p>
                    </div>

                    <button type="button" @click="show = false"
                        class="text-gray-400 hover:text-gray-600 transition flex-shrink-0 -mr-1 -mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-semibold">
                            <tr>
                                <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                    Nº Encomenda
                                </th>
                                <th scope="col" class="px-6 py-4 uppercase tracking-wider w-1/3">
                                    Cliente / Data
                                </th>
                                <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-4 text-right uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors">

                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                        #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-gray-900">
                                            {{ $order->customer->user->name ?? 'Cliente Desconhecido' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            @if($order->created_at)
                                                {{ $order->created_at->format('d/m/Y \à\s H:i') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($order->status == 'pending')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                                Pendente
                                            </span>
                                        @elseif($order->status == 'paid')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                Paga
                                            </span>
                                        @elseif($order->status == 'closed')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                Fechada
                                            </span>
                                        @elseif($order->status == 'canceled')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                Anulada
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td
                                        class="px-6 py-4 whitespace-nowrap  {{ $order->status == 'canceled' ? 'text-red-600' : 'text-green-600' }}">
                                        {{ number_format($order->total_price, 2, ',', ' ') }} €
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex justify-end items-center">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 transition-colors"
                                                title="Ver Detalhes">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
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
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-3 text-gray-300"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="text-sm font-medium">Nenhuma encomenda registada no sistema até ao
                                                momento.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>