@extends('layouts.store')

@section('content')
    <main class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-black uppercase tracking-tight text-gray-900 mb-10 border-b border-gray-100 pb-4">
            Finalizar Encomenda
        </h1>

        @if (session('error'))
            <div style="padding: 16px; background-color: #FEE2E2; border: 1px solid #EF4444; color: #991B1B; border-radius: 4px; margin-bottom: 24px; font-weight: bold; text-transform: uppercase; font-size: 0.875rem;">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="padding: 16px; background-color: #FFFBEB; border: 1px solid #F59E0B; color: #92400E; border-radius: 4px; margin-bottom: 24px;">
                <p class="font-black uppercase text-sm mb-2">⚠️ Erro de Validação nos Campos:</p>
                <ul class="list-disc pl-5 text-xs font-bold space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="lg:grid lg:grid-cols-12 lg:gap-12 lg:items-start">
            
            <div class="lg:col-span-7 bg-white p-6 border border-gray-200 rounded shadow-sm">
                <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <h2 class="text-lg font-black uppercase text-gray-950 tracking-wide border-b border-gray-200 pb-2 mb-6">
                        Dados de Faturação e Envio
                    </h2>

                    <div class="mb-5">
                        <label for="address" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                            Morada de Envio *
                        </label>
                        <input type="text" id="address" name="address" 
                            value="{{ old('address', $customer->address ?? '') }}" required
                            style="width: 100%; padding: 12px; border: 1px solid #D1D5DB; border-radius: 4px; background-color: #F9FAFB;"
                            class="block w-full rounded border border-gray-300 font-medium text-sm text-gray-900 focus:border-black focus:ring-1 focus:ring-black">
                    </div>

                    <div class="mb-5">
                        <label for="nif" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                            NIF (Número de Identificação Fiscal)
                        </label>
                        <input type="text" id="nif" name="nif" maxlength="9"
                            value="{{ old('nif', $customer->nif ?? '') }}"
                            style="width: 100%; padding: 12px; border: 1px solid #D1D5DB; border-radius: 4px; background-color: #F9FAFB;"
                            class="block w-full rounded border border-gray-300 font-medium text-sm text-gray-900 focus:border-black focus:ring-1 focus:ring-black"
                            placeholder="Ex: 123456789">
                    </div>

                    <div class="mb-5">
                        <label for="payment_type" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                            Escolha o método *
                        </label>
                        <select id="payment_type" name="payment_type" required
                            style="width: 100%; padding: 12px; border: 1px solid #D1D5DB; border-radius: 4px; background-color: #F9FAFB;"
                            class="block w-full rounded border border-gray-300 font-bold text-sm text-gray-900 focus:border-black focus:ring-1 focus:ring-black cursor-pointer">
                            <option value="VISA" {{ (old('payment_type', $customer->default_payment_type ?? '') == 'VISA') ? 'selected' : '' }}>Visa</option>
                            <option value="MBWAY" {{ (old('payment_type', $customer->default_payment_type ?? '') == 'MBWAY') ? 'selected' : '' }}>MB Way</option>
                            <option value="PAYPAL" {{ (old('payment_type', $customer->default_payment_type ?? '') == 'PAYPAL') ? 'selected' : '' }}>PayPal</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label id="payment_label" for="payment_ref" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                            Nº Cartão
                        </label>
                        <input type="text" id="payment_ref" name="payment_ref" 
                            value="{{ old('payment_ref', $customer->default_payment_ref ?? '') }}" required
                            style="width: 100%; padding: 12px; border: 1px solid #D1D5DB; border-radius: 4px; background-color: #F9FAFB;"
                            class="block w-full rounded border border-gray-300 font-medium text-sm text-gray-900 focus:border-black focus:ring-1 focus:ring-black"
                            placeholder="Ex: 4000 1234 5678 9010">
                    </div>

                    <form action="{{ route('checkout.store') }}" method="POST" x-data="{ submetendo: false }" @submit="setTimeout(() => submetendo = true, 10)">
                        @csrf
                        <button type="submit" 
                                :disabled="submetendo" 
                                class="w-full bg-black text-white p-3 uppercase font-bold text-sm tracking-wider hover:bg-gray-600 transition disabled:opacity-50">
                            
                            <span x-show="!submetendo">Finalizar Pagamento</span>
                            <span x-show="submetendo" style="display: none;">A processar pagamento...</span>
                        </button>
                    </form>
                </form>
            </div>

            <div class="lg:col-span-5 mt-10 lg:mt-0 bg-gray-50 p-6 border border-gray-200 rounded">
                <h2 class="text-lg font-black uppercase text-gray-900 mb-6 tracking-wide border-b border-gray-200 pb-2">
                    Resumo dos Artigos
                </h2>
                
                <div class="divide-y divide-gray-200 max-h-[300px] overflow-y-auto pr-2 mb-6">
                    @foreach($cart as $item)
                        <div class="flex py-4 text-sm justify-between items-center">
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 uppercase tracking-tight">{{ $item['name'] }}</p>
                                <p class="text-xs text-gray-500 uppercase mt-1 font-medium">
                                    Tamanho: <span class="text-gray-800 font-bold">{{ $item['size'] }}</span> | 
                                    Cor: <span class="text-gray-800 font-bold">{{ $item['color_code'] }}</span> | 
                                    Qtd: <span class="text-gray-800 font-bold">{{ $item['quantity'] }}</span>
                                </p>
                            </div>
                            <span class="font-bold text-gray-900 ml-4 whitespace-nowrap">
                                € {{ number_format($item['unit_price'] * $item['quantity'], 2, ',', '') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="flex items-center justify-between text-lg font-black text-gray-900">
                        <span class="uppercase tracking-wide">Total a Pagar</span>
                        <span>€ {{ number_format($total, 2, ',', '') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paymentTypeSelect = document.getElementById('payment_type');
            const paymentLabel = document.getElementById('payment_label');
            const paymentRefInput = document.getElementById('payment_ref');

            function updatePaymentFields() {
                const selectedMethod = paymentTypeSelect.value;

                if (selectedMethod === 'VISA') {
                    paymentLabel.innerText = 'Número do Cartão';
                    paymentRefInput.placeholder = 'Ex: 4000 1234 5678 9010';
                    paymentRefInput.type = 'text';
                } else if (selectedMethod === 'MBWAY') {
                    paymentLabel.innerText = 'Número de Telemóvel MBWay';
                    paymentRefInput.placeholder = 'Ex: 912345678';
                    paymentRefInput.type = 'text';
                } else if (selectedMethod === 'PAYPAL') {
                    paymentLabel.innerText = 'Email PayPal';
                    paymentRefInput.placeholder = 'Ex: exemplo@paypal.com';
                    paymentRefInput.type = 'email';
                }
            }

            // Executa imediatamente ao carregar para caso já venha algo selecionado do banco/old
            updatePaymentFields();

            // Ouve as alterações do dropdown
            paymentTypeSelect.addEventListener('change', updatePaymentFields);
        });
    </script>
@endsection