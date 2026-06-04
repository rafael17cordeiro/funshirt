<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestão de Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Gestão de Clientes</h2>
                    <p class="mt-1 text-sm text-gray-600">Consulta, bloqueio e administração das contas de clientes da
                        Funshirt.</p>
                </div>
            </div>
            @if(session('success'))
                <div x-data="{ show: false }"
                    x-init="setTimeout(() => show = true, 50); setTimeout(() => show = false, 5000)" x-show="show"
                    class="fixed bottom-6 right-6 bg-white p-4 shadow-xl border border-gray-100 border-l-4 border-l-green-500 flex items-start space-x-4 z-50 w-full max-w-sm">
                    <div class="flex-shrink-0 pt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-6 h-6 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-black uppercase tracking-wider text-gray-950 mb-0.5">Sucesso</p>
                        <p class="text-xs text-gray-600 mb-0">{{ session('success') }}</p>
                    </div>
                    <button type="button" @click="show = false"
                        class="text-gray-400 hover:text-black transition flex-shrink-0 -mr-1 -mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider w-1/3">
                                    Nome</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider w-1/3">
                                    Email</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider">Estado
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-right font-bold text-gray-900 uppercase tracking-wider">Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($clients as $client)
                                <tr
                                    class="hover:bg-gray-50 transition duration-150 {{ $client->blocked ? 'bg-orange-50/50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                        {{ $client->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        {{ $client->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($client->blocked)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200">
                                                Bloqueado
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                Ativo
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-4">

                                            <!-- Ação de Bloquear/Desbloquear -->
                                            <form action="{{ route('admin.clients.toggle-block', $client) }}" method="POST"
                                                class="inline-block m-0 p-0">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    title="{{ $client->blocked ? 'Desbloquear Cliente' : 'Bloquear Cliente' }}"
                                                    class="{{ $client->blocked ? 'text-orange-500 hover:text-orange-700' : 'text-gray-400 hover:text-orange-500' }} transition duration-150 flex items-center">
                                                    @if($client->blocked)
                                                        <!-- Ícone Cadeado Fechado -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="currentColor" class="w-5 h-5">
                                                            <path fill-rule="evenodd"
                                                                d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <!-- Ícone Cadeado Aberto -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>

                                            <!-- Ação de Soft Delete -->
                                            <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST"
                                                class="inline-block m-0 p-0"
                                                onsubmit="return confirm('{{ $client->trashed() ? 'Tem a certeza que deseja RESTAURAR este cliente?' : 'Tem a certeza que deseja APAGAR (Soft Delete) este cliente?' }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    title="{{ $client->trashed() ? 'Restaurar Cliente' : 'Apagar Cliente' }}"
                                                    class="{{ $client->trashed() ? 'text-gray-400 hover:text-green-600' : 'text-gray-400 hover:text-red-600' }} transition duration-150 flex items-center">
                                                    @if($client->trashed())
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($clients->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            Não existem clientes registados.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>