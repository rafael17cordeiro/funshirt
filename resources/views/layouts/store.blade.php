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

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
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
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-4 hover:opacity-80 transition group">
                            @if(Auth::user()->photo_url)
                                <img src="{{ asset('storage/photos/' . Auth::user()->photo_url) }}" alt="Avatar"
                                    class="w-8 h-8 rounded-full object-cover border border-gray-200 shadow-sm">
                            @else
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 shadow-sm border border-gray-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            @endif
                            <span class="flex items-center group-hover:underline underline-offset-4 font-medium">A Minha
                                Conta</span>
                        </a>
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

    @if (session('payment_success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 9000)"
            x-transition:enter="opacity-0 transform translate-x-8"
            x-transition:enter-start="opacity-0 transform translate-x-8"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-8"
            class="fixed bottom-6 right-6 bg-white p-4 shadow-xl rounded-lg border border-gray-100 border-l-4 border-l-green-500 flex flex-col z-50 w-full max-w-sm">
            
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 pt-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="w-6 h-6 text-green-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="flex-1">
                    <p class="text-sm font-black uppercase tracking-wider text-gray-950 mb-0.5">Pagamento efetuado</p>
                    <p class="text-xs text-gray-600">{{ session('payment_success') }}</p>
                </div>

                <button @click="show = false" class="text-gray-400 hover:text-gray-500 transition-colors">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule=\"evenodd\" />
                    </svg>
                </button>
            </div>

            @if(session('new_order_id'))
                <div class="mt-4">
                    <a href="{{ route('customer.orders.show', session('new_order_id')) }}" 
                    class="block w-full text-center bg-gray-950 hover:bg-gray-800 text-white text-xs font-bold uppercase tracking-widest py-3 px-4 rounded transition-colors duration-200">
                        Ver Encomenda #{{ session('new_order_id') }}
                    </a>
                </div>
            @endif
        </div>
    @endif

    @if(session('payment_error'))
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50); setTimeout(() => show = false, 5000)"
            x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-8"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-8"
            class="fixed bottom-6 right-6 bg-white p-4 shadow-xl rounded-lg border border-gray-100 border-l-4 border-l-red-500 flex items-start space-x-4 z-50 w-full max-w-sm">

            <div class="flex-shrink-0 pt-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-6 h-6 text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div class="flex-1">
                <p class="text-sm font-black uppercase tracking-wider text-gray-950 mb-0.5">Falha no pagamento</p>
                <p class="text-xs text-gray-600">{{ session('payment_error') }}</p>
            </div>

            <button @click="show = false" class="text-gray-400 hover:text-black transition flex-shrink-0 -mr-1 -mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif


    @yield('content')

</body>

</html>