<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>StockBar Pro</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-slate-900 text-white">

        <div class="p-6 border-b border-slate-800">

            <h1 class="text-2xl font-bold">
                STOCKBAR
            </h1>

            <p class="text-slate-400 text-sm">
                Gestão Comercial
            </p>

        </div>

        <nav class="p-4 space-y-2">

            <a href="{{ route('dashboard') }}"
               class="block px-4 py-3 rounded-xl hover:bg-slate-800 transition">
                📊 Dashboard
            </a>

            <a href="{{ route('pos') }}"
               class="block px-4 py-3 rounded-xl hover:bg-slate-800 transition">
                🛒 POS
            </a>

            <a href="{{ route('products.index') }}"
               class="block px-4 py-3 rounded-xl hover:bg-slate-800 transition">
                📦 Produtos
            </a>

            <a href="{{ route('sales.index') }}"
               class="block px-4 py-3 rounded-xl hover:bg-slate-800 transition">
                💰 Vendas
            </a>

        </nav>

    </aside>

    {{-- CONTEÚDO --}}
    <div class="flex-1">

        {{-- TOPO --}}
        <header class="bg-white shadow-sm">

            <div class="px-8 py-4 flex justify-between items-center">

                <div>

                    <h2 class="text-xl font-bold text-gray-800">
                        Sistema de Gestão
                    </h2>

                    <p class="text-sm text-gray-500">
                        StockBar Pro
                    </p>

                </div>

                <div class="flex items-center gap-4">

                    <div class="text-right">

                        <p class="font-semibold">
                            {{ Auth::user()->name }}
                        </p>

                        <p class="text-xs text-gray-500">
                            Administrador
                        </p>

                    </div>

                    <form method="POST"
                          action="{{ route('logout') }}">
                        @csrf

                        <button
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                            Sair
                        </button>

                    </form>

                </div>

            </div>

        </header>

        {{-- CONTEÚDO DAS PÁGINAS --}}
        <main class="p-8">

            {{ $slot }}

        </main>

    </div>

</div>

</body>
</html>