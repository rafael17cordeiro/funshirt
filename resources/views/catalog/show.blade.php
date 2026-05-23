<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunShirt</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-white font-sans antialiased">

    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('catalog.index') }}" class="text-2xl font-black tracking-tighter">
                        FUNSHIRT
                    </a>
                </div>

                <div class="flex items-center text-sm font-medium">
                    @auth
                        <a href="{{ route('dashboard') }}" class="hover:underline underline-offset-4">A Minha Conta</a>
                    @else
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}" class="hover:underline underline-offset-4">Entrar</a>
                            <span class="text-gray-300 font-light">|</span>
                            <a href="{{ route('register') }}" class="hover:underline underline-offset-4">Criar Conta</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="text-xs uppercase tracking-widest text-gray-500 mb-8">
            <a href="{{ route('catalog.index') }}"
                class="hover:text-black hover:underline underline-offset-4 transition">Voltar ao Catálogo</a>
            <span class="mx-2">/</span>
            <span class="text-black font-bold">{{ $tshirt->name }}</span>
        </div>

        @if(session('success'))
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50); setTimeout(() => show = false, 5000)"
                x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-8"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform translate-x-8"
                class="fixed bottom-6 right-6 bg-white p-4 shadow-xl rounded-lg border border-gray-100 border-l-4 border-l-green-500 flex items-start space-x-4 z-50 w-full max-w-sm">

                <div class="flex-shrink-0 pt-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="w-6 h-6 text-green-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="flex-1">
                    <p class="text-sm font-black uppercase tracking-wider text-gray-950 mb-0.5">Adicionado</p>
                    <p class="text-xs text-gray-600 mb-2">{{ session('success') }}</p>
                    <a href="{{ route('cart.index') }}"
                        class="text-xs font-bold uppercase tracking-wider text-black underline underline-offset-4 hover:text-gray-600 transition">
                        Ver Carrinho &rarr;
                    </a>
                </div>

                <button @click="show = false" class="text-gray-400 hover:text-black transition flex-shrink-0 -mr-1 -mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20">

            <div class="bg-[#EBEDEE] relative aspect-[4/5] overflow-hidden">
                <img src="{{ asset('storage/tshirt_images/' . $tshirt->image_url) }}" alt="{{ $tshirt->name }}"
                    class="w-full h-full object-cover object-center">
            </div>

            <div class="flex flex-col justify-center">
                <h1 class="text-4xl font-black uppercase tracking-tight text-gray-900 mb-2">
                    {{ $tshirt->name }}
                </h1>

                <p class="text-2xl font-bold text-gray-900 mb-6">
                    € {{ number_format($priceConfig->unit_price_catalog, 2, ',', '') }}
                </p>

                @if($tshirt->description)
                    <p class="text-gray-600 text-sm mb-10 leading-relaxed">
                        {{ $tshirt->description }}
                    </p>
                @endif

                <form action="{{ route('cart.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="tshirt_image_id" value="{{ $tshirt->id }}">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="size"
                                class="block text-xs font-bold uppercase text-gray-700 mb-2">Tamanho</label>
                            <select id="size" name="size"
                                class="w-full border-gray-300 rounded-none focus:ring-black focus:border-black text-sm uppercase"
                                required>
                                <option value="" disabled selected>Selecionar</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select>
                        </div>

                        <div>
                            <label for="color_code" class="block text-xs font-bold uppercase text-gray-700 mb-2">Cor da
                                Base</label>
                            <select id="color_code" name="color_code"
                                class="w-full border-gray-300 rounded-none focus:ring-black focus:border-black text-sm uppercase"
                                required>
                                <option value="" disabled selected>Selecionar</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->code }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="quantity"
                            class="block text-xs font-bold uppercase text-gray-700 mb-2">Quantidade</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="50"
                            class="w-24 border-gray-300 rounded-none focus:ring-black focus:border-black text-center"
                            required>
                    </div>

                    <button type="submit"
                        class="w-full bg-black text-white font-bold uppercase tracking-wide py-4 mt-4 hover:bg-gray-800 transition duration-300 flex justify-center items-center space-x-3">
                        <span>Adicionar ao Carrinho</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </button>
                </form>

            </div>
        </div>
    </main>

</body>

</html>