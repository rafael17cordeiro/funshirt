<x-app-layout>
    <x-slot name="header">
        {{ __('Gestão de Preços') }}
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">

        <div class="mb-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Configuração de Preços') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Gestão global das regras de negócio, valores e descontos aplicados na loja.') }}
            </p>
        </div>

        @if(session('success'))
            <div
                class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-sm font-medium rounded-md shadow-sm flex items-center justify-between">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
            <div class="p-6 text-gray-900">

                <form action="{{ route('admin.prices.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Magia Dinâmica: Lê todas as colunas da BD exceto o ID --}}
                        @foreach($price->getAttributes() as $key => $value)
                            @if($key !== 'id')
                                <div>
                                    <x-input-label for="{{ $key }}" :value="ucwords(str_replace('_', ' ', $key))" />

                                    <div class="relative mt-1 shadow-sm rounded-md">
                                        {{-- Só mostra o símbolo do Euro se o nome da coluna contiver a palavra 'price' --}}
                                        @if(str_contains($key, 'price'))
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">€</span>
                                            </div>
                                        @endif

                                        <input type="number" step="0.01" name="{{ $key }}" id="{{ $key }}" value="{{ $value }}"
                                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md sm:text-sm transition-colors @if(str_contains($key, 'price')) pl-7 @endif"
                                            required>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100">
                        <x-primary-button class="bg-black hover:bg-gray-800 px-8">
                            {{ __('Guardar Atualizações') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>