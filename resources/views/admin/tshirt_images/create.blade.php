@extends('layouts.store')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8 font-sans tracking-wide">
    <div class="mb-8 border-b border-zinc-100 pb-4">
        <h1 class="text-2xl font-light text-zinc-900 uppercase tracking-widest">Nova Estampa</h1>
        <p class="text-xs text-zinc-500 mt-1">Adicionar uma nova imagem de catálogo</p>
    </div>

    <form action="{{ route('admin.tshirt_images.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-xs uppercase tracking-widest text-zinc-500 font-medium mb-2">Nome da Estampa *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full border border-zinc-200 px-4 py-3 text-sm rounded-sm focus:outline-none focus:border-zinc-950 transition @error('name') border-red-400 @enderror"
                   required>
            @error('name') <p class="text-xs text-red-500 mt-1 font-light">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="category_id" class="block text-xs uppercase tracking-widest text-zinc-500 font-medium mb-2">Categoria Associada *</label>
            <select name="category_id" id="category_id" 
                    class="w-full border border-zinc-200 px-4 py-3 text-sm rounded-sm focus:outline-none focus:border-zinc-950 transition @error('category_id') border-red-400 @enderror" required>
                <option value="" disabled selected>Selecione uma Categoria...</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-xs text-red-500 mt-1 font-light">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-xs uppercase tracking-widest text-zinc-500 font-medium mb-2">Descrição (Opcional)</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full border border-zinc-200 px-4 py-3 text-sm rounded-sm focus:outline-none focus:border-zinc-950 transition @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
            @error('description') <p class="text-xs text-red-500 mt-1 font-light">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs uppercase tracking-widest text-zinc-500 font-medium mb-2">Upload da Imagem *</label>
            <div class="border border-dashed border-zinc-200 bg-zinc-50/50 p-6 rounded-sm text-center">
                <input type="file" name="file_image" id="file_image" 
                       class="text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-xs file:uppercase file:tracking-wider file:font-semibold file:bg-zinc-950 file:text-white hover:file:bg-zinc-800 file:cursor-pointer cursor-pointer"
                       required>
            </div>
            @error('file_image') <p class="text-xs text-red-500 mt-1 font-light">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-zinc-100">
            <a href="{{ route('admin.tshirt_images.index') }}" class="text-xs uppercase tracking-widest text-zinc-500 hover:text-zinc-950 font-medium transition">Cancelar</a>
            <button type="submit" class="bg-zinc-950 text-white text-xs uppercase tracking-widest px-6 py-3 hover:bg-zinc-800 transition duration-300 rounded-sm font-medium">Gravar Estampa</button>
        </div>
    </form>
</div>
@endsection