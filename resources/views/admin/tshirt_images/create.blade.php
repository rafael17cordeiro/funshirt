<x-app-layout>
    <x-slot name="header">
        {{ __('Criação de Estampas') }}
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Nova Estampa') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Adicione uma nova imagem de catálogo para os clientes estamparem.') }}
            </p>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
            <div class="p-6 text-gray-900">
                
                <form action="{{ route('admin.tshirt_images.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nome da Estampa *')" />
                        <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" 
                            :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="category_id" :value="__('Categoria Associada *')" />
                        <select id="category_id" name="category_id" 
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="" disabled selected>{{ __('Selecione uma Categoria...') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="description" :value="__('Descrição (Opcional)')" />
                        <textarea id="description" name="description" rows="3" 
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="file_image" :value="__('Upload da Imagem *')" />
                        <div class="mt-2">
                            <input type="file" name="file_image" id="file_image"
                                class="block w-full text-sm text-gray-500 
                                file:mr-4 file:py-2 file:px-4 
                                file:rounded-md file:border-0 
                                file:text-sm file:font-semibold 
                                file:bg-black file:text-white 
                                hover:file:bg-gray-800 cursor-pointer 
                                border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                        </div>
                        <x-input-error :messages="$errors->get('file_image')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-8 space-x-4 border-t border-gray-100 pt-6">
                        <a href="{{ route('admin.tshirt_images.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                            {{ __('Cancelar') }}
                        </a>
                        
                        <x-primary-button class="bg-black hover:bg-gray-800">
                            {{ __('Gravar Estampa') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>