<x-app-layout>

<div class="min-h-screen bg-slate-50 p-8">

    {{-- HERO CARD --}}
    <div class="bg-gradient-to-r from-indigo-600 to-violet-600 rounded-3xl p-8 text-white mb-8 shadow-xl">

        <div class="flex flex-col md:flex-row justify-between items-center gap-6">

            <div>
                <h1 class="text-4xl font-bold">
                    Bem-vindo, {{ Auth::user()->name }} 👋
                </h1>

                <p class="mt-3 text-indigo-100">
                    Controle vendas, produtos e stock num único lugar.
                </p>
            </div>

            <a href="{{ route('pos') }}"
               class="bg-white text-indigo-600 px-6 py-3 rounded-2xl font-bold hover:scale-105 transition">
                Nova Venda
            </a>

        </div>

    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- VENDAS --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">Vendas</p>
                    <h2 class="text-3xl font-bold mt-2">
                        {{ number_format($salesToday,2) }} MZN
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                    💰
                </div>

            </div>

        </div>

        {{-- PRODUTOS --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">Produtos</p>
                    <h2 class="text-3xl font-bold mt-2">
                        {{ $productsCount }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                    📦
                </div>

            </div>

        </div>

        {{-- STOCK BAIXO --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">Stock Baixo</p>
                    <h2 class="text-3xl font-bold mt-2">
                        {{ $lowStock }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl">
                    ⚠️
                </div>

            </div>

        </div>

        {{-- POS --}}
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl shadow p-6 text-white">

            <p class="text-lg font-semibold">
                Ponto de Venda
            </p>

            <p class="text-indigo-100 text-sm mt-1">
                Acesso rápido ao POS
            </p>

            <a href="{{ route('pos') }}"
               class="inline-block mt-4 bg-white text-indigo-600 px-5 py-2 rounded-xl font-bold hover:scale-105 transition">
                Abrir POS
            </a>

        </div>

    </div>

    {{-- AÇÕES RÁPIDAS --}}
    <div class="mt-10">

        <h2 class="text-xl font-bold mb-5">
            Ações Rápidas
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <a href="{{ route('products.index') }}"
               class="bg-white rounded-3xl p-6 shadow-md hover:shadow-xl transition">

                <div class="text-4xl mb-3">📦</div>

                <h3 class="font-bold text-lg">Produtos</h3>
                <p class="text-gray-500 text-sm">Gerir catálogo e stock</p>

            </a>

            <a href="{{ route('sales.index') }}"
               class="bg-white rounded-3xl p-6 shadow-md hover:shadow-xl transition">

                <div class="text-4xl mb-3">💰</div>

                <h3 class="font-bold text-lg">Vendas</h3>
                <p class="text-gray-500 text-sm">Histórico de vendas</p>

            </a>

            <a href="{{ route('pos') }}"
               class="bg-white rounded-3xl p-6 shadow-md hover:shadow-xl transition">

                <div class="text-4xl mb-3">🛒</div>

                <h3 class="font-bold text-lg">POS</h3>
                <p class="text-gray-500 text-sm">Abrir ponto de venda</p>

            </a>

        </div>

    </div>

    {{-- PAINÉIS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-10">

        {{-- ÚLTIMAS VENDAS --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6">

            <h2 class="text-xl font-bold mb-4">
                Últimas Vendas
            </h2>

            @forelse($latestSales as $sale)

                <div class="flex justify-between border-b py-3">

                    <span>Venda #{{ $sale->id }}</span>

                    <span class="font-bold">
                        {{ number_format($sale->total,2) }} MZN
                    </span>

                </div>

            @empty
                <p class="text-gray-500">Sem vendas.</p>
            @endforelse

        </div>

        {{-- ALERTAS --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6">

            <h2 class="text-xl font-bold mb-4">
                Alertas de Stock
            </h2>

            @forelse($lowStockProducts as $product)

                <div class="flex justify-between border-b py-3">

                    <span>{{ $product->name }}</span>

                    <span class="text-red-600 font-bold">
                        {{ $product->quantity }}
                    </span>

                </div>

            @empty
                <p class="text-gray-500">Sem alertas.</p>
            @endforelse

        </div>

    </div>

</div>

</x-app-layout>