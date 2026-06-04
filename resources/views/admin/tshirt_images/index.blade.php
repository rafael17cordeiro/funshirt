<x-app-layout>
    <x-slot name="header">
        {{ __('Catálogo de Estampas') }}
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-lg font-medium text-gray-900">Catálogo de Estampas</h2>
                <p class="mt-1 text-sm text-gray-600">Gestão de imagens disponíveis para os clientes estamparem.</p>
            </div>
            <a href="{{ route('admin.tshirt_images.create') }}"
                class="px-4 py-2 text-sm text-white bg-black rounded-md hover:bg-gray-800 shadow-sm transition-colors">
                + ESTAMPA
            </a>
        </div>

        @if(session('success'))
            <div
                class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-sm font-medium rounded-md shadow-sm flex items-center justify-between">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="py-4 px-6 font-medium">Imagem</th>
                        <th class="py-4 px-6 font-medium">Nome / Categoria</th>
                        <th class="py-4 px-6 font-medium">Descrição</th>
                        <th class="py-4 px-6 text-right font-medium">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                    @forelse($images as $image)
                        <tr class="hover:bg-gray-50 transition-colors">

                            <td class="py-4 px-6">
                                <div
                                    class="w-16 h-16 rounded-md border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center shadow-sm">
                                    @if($image->image_url)
                                        <img src="{{ asset('storage/tshirt_images/' . $image->image_url) }}"
                                            alt="{{ $image->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs font-medium text-gray-400">S/ Imagem</span>
                                    @endif
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <div class="font-medium text-gray-900">{{ $image->name }}</div>
                                <div class="text-xs text-gray-500 mt-1">Cat: <span
                                        class="font-medium">{{ $image->category->name ?? 'Sem Categoria' }}</span></div>
                            </td>

                            <td class="py-4 px-6 text-xs text-gray-500">
                                {{ Str::limit($image->description, 60) ?? 'Sem descrição' }}
                            </td>

                            <td class="py-4 px-6 text-right space-x-3">

                                <a href="{{ route('admin.tshirt_images.edit', $image) }}"
                                    class="inline-block text-gray-400 hover:text-gray-900 transition-colors" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                </a>

                                <form action="{{ route('admin.tshirt_images.destroy', $image) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Tem a certeza que deseja remover esta estampa do catálogo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors"
                                        title="Apagar">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-500">
                                Nenhuma estampa registada no catálogo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>