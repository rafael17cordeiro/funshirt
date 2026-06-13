@extends('layouts.store')

@section('content')
    <main class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-10 border-b border-gray-100 pb-4">
            <h1 class="text-3xl font-black uppercase tracking-tight text-gray-900">O Meu Carrinho</h1>
            
            @if(count($cart) > 0)
                <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja esvaziar o carrinho?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs uppercase font-bold tracking-wider text-red-500 hover:text-red-700 transition duration-200 flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                        <span>Esvaziar Carrinho</span>
                    </button>
                </form>
            @endif
        </div>

        @if(count($cart) > 0)
            <div class="lg:grid lg:grid-cols-12 lg:gap-12 lg:items-start">

                <div class="lg:col-span-8">
                    <div class="border-t border-gray-200">
                        @foreach($cart as $key => $item)
                            <div class="flex items-start py-6 border-b border-gray-200">
    
                                <div class="h-32 w-24 flex-shrink-0 bg-[#EBEDEE] relative aspect-[3/5] overflow-hidden rounded">
                                    <img src="{{ asset('storage/tshirt_images/' . $item['image_url']) }}"
                                        alt="{{ $item['name'] }}" class="h-full w-full object-cover object-center">
                                </div>

                                <div class="ml-6 flex flex-1 flex-col justify-between min-h-[128px]">
                                    
                                    <div>
                                        <div class="flex justify-between text-base font-bold text-gray-900">
                                            <h3 class="uppercase tracking-wide">{{ $item['name'] }}</h3>
                                            <p class="ml-4 font-extrabold text-gray-900">
                                                €{{ number_format($item['unit_price'] * $item['quantity'], 2, ',', '') }}
                                            </p>
                                        </div>
                                        
                                        <p class="mt-1 text-sm text-gray-500 uppercase font-medium tracking-wide">
                                            Tamanho: <span class="text-gray-900 font-bold">{{ $item['size'] }}</span> | 
                                            Cor: <span class="text-gray-900 font-bold">{{ $item['color_name']}}</span>
                                        </p>
                                    </div>
                                    
                                    <div class="flex items-center justify-between text-sm mt-4">
                                        
                                        <div class="flex items-center space-x-2">  
                                            <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-center space-x-2">
                                                @csrf
                                                @method('PUT')

                                                <select name="size" onchange="this.form.submit()" class="text-xs border    w-10 border-gray-300 rounded p-1 bg-white focus:ring-1 focus:ring-black focus:outline-none font-medium">
                                                    @foreach(['XS', 'S', 'M', 'L', 'XL'] as $s)
                                                        <option value="{{ $s }}" {{ $item['size'] == $s ? 'selected' : '' }}>{{ $s }}</option>
                                                    @endforeach
                                                </select>

                                                <select name="color_code" onchange="this.form.submit()" class="text-xs border border-gray-300 rounded p-1 bg-white focus:ring-1 focus:ring-black focus:outline-none font-medium">
                                                    @foreach($colors as $color)
                                                        <option value="{{ $color->code }}" {{ $item['color_code'] == $color->code ? 'selected' : ' ' }}>
                                                            {{ $color->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <label for="quantity-{{ $key }}" class="text-gray-500 font-bold uppercase text-xs tracking-wider">Qtd:</label>
                                          
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" onchange="this.form.submit()" 
                                                    class="w-12 text-xs border border-gray-300 rounded p-1 text-center focus:ring-1 focus:ring-black focus:outline-none font-bold">
                                            </form>
                                        </div>

                                        <div class="flex items-center pl-4">
                                            <form action="{{ route('cart.destroy', $key) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition p-1" title="Remover Produto">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-4 mt-10 lg:mt-0 bg-gray-50 p-6 border border-gray-100 rounded">
                    <h2 class="text-lg font-black uppercase text-gray-900 mb-6 tracking-wide">Resumo</h2>

                    <div class="flow-root">
                        <dl class="-my-4 text-sm text-gray-600">
                            <div class="flex items-center justify-between py-4">
                                <dt class="uppercase text-xs font-bold tracking-wider">Subtotal</dt>
                                <dd class="font-bold text-gray-900">€ {{ number_format($subtotal, 2, ',', '.') }}</dd>
                            </div>

                            @if($descontoAplicado > 0)
                                <div class="flex items-center justify-between py-4 border-t border-gray-200 text-green-600">
                                    <dt class="uppercase text-xs font-bold tracking-wider">Desconto</dt>
                                    <dd class="font-bold">- € {{ number_format($descontoAplicado, 2, ',', '.') }}</dd>
                                </div>
                            @endif

                            <div class="flex items-center justify-between py-4 border-t border-gray-200 text-lg font-black text-gray-900">
                                <dt class="uppercase">Total Estimado</dt>
                                <dd>€ {{ number_format($totalFinal, 2, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                        class="rounded mt-8 w-full bg-black text-white font-bold uppercase tracking-widest text-sm py-4 flex justify-center hover:bg-gray-800 transition duration-300">
                        Finalizar Encomenda
                    </a>

                    <div class="mt-4 text-center">
                        <a href="{{ route('catalog.index') }}"
                            class="text-xs uppercase font-bold text-gray-500 hover:text-black underline underline-offset-4 transition">
                            Ou continuar a comprar
                        </a>
                    </div>
                </div>

            </div>
        @else
            <div class="text-center py-20">
                <p class="text-gray-500 mb-6 uppercase text-sm font-bold tracking-widest">O teu carrinho está vazio.</p>
                <a href="{{ route('catalog.index') }}"
                    class="inline-block border-2 border-black text-black font-bold uppercase tracking-wide py-3 px-8 hover:bg-black hover:text-white transition duration-300">
                    Descobrir Produtos
                </a>
            </div>
        @endif
    </main>

    @if(session('success'))
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50); setTimeout(() => show = false, 4000)"
            x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-8"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-8"
            class="fixed bottom-6 right-6 bg-white p-4 shadow-xl rounded-lg border border-gray-100 border-l-4 border-l-black flex items-start space-x-4 z-50 w-full max-w-sm">

            <div class="flex-shrink-0 pt-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-6 h-6 text-black">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div class="flex-1">
                <p class="text-sm font-black uppercase tracking-wider text-gray-950 mb-0.5">Sucesso</p>
                <p class="text-xs text-gray-600">{{ session('success') }}</p>
            </div>

            <button @click="show = false" class="text-gray-400 hover:text-black transition flex-shrink-0 -mr-1 -mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif
@endsection