@extends('layouts.store')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 font-sans tracking-wide">
    <div class="flex justify-between items-center mb-8 border-b border-zinc-100 pb-4">
        <div>
            <h1 class="text-2xl font-light text-zinc-900 uppercase tracking-widest">Catálogo de Estampas</h1>
            <p class="text-xs text-zinc-500 mt-1">Gestão de imagens disponíveis para os clientes estamparem</p>
        </div>
        <a href="{{ route('admin.tshirt_images.create') }}" 
           class="inline-block bg-zinc-950 text-white text-xs uppercase tracking-widest px-5 py-3 hover:bg-zinc-800 transition duration-300 rounded-sm font-medium">
            + Nova Estampa
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-zinc-50 border border-zinc-200 text-zinc-800 text-sm tracking-wide rounded-sm flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white border border-zinc-200 rounded-sm overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-zinc-50 border-b border-zinc-200 text-zinc-400 text-xxs uppercase tracking-widest font-semibold">
                    <th class="py-4 px-6 font-bold">Imagem</th>
                    <th class="py-4 px-6 font-bold">Nome / Categoria</th>
                    <th class="py-4 px-6 font-bold">Descrição</th>
                    <th class="py-4 px-6 text-right font-bold">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100 text-sm text-zinc-700">
                @forelse($images as $image)
                    <tr class="hover:bg-zinc-50/50 transition">
                        <td class="py-4 px-6">
                            <div class="w-16 h-16 rounded-sm border border-zinc-200 overflow-hidden bg-zinc-50 flex items-center justify-center">
                                @if($image->image_url)
                                    <img src="{{ asset('storage/tshirt_images/' . $image->image_url) }}" alt="{{ $image->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs text-zinc-400">S/ Imagem</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-zinc-900">{{ $image->name }}</div>
                            <div class="text-xs text-zinc-500 mt-1">Cat: {{ $image->category->name ?? 'Sem Categoria' }}</div>
                        </td>
                        <td class="py-4 px-6 text-xs text-zinc-500">
                            {{ Str::limit($image->description, 50) ?? 'Sem descrição' }}
                        </td>
                        <td class="py-4 px-6 text-right space-x-3">
                            <a href="{{ route('admin.tshirt_images.edit', $image) }}" 
                               class="text-xs text-zinc-500 uppercase tracking-wider hover:text-zinc-950 transition font-medium">
                                Editar
                            </a>
                            
                            <form action="{{ route('admin.tshirt_images.destroy', $image) }}" 
                                  method="POST" 
                                  class="inline-block"
                                  onsubmit="return confirm('Tem a certeza que deseja remover esta estampa do catálogo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-xs text-red-400 uppercase tracking-wider hover:text-red-600 transition font-medium">
                                    Apagar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-zinc-400 font-light">
                            Nenhuma estampa registada no catálogo.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection