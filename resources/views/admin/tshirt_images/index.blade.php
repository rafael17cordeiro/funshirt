<x-app-layout>
    <x-slot name="header">
        {{ __('Catálogo de Estampas') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">
                        Catálogo de Estampas
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 font-medium">
                        Gestão de imagens disponíveis para os clientes estamparem.
                    </p>
                </div>

                <a href="{{ route('admin.tshirt_images.create') }}"
                    class="inline-flex items-center px-5 py-2 text-[11px] font-bold tracking-widest text-white uppercase bg-blue-600/50 border border-blue-600 rounded-full hover:bg-blue-800 hover:text-white transition-colors shadow-sm">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>

                    NOVA ESTAMPA
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
                    class="fixed bottom-6 right-6 bg-white p-4 shadow-xl border border-gray-100 border-l-4 border-l-green-500 flex items-start space-x-4 z-50 w-full max-w-sm rounded-lg">
                    <!-- Adicionei o > aqui -->

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

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="text-gray-900 overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-500 font-semibold">
                            <tr>
                                <th class="px-6 py-4 uppercase tracking-wider" scope="col"
                                    class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider">
                                    Imagem
                                </th>
                                <th class="px-6 py-4 uppercase tracking-wider" scope="col"
                                    class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider w-1/3">
                                    Nome / Categoria
                                </th>
                                <th class="px-6 py-4 uppercase tracking-wider" scope="col"
                                    class="px-6 py-4 text-left font-bold text-gray-900 uppercase tracking-wider">
                                    Descrição
                                </th>
                                <th class="px-6 py-4 uppercase tracking-wider" scope="col"
                                    class="px-6 py-4 text-right font-bold text-gray-900 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($images as $image)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="w-16 h-16 rounded-xl border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center shadow-sm">
                                            @if($image->image_url)
                                                <img src="{{ asset('storage/tshirt_images/' . $image->image_url) }}"
                                                    alt="{{ $image->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-xs font-medium text-gray-400">S/ Imagem</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">{{ $image->name }}</div>
                                        <div class="text-xs text-gray-500 mt-1">Cat: <span
                                                class="font-medium">{{ $image->category->name ?? 'Sem Categoria' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        {{ Str::limit($image->description, 60) ?? 'Sem descrição' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-3">
                                            <a href="{{ route('admin.tshirt_images.edit', $image) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors"
                                                title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.tshirt_images.destroy', $image) }}" method="POST"
                                                class="inline-block m-0 p-0"
                                                onsubmit="return confirm('Tem a certeza que deseja remover esta estampa do catálogo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                                    title="Apagar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-3 text-gray-300"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125V5.625A3.375 3.375 0 0010.125 2.25H6.75A2.25 2.25 0 004.5 4.5v15A2.25 2.25 0 006.75 21.75h10.5A2.25 2.25 0 0019.5 19.5v-5.25z" />
                                            </svg>

                                            <p class="text-sm font-medium">
                                                Nenhuma estampa registada no catálogo.
                                            </p>

                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>