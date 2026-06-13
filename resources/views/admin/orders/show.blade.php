<x-app-layout>
    <x-slot name="header">
        {{ __('Detalhes da Encomenda #' . str_pad($order->id, 5, '0', STR_PAD_LEFT)) }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">
                        Encomenda #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">Submetida em
                        @if($order->created_at)
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        @else
                            {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}
                        @endif
                    </p>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors shadow-sm font-medium">
                    &larr; Voltar à Lista
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6 border-b border-gray-200 bg-gray-50/50">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900">Produtos Encomendados
                            </h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200 text-sm">
                                <thead>
                                    <tr class="text-gray-500 font-bold uppercase tracking-wider text-xs bg-gray-50/50">
                                        <th scope="col" class="px-6 py-3 text-left">Produto / Estampa</th>
                                        <th scope="col" class="px-6 py-3 text-left">Cor</th>
                                        <th scope="col" class="px-6 py-3 text-center">Tam.</th>
                                        <th scope="col" class="px-6 py-3 text-center">Qtd.</th>
                                        <th scope="col" class="px-6 py-3 text-right">Preço Un.</th>
                                        <th scope="col" class="px-6 py-3 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                                    @forelse($order->orderItems as $item)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="px-6 py-4 font-medium text-gray-900">
                                                {{ $item->tshirtImage->name ?? 'Estampa Personalizada' }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-2">
                                                    @if($item->color)
                                                        @php
                                                            $itemColor = $item->color->code;
                                                            // Se for um código hexadecimal sem o '#', nós adicionamos automaticamente
                                                            if (preg_match('/^[a-fA-F0-9]{3,6}$/', $itemColor)) {
                                                                $itemColor = '#' . $itemColor;
                                                            }
                                                        @endphp
                                                        <div class="w-4 h-4 rounded-full border border-gray-300 shadow-sm"
                                                            style="background-color: {{ $itemColor }};"
                                                            title="{{ $item->color->code }}"></div>
                                                        <span class="text-xs text-gray-600">{{ $item->color->name }}</span>
                                                    @else
                                                        <span class="text-xs text-gray-400">N/A</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 text-center font-mono font-bold text-gray-900">
                                                {{ strtoupper($item->size) }}
                                            </td>

                                            <td class="px-6 py-4 text-center text-gray-600">
                                                {{ $item->qty }}
                                            </td>

                                            <td class="px-6 py-4 text-right font-medium text-gray-500">
                                                {{ number_format($item->unit_price, 2, ',', ' ') }} €
                                            </td>

                                            <td class="px-6 py-4 text-right font-bold text-gray-900">
                                                {{ number_format($item->sub_total, 2, ',', ' ') }} €
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                                Nenhum item encontrado nesta encomenda.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-end">
                            <div class="text-right space-y-1">
                                <span class="text-xs uppercase tracking-wider text-gray-500 font-medium">Total da
                                    Encomenda</span>
                                <div class="text-2xl font-black text-gray-950">
                                    {{ number_format($order->total_price, 2, ',', ' ') }} €
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">

                    <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-200"
                        x-data="{ showCancelForm: false }">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">Estado da Encomenda
                        </h3>

                        <div class="mb-4">
                            @if($order->status == 'pending')
                                <span
                                    class="w-full justify-center inline-flex items-center px-3 py-2 rounded-md text-sm font-bold bg-yellow-100 text-yellow-800">
                                    Pendente de Pagamento
                                </span>
                            @elseif($order->status == 'paid')
                                <span
                                    class="w-full justify-center inline-flex items-center px-3 py-2 rounded-md text-sm font-bold bg-blue-100 text-blue-800">
                                    Paga / Em Processamento
                                </span>
                            @elseif($order->status == 'closed')
                                <span
                                    class="w-full justify-center inline-flex items-center px-3 py-2 rounded-md text-sm font-bold bg-green-100 text-green-800">
                                    Fechada / Enviada
                                </span>
                            @elseif($order->status == 'canceled')
                                <span
                                    class="w-full justify-center inline-flex items-center px-3 py-2 rounded-md text-sm font-bold bg-red-100 text-red-800">
                                    Anulada
                                </span>
                            @endif
                        </div>

                        @if($order->status == 'canceled' && !empty($order->reason_for_cancellation))
                            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-xs text-red-700">
                                <span class="font-bold block uppercase tracking-wider mb-1">Motivo do Cancelamento:</span>
                                "{{ $order->reason_for_cancellation }}"
                            </div>
                        @endif

                        @if(in_array($order->status, ['pending', 'paid']))
                            <div class="space-y-2 mt-4 pt-4 border-t border-gray-100" x-show="!showCancelForm">

                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST"
                                    onsubmit="return confirm('Deseja marcar esta encomenda como Concluída/Fechada?');">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="closed">
                                    <button type="submit"
                                        class="w-full px-4 py-2 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 rounded-md shadow-sm transition flex items-center justify-center">
                                        ✓ CONCLUIR ENCOMENDA
                                    </button>
                                </form>

                                @if(auth()->user()->user_type === 'A')
                                    <button @click="showCancelForm = true" type="button"
                                        class="w-full px-4 py-2 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-md transition flex items-center justify-center">
                                        ✕ ANULAR ENCOMENDA
                                    </button>
                                @endif
                            </div>

                            <div x-show="showCancelForm" x-transition class="mt-4 pt-4 border-t border-gray-100 space-y-3">
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="canceled">

                                    <label for="reason"
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Justificação Obrigatória:
                                    </label>
                                    <textarea id="reason" name="reason" rows="3" required
                                        class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm p-2"
                                        placeholder="Escreva aqui o motivo do cancelamento..."></textarea>

                                    @error('reason')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror

                                    <div class="flex space-x-2 mt-2">
                                        <button type="submit"
                                            class="flex-1 px-4 py-2 text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded transition uppercase shadow-sm">
                                            Confirmar Anulação
                                        </button>
                                        <button @click="showCancelForm = false; $id('reason').value = ''" type="button"
                                            class="px-3 py-2 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded transition uppercase">
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
                        <div class="p-4 border-b border-gray-200 bg-gray-50/50">
                            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-900">Dados de Entrega</h3>
                        </div>
                        <div class="p-6 space-y-4 text-sm">
                            <div>
                                <span
                                    class="block text-xs uppercase text-gray-400 font-semibold tracking-wider">Cliente</span>
                                <span
                                    class="font-medium text-gray-900">{{ $order->customer->user->name ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs uppercase text-gray-400 font-semibold tracking-wider">Email
                                    de Contacto</span>
                                <span class="text-gray-600">{{ $order->customer->user->email ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span
                                    class="block text-xs uppercase text-gray-400 font-semibold tracking-wider">NIF</span>
                                <span
                                    class="text-gray-900 font-mono">{{ $order->nif ?? $order->customer->nif ?? 'Consumidor Final' }}</span>
                            </div>
                            <hr class="border-gray-100">
                            <div>
                                <span class="block text-xs uppercase text-gray-400 font-semibold tracking-wider">Morada
                                    de Envio</span>
                                <p
                                    class="text-gray-700 mt-1 leading-relaxed bg-gray-50 p-3 rounded border border-gray-200 font-sans">
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