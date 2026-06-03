@extends('layouts.store')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8 font-sans tracking-wide">
    <div class="mb-8 border-b border-zinc-100 pb-4">
        <h1 class="text-2xl font-light text-zinc-900 uppercase tracking-widest">Editar Estampa</h1>
        <p class="text-xs text-zinc-500 mt-1">Atualizar informações de: {{ $tshirtImage->name }}</p>
    </div>

    <form action="{{ route('admin.tshirt_images.update', $tshirtImage) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        @if($tshirtImage->image_url)
        <div class="mb-6 flex flex-col items-start">
            <span class="block text-xs uppercase tracking-widest text-zinc-500 font-medium mb-2">Imagem Atual</span>
            <div class="w-32 h-32 border border-zinc-200 rounded-sm overflow-hidden bg-zinc-50 p-2">
                <img src="{{ asset('storage/tshirt_images/' . $tshirtImage->image_url) }}" alt="Atual" class="w-full h-full object-contain">
            </div>
        </div>
        @endif

        <div>
            <label for="name" class="block text-xs uppercase tracking-widest text-zinc-500 font-medium mb-2">Nome da Estampa *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $tshirtImage->name) }}"
                   class="w-full border border-zinc-200 px-4 py-3 text-sm rounded-sm focus:outline-none focus:border-zinc-950 transition"
                   required>
        </div>

        <div>
            <label for="category_id" class="block text-xs uppercase tracking-widest text-zinc-500 font-medium mb-2">Categoria Associada *</label>
            <select name="category_id" id="category_id" 
                    class="w-full border border-zinc-200 px-4 py-3 text-sm rounded-sm focus:outline-none focus:border-zinc-950 transition" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $tshirtImage->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="description" class="block text-xs uppercase tracking-widest text-zinc-500 font-medium mb-2">Descrição</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full border border-zinc-200 px-4 py-3 text-sm rounded-sm focus:outline-none focus:border-zinc-950 transition">{{ old('description', $tshirtImage->description) }}</textarea>
        </div>

        <div>
            <label class="block text-xs uppercase tracking-widest text-zinc-500 font-medium mb-2">Substituir Imagem (Opcional)</label>
            <div class="border border-dashed border-zinc-200 bg-zinc-50/50 p-6 rounded-sm text-center">
                <input type="file" name="file_image" id="file_image" 
                       class="text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-xs file:uppercase file:tracking-wider file:font-semibold file:bg-zinc-950 file:text-white hover:file:bg-zinc-800 file:cursor-pointer cursor-pointer">
            </div>
            @error('file_image') <p class="text-xs text-red-500 mt-1 font-light">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-zinc-100">
            <a href="{{ route('admin.tshirt_images.index') }}" class="text-xs uppercase tracking-widest text-zinc-500 hover:text-zinc-950 font-medium transition">Cancelar</a>
            <button type="submit" class="bg-zinc-950 text-white text-xs uppercase tracking-widest px-6 py-3 hover:bg-zinc-800 transition duration-300 rounded-sm font-medium">Atualizar Estampa</button>
        </div>
    </form>
</div>
@endsection