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

                <div class="flex items-center space-x-6 text-sm font-medium">
                    <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-black transition p-1"
                        title="Ver Carrinho">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>

                        @php
                            // Somar todas as quantidades de itens no carrinho da sessão
                            $cartCount = 0;
                            foreach (session('cart', []) as $item) {
                                $cartCount += $item['quantity'];
                            }
                        @endphp

                        @if($cartCount > 0)
                            <span
                                class="absolute -top-1 -right-1 bg-black text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <span class="text-gray-200">|</span>

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
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-4">

        <h1 class="text-3xl font-bold uppercase tracking-wide mb-6">
            T-Shirts Estampadas <span class="text-gray-400 text-lg font-normal">[{{ $tshirts->count() }}]</span>
        </h1>

        <div class="border-b border-gray-200 mb-6 relative group">

            <button onclick="document.getElementById('category-scroll').scrollBy({ left: -250, behavior: 'smooth' })"
                class="absolute left-0 top-0 bottom-2 z-10 flex items-center bg-gradient-to-r from-white via-white to-transparent pr-6 text-gray-300 hover:text-black transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>

            <div id="category-scroll" class="flex space-x-8 overflow-x-auto text-sm pb-3 px-8 hide-scrollbar">
                <a href="{{ route('catalog.index') }}"
                    class="whitespace-nowrap pb-1 {{ !request('category') ? 'font-bold border-b-2 border-black text-black' : 'text-gray-500 hover:text-black transition' }}">
                    Todas as Imagens
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('catalog.index', ['category' => $category->id]) }}"
                        class="whitespace-nowrap pb-1 {{ request('category') == $category->id ? 'font-bold border-b-2 border-black text-black' : 'text-gray-500 hover:text-black transition' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <button onclick="document.getElementById('category-scroll').scrollBy({ left: 250, behavior: 'smooth' })"
                class="absolute right-0 top-0 bottom-2 z-10 flex items-center bg-gradient-to-l from-white via-white to-transparent pl-6 text-gray-300 hover:text-black transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>

        </div>
    </div>

    <main class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

            @foreach ($tshirts as $tshirt)
                <a href="{{ route('catalog.show', $tshirt->id) }}" class="group cursor-pointer flex flex-col h-full">

                    <div class="relative bg-[#EBEDEE] aspect-[3/5] overflow-hidden">
                        <img src="{{ asset('storage/tshirt_images/' . $tshirt->image_url) }}" alt="{{ $tshirt->name }}"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700">

                        <button class="absolute top-3 right-3 text-gray-500 hover:text-black transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </button>
                    </div>

                    <div class="pt-4 flex flex-col">
                        <h1 class="text-sm font-bold text-gray-800 truncate">{{ $tshirt->name }}</h1>

                        @if($tshirt->description)
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $tshirt->description }}</p>
                        @endif

                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-sm font-bold text-gray-900">
                                € {{ number_format($priceConfig->unit_price_catalog, 2, ',', '') }}
                            </span>

                            <button class="text-gray-400 hover:text-black transition" title="Adicionar ao Carrinho">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </a>
            @endforeach

        </div>
    </main>

    <style>
        /* Esconder a scrollbar no Chrome, Safari e Opera */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Esconder a scrollbar no IE, Edge e Firefox */
        .hide-scrollbar {
            -ms-overflow-style: none;
            /* IE e Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
</body>

</html>