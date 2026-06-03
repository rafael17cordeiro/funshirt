@extends('layouts.store')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 font-sans tracking-wide">
    <div class="flex justify-between items-center mb-8 border-b border-zinc-100 pb-4">
        <div>
            <h1 class="text-2xl font-light text-zinc-900 uppercase tracking-widest">Gestão de Categorias</h1>
            <p class="text-xs text-zinc-500 mt-1">Organização do catálogo público da FunShirt</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" 
           class="inline-block bg-zinc-950 text-white text-xs uppercase tracking-widest px-5 py-3 hover:bg-zinc-800 transition duration-300 rounded-sm font-medium">
            + Nova Categoria
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
                    <th class="py-4 px-6 font-bold">Nome da Categoria</th>
                    <th class="py-4 px-6 text-right font-bold">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100 text-sm text-zinc-700">
                @forelse($categories as $category)
                    <tr class="hover:bg-zinc-50/50 transition">
                        <td class="py-4 px-6">
                            @if($category->image_url)
                                <img src="{{ asset('storage/categories/' . $category->image_url) }}" 
                                     alt="{{ $category->name }}" 
                                     class="w-12 h-12 object-cover rounded-sm border border-zinc-100 bg-zinc-50">
                            @else
                                <div class="w-12 h-12 bg-zinc-50 border border-zinc-100 rounded-sm flex items-center justify-center text-zinc-300 text-xs font-light">
                                    N/A
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-medium text-zinc-900">
                            {{ $category->name }}
                        </td>
                        <td class="py-4 px-6 text-right space-x-3">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="text-xs text-zinc-500 uppercase tracking-wider hover:text-zinc-950 transition font-medium">
                                Editar
                            </a>
                            
                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  class="inline-block"
                                  onsubmit="return confirm('Tem a certeza que deseja remover esta categoria?');">
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
                        <td colspan="3" class="py-12 text-center text-zinc-400 font-light">
                            Nenhuma categoria registada no sistema.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection