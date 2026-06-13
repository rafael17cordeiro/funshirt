<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes da Encomenda #' . str_pad($order->id, 5, '0', STR_PAD_LEFT)) }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">
                        Encomenda #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Submetida em
                        @if($order->created_at)
                            {{ $order->created_at->format('d/m/Y \à\s H:i') }}
                        @else
                            {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}
                        @endif
                    </p>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                    class="inline-flex items-center px-4 py-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm font-bold">
                    &larr; <span class="ml-2">Voltar à Lista</span>
                </a>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Produtos Encomendados
                            </h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-500 font-semibold">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 uppercase tracking-wider">Produto / Estampa
                                        </th>
                                        <th scope="col" class="px-6 py-4 uppercase tracking-wider">Cor</th>
                                        <th scope="col" class="px-6 py-4 text-center uppercase tracking-wider">Tam.</th>
                                        <th scope="col" class="px-6 py-4 text-center uppercase tracking-wider">Qtd.</th>
                                        <th scope="col" class="px-6 py-4 text-right uppercase tracking-wider">Preço Un.
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-right uppercase tracking-wider">Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($order->orderItems as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">

                                            <td class="px-6 py-4 font-bold text-gray-900">
                                                {{ $item->tshirtImage->name ?? 'Estampa Personalizada' }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-2">
                                                    @if($item->color)
                                                        @php
                                                            $itemColor = $item->color->code;
                                                            if (preg_match('/^[a-fA-F0-9]{3,6}$/', $itemColor)) {
                                                                $itemColor = '#' . $itemColor;
                                                            }
                                                        @endphp
                                                        <div class="w-4 h-4 rounded-full border border-gray-200 shadow-sm"
                                                            style="background-color: {{ $itemColor }};"
                                                            title="{{ $item->color->code }}"></div>
                                                        <span
                                                            class="text-xs font-medium text-gray-600">{{ $item->color->name }}</span>
                                                    @else
                                                        <span class="text-xs font-medium text-gray-400">N/A</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="px-2.5 py-1 bg-gray-100 text-gray-700 font-bold rounded text-xs">
                                                    {{ strtoupper($item->size) }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 text-center font-semibold text-gray-600">
                                                {{ $item->qty }}
                                            </td>

                                            <!-- Preço Unitário: Tirámos o font-medium, adicionei font-normal -->
                                            <td
                                                class="px-6 py-4 text-right font-normal {{ $order->status == 'canceled' ? 'text-red-500' : 'text-green-600' }}">
                                                {{ number_format($item->unit_price, 2, ',', ' ') }} €
                                            </td>

                                            <!-- Subtotal: Tirámos o font-black, adicionei font-normal -->
                                            <td
                                                class="px-6 py-4 text-right font-normal {{ $order->status == 'canceled' ? 'text-red-600' : 'text-green-600' }}">
                                                {{ number_format($item->sub_total, 2, ',', ' ') }} €
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">
                                                Nenhum item encontrado nesta encomenda.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="p-6 bg-gray-50/50 border-t border-gray-100 flex justify-end">
                            <div class="text-right space-y-1">
                                <span class="text-xs uppercase tracking-wider text-gray-500 font-bold">Total da
                                    Encomenda</span>
                                <!-- Total Final: Tirámos o font-black, adicionei font-normal -->
                                <div
                                    class="text-3xl font-normal tracking-tight {{ $order->status == 'canceled' ? 'text-red-600' : 'text-green-600' }}">
                                    {{ number_format($order->total_price, 2, ',', ' ') }} €
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden"
                        x-data="{ showCancelForm: false }">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Estado / Ações
                            </h3>
                        </div>

                        <div class="p-6">
                            <div class="mb-6">
                                @if($order->status == 'pending')
                                    <span
                                        class="w-full justify-center inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-bold bg-yellow-100 text-yellow-800">
                                        Pendente de Pagamento
                                    </span>
                                @elseif($order->status == 'paid')
                                    <span
                                        class="w-full justify-center inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-bold bg-blue-100 text-blue-800">
                                        Paga / Em Processamento
                                    </span>
                                @elseif($order->status == 'closed')
                                    <span
                                        class="w-full justify-center inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-bold bg-green-100 text-green-800">
                                        Fechada / Enviada
                                    </span>
                                @elseif($order->status == 'canceled')
                                    <span
                                        class="w-full justify-center inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-bold bg-red-100 text-red-800">
                                        Anulada
                                    </span>
                                @endif
                            </div>

                            @if($order->status == 'canceled' && !empty($order->reason_for_cancellation))
                                <div class="mb-4 p-4 bg-red-50 border border-red-100 rounded-lg text-xs text-red-700">
                                    <span class="font-black block uppercase tracking-wider mb-1.5 text-red-800">Motivo do
                                        Cancelamento:</span>
                                    "{{ $order->reason_for_cancellation }}"
                                </div>
                            @endif

                            @if(in_array($order->status, ['pending', 'paid']))
                                <div class="space-y-3" x-show="!showCancelForm">

                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST"
                                        onsubmit="return confirm('Deseja marcar esta encomenda como Concluída/Fechada?');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="closed">
                                        <button type="submit"
                                            class="w-full px-4 py-2.5 text-sm font-bold text-white bg-green-600 hover:bg-green-700 rounded-lg shadow-sm transition flex items-center justify-center">
                                            ✓ CONCLUIR ENCOMENDA
                                        </button>
                                    </form>

                                    @if(auth()->user()->user_type === 'A')
                                        <button @click="showCancelForm = true" type="button"
                                            class="w-full px-4 py-2.5 text-sm font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition flex items-center justify-center">
                                            ✕ ANULAR ENCOMENDA
                                        </button>
                                    @endif
                                </div>

                                <div x-show="showCancelForm" x-transition
                                    class="space-y-3 p-4 bg-gray-50 border border-gray-100 rounded-lg">
                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="canceled">

                                        <label for="reason"
                                            class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">
                                            Justificação Obrigatória:
                                        </label>
                                        <textarea id="reason" name="reason" rows="3" required
                                            class="w-full text-sm border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm p-3 mb-3"
                                            placeholder="Escreva aqui o motivo..."></textarea>

                                        @error('reason')
                                            <p class="text-xs font-semibold text-red-600 mb-3">{{ $message }}</p>
                                        @enderror

                                        <div class="flex space-x-2">
                                            <button type="submit"
                                                class="flex-1 px-4 py-2 text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg transition uppercase shadow-sm">
                                                Confirmar Anulação
                                            </button>
                                            <button @click="showCancelForm = false; $id('reason').value = ''" type="button"
                                                class="px-4 py-2 text-xs font-bold text-gray-600 bg-gray-200 hover:bg-gray-300 rounded-lg transition uppercase">
                                                Cancelar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Dados de Entrega
                            </h3>
                        </div>
                        <div class="p-6 space-y-4 text-sm">
                            <div>
                                <span
                                    class="block text-[11px] uppercase text-gray-400 font-bold tracking-wider mb-1">Cliente</span>
                                <span class="font-bold text-gray-900">{{ $order->customer->user->name ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span
                                    class="block text-[11px] uppercase text-gray-400 font-bold tracking-wider mb-1">Email
                                    de Contacto</span>
                                <span
                                    class="text-gray-600 font-medium">{{ $order->customer->user->email ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span
                                    class="block text-[11px] uppercase text-gray-400 font-bold tracking-wider mb-1">NIF</span>
                                <span
                                    class="text-gray-900 font-bold font-mono">{{ $order->nif ?? $order->customer->nif ?? 'Consumidor Final' }}</span>
                            </div>
                            <hr class="border-gray-100">
                            <div>
                                <span
                                    class="block text-[11px] uppercase text-gray-400 font-bold tracking-wider mb-2">Morada
                                    de Envio</span>
                                <p
                                    class="text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-lg border border-gray-100 font-medium">
                                    {{ $order->address ?? $order->customer->address ?? 'Não fornecida' }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>