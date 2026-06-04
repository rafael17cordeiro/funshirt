<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Funshirt') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100">

    <!-- Contenedor Principal Flexbox -->
    <div class="flex h-screen overflow-hidden bg-gray-100">

        <!-- Barra Lateral Esquerda (Sidebar) -->
        @include('layouts.sidebar')

        <!-- Área Direita (Top Bar + Conteúdo Principal) -->
        <div class="flex flex-col flex-1 w-full overflow-hidden">

            <!-- Barra Superior (Top Bar) -->
            @include('layouts.topbar')

            <!-- Conteúdo da Página -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                {{ $slot }}
            </main>

        </div>
    </div>

</body>

</html>