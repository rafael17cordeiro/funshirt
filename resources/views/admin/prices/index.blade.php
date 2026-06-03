@extends('layouts.store')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 font-sans tracking-wide">
    <div class="mb-10 border-b border-zinc-100 pb-4">
        <h1 class="text-2xl font-light text-zinc-900 uppercase tracking-widest">Configuração de Preços</h1>
        <p class="text-xs text-zinc-500 mt-1">Gestão global das regras de negócio, valores e descontos</p>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-zinc-50 border border-zinc-200 text-zinc-800 text-sm tracking-wide rounded-sm flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.prices.update') }}" method="POST" class="bg-white border border-zinc-200 p-8 rounded-sm shadow-sm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Magia Dinâmica: Lê todas as colunas da BD exceto o ID --}}
            @foreach($price->getAttributes() as $key => $value)
                @if($key !== 'id')
                    <div>
                        <label for="{{ $key }}" class="block text-xs uppercase tracking-widest text-zinc-500 font-medium mb-3">
                            {{ ucwords(str_replace('_', ' ', $key)) }}
                        </label>
                        <div class="relative">
                            {{-- Só mostra o símbolo do Euro se o nome da coluna contiver a palavra 'price' --}}
                            @if(str_contains($key, 'price'))
                                <span class="absolute left-4 top-3 text-zinc-400 text-sm font-medium">€</span>
                            @endif
                            
                            <input type="number" 
                                step="0.01"
                                name="{{ $key }}" 
                                id="{{ $key }}" 
                                value="{{ $value }}"
                                class="w-full border border-zinc-200 px-4 py-3 text-sm rounded-sm focus:outline-none focus:border-zinc-950 transition @if(str_contains($key, 'price')) pl-8 @endif"
                                required>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="flex items-center justify-end space-x-4 pt-10 mt-10 border-t border-zinc-100">
            <button type="submit" 
                    class="bg-zinc-950 text-white text-xs uppercase tracking-widest px-8 py-4 hover:bg-zinc-800 transition duration-300 rounded-sm font-medium shadow-md">
                Guardar Atualizações
            </button>
        </div>
    </form>
</div>
@endsection