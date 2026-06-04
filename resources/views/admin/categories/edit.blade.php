<x-app-layout>
    <x-slot name="header">
        {{ __('Editar Categoria') }}
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        <div class="mb-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Atualizar Categoria: ') }} <span class="font-bold">{{ $category->name }}</span>
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Modifique o nome ou atualize a imagem de capa desta categoria.') }}
            </p>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <form action="{{ route('admin.categories.update', $category) }}" method="POST"
                    enctype="multipart/form-data" class="max-w-2xl">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Nome da Categoria *')" />
                        <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" :value="old('name', $category->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="file_image" :value="__('Imagem de Capa')" />

                        @if($category->image_url)
                            <div
                                class="mt-2 mb-4 flex items-center space-x-4 p-4 bg-gray-50 border border-gray-200 rounded-md">
                                <img src="{{ asset('storage/categories/' . $category->image_url) }}"
                                    alt="{{ $category->name }}"
                                    class="w-16 h-16 object-cover rounded-md border border-gray-300 shadow-sm">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Imagem atual</p>
                                    <p class="text-xs text-gray-500">{{ $category->image_url }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="mt-2">
                            <input type="file" name="file_image" id="file_image"
                                class="block w-full text-sm text-gray-500 
                                file:mr-4 file:py-2 file:px-4 
                                file:rounded-md file:border-0 
                                file:text-sm file:font-semibold 
                                file:bg-black file:text-white 
                                hover:file:bg-gray-800 cursor-pointer 
                                border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="mt-2 text-xs text-gray-500">
                                {{ __('Selecione um ficheiro apenas se pretender substituir a imagem atual (Máx. 2MB).') }}
                            </p>
                        </div>
                        <x-input-error :messages="$errors->get('file_image')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-8 space-x-4 border-t border-gray-100 pt-6">
                        <a href="{{ route('admin.categories.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                            {{ __('Cancelar') }}
                        </a>

                        <x-primary-button class="bg-black hover:bg-gray-800">
                            {{ __('Atualizar Categoria') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>