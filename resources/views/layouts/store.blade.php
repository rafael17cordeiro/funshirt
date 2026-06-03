<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunShirt</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
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
                    <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-black transition p-1" title="Ver Carrinho">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>

                        @php
                            $cartCount = 0;
                            foreach (session('cart', []) as $item) {
                                $cartCount += $item['quantity'];
                            }
                        @endphp

                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-black text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <span class="text-gray-200">|</span>

                    @auth
                        @if(Auth::user()->user_type === 'A')
                            <a href="{{ route('admin.categories.index') }}" class="text-xs uppercase tracking-widest text-zinc-500 hover:text-zinc-950 font-medium transition">
                                Gestão (Admin)
                            </a>
                        @endif
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

    @yield('content')

</body>
</html>