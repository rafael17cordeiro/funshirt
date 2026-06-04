<aside class="flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-slate-800 border-r border-slate-700">
    <div class="flex flex-col items-center justify-center mb-8">
        <a href="{{ route('dashboard') }}" class="mb-3">
            <span class="text-3xl font-black text-white tracking-widest">FUNSHIRT</span>
        </a>

        @if(auth()->user()->user_type === 'A')
            <span
                class="px-3 py-1 text-[10px] font-bold tracking-widest text-indigo-200 uppercase bg-indigo-900/50 border border-indigo-700 rounded-full">
                Painel Administrativo
            </span>
        @elseif(auth()->user()->user_type === 'F')
            <span
                class="px-3 py-1 text-[10px] font-bold tracking-widest text-emerald-200 uppercase bg-emerald-900/50 border border-emerald-700 rounded-full">
                Painel de Operações
            </span>
        @endif
    </div>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav class="space-y-2">

            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            @if(auth()->user()->user_type === 'C')
                <a href="{{ route('customer.orders.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('customer.orders.index') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    As Minhas Encomendas
                </a>
            @endif

            @if(in_array(auth()->user()->user_type, ['A', 'F']))
                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Encomendas Loja
                </a>
            @endif

            <hr class="border-slate-700 my-4">

            @if(auth()->user()->user_type === 'A')
                <div x-data="{ open: {{ request()->routeIs('admin.clients.*', 'admin.users.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-2.5 text-sm font-medium text-slate-300 rounded-md hover:bg-slate-700 hover:text-white transition-colors">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Utilizadores
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition.opacity class="pl-11 pr-4 py-1 space-y-1">
                        <a href="{{ route('admin.clients.index') }}"
                            class="block py-1.5 text-sm {{ request()->routeIs('admin.clients.*') ? 'text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white' }}">
                            Gestão de Clientes
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="block py-1.5 text-sm {{ request()->routeIs('admin.users.*') ? 'text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white' }}">
                            Colaboradores
                        </a>
                    </div>
                </div>

                <div
                    x-data="{ open: {{ request()->routeIs('admin.categories.*', 'admin.colors.*', 'admin.tshirt_images.*', 'admin.prices.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-2.5 text-sm font-medium text-slate-300 rounded-md hover:bg-slate-700 hover:text-white transition-colors">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Catálogo Loja
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition.opacity class="pl-11 pr-4 py-1 space-y-1">
                        <a href="{{ route('admin.categories.index') }}"
                            class="block py-1.5 text-sm {{ request()->routeIs('admin.categories.*') ? 'text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white' }}">
                            Categorias
                        </a>
                        <a href="{{ route('admin.colors.index') }}"
                            class="block py-1.5 text-sm {{ request()->routeIs('admin.colors.*') ? 'text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white' }}">
                            Cores
                        </a>
                        <a href="{{ route('admin.tshirt_images.index') }}"
                            class="block py-1.5 text-sm {{ request()->routeIs('admin.tshirt_images.*') ? 'text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white' }}">
                            Estampas
                        </a>
                        <a href="{{ route('admin.prices.index') }}"
                            class="block py-1.5 text-sm {{ request()->routeIs('admin.prices.*') ? 'text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white' }}">
                            Definição de Preços
                        </a>
                    </div>
                </div>
            @endif

        </nav>
    </div>
</aside>