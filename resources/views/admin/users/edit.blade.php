<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.index') }}" title="Voltar" class="text-gray-400 hover:text-black transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Colaborador: ') }} <span class="font-normal text-gray-500">{{ $user->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">

                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="max-w-2xl space-y-6">
                        @csrf
                        @method('PUT') <div>
                            <x-input-label for="name" :value="__('Nome Completo')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Género (NOVO CAMPO) -->
                        <div>
                            <x-input-label for="gender" :value="__('Género')" />
                            <select id="gender" name="gender" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="M" {{ old('gender', $user->gender) == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('gender', $user->gender) == 'F' ? 'selected' : '' }}>Feminino</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>

                        <!-- Tipo de Utilizador -->
                        <div>
                            <x-input-label for="user_type" :value="__('Cargo / Nível de Acesso')" />
                            <select id="user_type" name="user_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="F" {{ old('user_type', $user->user_type) == 'F' ? 'selected' : '' }}>Funcionário (Acesso Limitado)</option>
                                <option value="A" {{ old('user_type', $user->user_type) == 'A' ? 'selected' : '' }}>Administrador (Acesso Total)</option>
                            </select>
                            <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-start mt-10 pt-6 border-t border-gray-100">
                            <x-primary-button class="bg-black hover:bg-gray-800 px-8 py-3">
                                {{ __('Guardar Alterações') }}
                            </x-primary-button>
                            <a href="{{ route('admin.users.index') }}" class="ml-6 text-sm font-bold text-gray-500 hover:text-black uppercase tracking-widest transition">
                                Cancelar
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
