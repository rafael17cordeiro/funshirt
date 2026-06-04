<x-app-layout>
    <x-slot name="header">
        {{ __('Gestão de Colaboradores') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Gestão de Colaboradores</h2>
                    <p class="mt-1 text-sm text-gray-600">Administração de contas de funcionários e administradores do
                        sistema.</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                    class="px-4 py-2 text-sm text-white bg-black rounded-md hover:bg-gray-800 transition-colors shadow-sm">
                    + COLABORADOR
                </a>
            </div>

            @if(session('success'))
                <div x-data="{ show: false }"
                    x-init="setTimeout(() => show = true, 50); setTimeout(() => show = false, 5000)" x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-x-8"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform translate-x-8"
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
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-wider w-1/3">
                                    Nome</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-wider w-1/3">
                                    Email</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-wider">Cargo
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-right font-bold text-gray-500 uppercase tracking-wider">Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                        {{ $user->name }}
                                        @if(auth()->id() === $user->id)
                                            <span
                                                class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">Tu</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->user_type === 'A')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-900 text-white">
                                                Administrador
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                Funcionário
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-3">
                                            <a href="{{ route('admin.users.edit', $user) }}" title="Editar"
                                                class="text-gray-400 hover:text-indigo-600 transition duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                            </a>

                                            @if(auth()->id() !== $user->id)
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                    class="inline-block m-0 p-0"
                                                    onsubmit="return confirm('Tem a certeza que deseja remover este colaborador?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Remover"
                                                        class="text-gray-400 hover:text-red-600 transition duration-150 flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span title="Não podes remover a tua própria conta"
                                                    class="text-gray-200 cursor-not-allowed">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($users->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            Não existem colaboradores registados.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>