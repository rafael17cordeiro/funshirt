<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalhes da Encomenda #' . str_pad($order->id, 5, '0', STR_PAD_LEFT)) }}
            </h2>
            <a href="{{ route('customer.orders.index') }}" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded transition shadow-sm">
                ← Voltar ao Histórico
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="border-b border-gray-200 pb-4 mb-6 sm:flex sm:justify-between sm:items-center">
                    <div>
                        <p class="text-sm text-gray-600">Submetida em: <span class="font-semibold text-gray-900">{{ date('d/m/Y', strtotime($order->created_at)) }} às {{ date('H:i', strtotime($order->created_at)) }}</span></p>
                        <p class="text-sm text-gray-600 mt-1">Método de Pagamento: <span class="font-semibold text-gray-900 uppercase">{{ $order->payment_type }}</span></p>
                    </div>
                    <div class="mt-2 sm:mt-0">
                        @if($order->status == 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">Pendente</span>
                        @elseif($order->status == 'paid')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">Em Processamento</span>
                        @elseif($order->status == 'closed')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Enviada</span>
                        @elseif($order->status == 'canceled')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Anulada</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">{{ ucfirst($order->status) }}</span>
                        @endif
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-md font-bold text-gray-900 mb-4 uppercase tracking-wider text-xs text-gray-400">Artigos Adquiridos</h3>
                    <div class="divide-y divide-gray-200 border-t border-b border-gray-100">
                        @foreach($items as $item)
                            <div class="py-4 flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">{{ $item->tshirt_name }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        Tamanho: <span class="font-semibold text-gray-700 uppercase">{{ $item->size }}</span> | 
                                        Cor: <span class="font-semibold text-gray-700">#{{ $item->color_code }}</span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">{{ $item->qty }}x {{ number_format($item->unit_price, 2, ',', ' ') }} €</p>
                                    <p class="text-sm font-bold text-gray-900">{{ number_format($item->sub_total, 2, ',', ' ') }} €</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/70 p-4 rounded-lg border border-gray-100 mb-6">
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Dados de Envio</h4>
                        <p class="text-sm text-gray-800 leading-relaxed"><span class="text-gray-400">Morada:</span> {{ $order->address }}</p>
                        @if(!empty($order->notes))
                            <p class="text-sm text-gray-800 mt-2 leading-relaxed"><span class="text-gray-400">Notas do Cliente:</span> {{ $order->notes }}</p>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Dados de Faturação</h4>
                        <p class="text-sm text-gray-800"><span class="text-gray-400">NIF:</span> {{ $order->nif ?? 'Consumidor Final' }}</p>
                        <p class="text-sm text-gray-800 mt-1"><span class="text-gray-400">Ref. Transação:</span> {{ $order->payment_ref }}</p>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-gray-200 font-bold text-gray-900">
                    <span class="text-sm uppercase tracking-wider text-gray-500">Total Final da Encomenda:</span>
                    <span class="text-2xl font-black text-indigo-600">{{ number_format($order->total_price, 2, ',', ' ') }} €</span>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>