<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visão Geral da Loja') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Receita Mensal</p>
                        <h3 class="text-2xl font-black text-gray-800">
                            {{ number_format($kpis['monthly_revenue'], 0, ',', ' ') }} €
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Receita Global</p>
                        <h3 class="text-2xl font-black text-gray-800">
                            {{ number_format($kpis['total_revenue'], 0, ',', ' ') }} €
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-sky-50 flex items-center justify-center text-sky-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Vendas Totais</p>
                        <h3 class="text-2xl font-black text-gray-800">{{ $kpis['total_orders'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Pendentes</p>
                        <h3 class="text-2xl font-black text-red-500">{{ $kpis['pending_orders'] }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Evolução de Receita
                        (Últimos 6 meses)</h3>
                    <div class="relative h-72 w-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Estado das Encomendas</h3>
                    <div class="relative h-56 w-full flex justify-center items-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-2 text-xs">
                        <div class="flex items-center"><span
                                class="w-3 h-3 bg-yellow-400 rounded-full mr-2"></span>Pendentes</div>
                        <div class="flex items-center"><span class="w-3 h-3 bg-blue-400 rounded-full mr-2"></span>Pagas
                        </div>
                        <div class="flex items-center"><span
                                class="w-3 h-3 bg-green-400 rounded-full mr-2"></span>Fechadas</div>
                        <div class="flex items-center"><span
                                class="w-3 h-3 bg-red-400 rounded-full mr-2"></span>Anuladas</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-red-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-red-50/30">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center">
                        <span class="flex h-3 w-3 relative mr-3">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                        </span>
                        Prioridade: Aguardam Confirmação / Ação
                    </h3>
                    <a href="{{ route('admin.orders.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-900 font-semibold">Ver todas &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-semibold">
                            <tr>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Cliente</th>
                                <th class="px-6 py-3">Data</th>
                                <th class="px-6 py-3">Estado</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3 text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentPendingOrders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-4">{{ $order->customer->user->name ?? 'Desconhecido' }}</td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $order->created_at ? $order->created_at->format('d/m/Y') : \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($order->status == 'pending')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pendente</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Paga</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ number_format($order->total_price, 2, ',', ' ') }} €
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-md text-xs font-bold transition">
                                            Confirmar Encomenda
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        Tudo limpo! Não há encomendas a aguardar confirmação.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Últimas Entradas
                            </h3>
                            <a href="{{ route('admin.orders.index') }}"
                                class="text-xs text-blue-600 hover:text-blue-900 font-bold">Ver todas</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($recentPendingOrders->take(3) as $order)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 font-bold text-blue-600">
                                                <a
                                                    href="{{ route('admin.orders.show', $order) }}">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</a>
                                            </td>
                                            <td class="px-6 py-4 truncate max-w-[120px]"
                                                title="{{ $order->customer->user->name ?? 'Desconhecido' }}">
                                                {{ $order->customer->user->name ?? 'Desconhecido' }}
                                            </td>
                                            <td class="px-6 py-4 font-bold text-gray-900 text-right">
                                                {{ number_format($order->total_price, 2, ',', ' ') }}€
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center text-gray-500 text-xs">Sem
                                                encomendas recentes.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Top Produtos
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center min-w-0">
                                <span
                                    class="w-6 h-6 rounded bg-gray-100 text-gray-500 flex items-center justify-center font-bold text-xs mr-3 flex-shrink-0">1</span>
                                <p class="font-medium text-gray-900 truncate">Estampa "Stay Wild"</p>
                            </div>
                            <span class="font-bold text-gray-700 pl-2">124v</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center min-w-0">
                                <span
                                    class="w-6 h-6 rounded bg-gray-100 text-gray-500 flex items-center justify-center font-bold text-xs mr-3 flex-shrink-0">2</span>
                                <p class="font-medium text-gray-900 truncate">Estampa "Developer"</p>
                            </div>
                            <span class="font-bold text-gray-700 pl-2">98v</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center min-w-0">
                                <span
                                    class="w-6 h-6 rounded bg-gray-100 text-gray-500 flex items-center justify-center font-bold text-xs mr-3 flex-shrink-0">3</span>
                                <p class="font-medium text-gray-900 truncate">Logotipo Empresa</p>
                            </div>
                            <span class="font-bold text-gray-700 pl-2">65v</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Melhores Clientes
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @forelse($topCustomers as $index => $customer)
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center min-w-0">
                                    <span
                                        class="w-6 h-6 rounded flex items-center justify-center font-bold text-xs mr-3 flex-shrink-0 
                                                                {{ $index == 0 ? 'bg-yellow-100 text-yellow-700' : ($index == 1 ? 'bg-gray-100 text-gray-700' : 'bg-orange-100 text-orange-700') }}">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="truncate">
                                        <p class="font-bold text-gray-900 truncate">{{ $customer->name }}</p>
                                        <p class="text-[10px] text-gray-400 truncate">{{ $customer->email }}</p>
                                    </div>
                                </div>
                                <span class="font-black text-green-600 pl-2 text-right whitespace-nowrap">
                                    {{ number_format($customer->total_spent, 0, ',', ' ') }}€
                                </span>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 text-xs py-4">Sem dados de faturação.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Gráfico de Linha (Receita)
            const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctxRevenue, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartMonths) !!},
                    datasets: [{
                        label: 'Faturação Mensal (€)',
                        data: {!! json_encode($chartRevenue) !!},
                        borderColor: '#2563eb', // Substituído para blue-600
                        backgroundColor: 'rgba(37, 99, 235, 0.1)', // Substituído para rgba do blue-600
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#2563eb', // Substituído para blue-600
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { borderDash: [4, 4] } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 2. Gráfico Donut (Estado das Encomendas)
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Pendentes', 'Pagas', 'Fechadas', 'Anuladas'],
                    datasets: [{
                        data: [
                            {{ $orderStats['pending'] }},
                            {{ $orderStats['paid'] }},
                            {{ $orderStats['closed'] }},
                            {{ $orderStats['canceled'] }}
                        ],
                        backgroundColor: [
                            '#fbbf24',
                            '#60a5fa',
                            '#34d399',
                            '#f87171'
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</x-app-layout>