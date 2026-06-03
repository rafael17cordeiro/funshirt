@extends('layouts.store')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8 font-sans tracking-wide">
    <div class="mb-8 border-b border-zinc-100 pb-4">
        <h1 class="text-2xl font-light text-zinc-900 uppercase tracking-widest">Editar Categoria</h1>
        <p class="text-xs text-zinc-500 mt-1">Atualizar informações da categoria: {{ $category->name }}</p>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-xs uppercase tracking-widest text-zinc-500 font-medium mb-2">Nome da Categoria *</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   value="{{ old('name', $category->name) }}"
                   class="w-full border border-zinc-200 px-4 py-3 text-sm rounded-sm focus:outline-none focus:border-zinc-950 transition @error('name') border-red-400 @enderror"
                   required>
            @error('name')
                <p class="text-xs text-red-500 mt-1 font-light">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs uppercase tracking-widest text-zinc-500 font-medium mb-2">Imagem de Capa</label>
            
            @if($category->image_url)
                <div class="mb-4 flex items-center space-x-4 p-3 bg-zinc-50 border border-zinc-100 rounded-sm">
                    <img src="{{ asset('storage/categories/' . $category->image_url) }}" 
                         alt="{{ $category->name }}" 
                         class="w-16 h-16 object-cover rounded-sm border border-zinc-200">
                    <div>
                        <p class="text-xs text-zinc-700 font-medium">Imagem atual</p>
                        <p class="text-xxs text-zinc-400">{{ $category->image_url }}</p>
                    </div>
                </div>
            @endif

            <div class="border border-dashed border-zinc-200 bg-zinc-50/50 p-6 rounded-sm text-center">
                <input type="file" 
                       name="file_image" 
                       id="file_image" 
                       class="text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-xs file:uppercase file:tracking-wider file:font-semibold file:bg-zinc-950 file:text-white hover:file:bg-zinc-800 file:cursor-pointer cursor-pointer">
                <p class="text-xxs text-zinc-400 mt-2">Selecione um ficheiro se pretender substituir a imagem atual (Máx. 2MB)</p>
            </div>
            @error('file_image')
                <p class="text-xs text-red-500 mt-1 font-light">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-zinc-100">
            <a href="{{ route('admin.categories.index') }}" 
               class="text-xs uppercase tracking-widest text-zinc-500 hover:text-zinc-950 font-medium transition">
                Cancelar
            </a>
            <button type="submit" 
                    class="bg-zinc-950 text-white text-xs uppercase tracking-widest px-6 py-3 hover:bg-zinc-800 transition duration-300 rounded-sm font-medium">
                Atualizar Categoria
            </button>
        </div>
    </form>
</div>
@endsection