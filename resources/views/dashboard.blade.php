<x-app-layout>

<div class="min-h-screen bg-slate-50 p-8">

    {{-- HERO --}}
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
                🛒 Nova Venda
            </a>

        </div>

    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">

        {{-- HOJE --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">Hoje</p>

                    <h2 class="text-2xl font-bold mt-2">
                        {{ number_format($salesToday,2) }} MZN
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                    💰
                </div>

            </div>

        </div>

        {{-- SEMANA --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">Semana</p>

                    <h2 class="text-2xl font-bold mt-2">
                        {{ number_format($salesThisWeek,2) }} MZN
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                    📈
                </div>

            </div>

        </div>

        {{-- MÊS --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">Mês</p>

                    <h2 class="text-2xl font-bold mt-2">
                        {{ number_format($salesThisMonth,2) }} MZN
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center text-2xl">
                    📅
                </div>

            </div>

        </div>

        {{-- PRODUTOS --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">Produtos</p>

                    <h2 class="text-2xl font-bold mt-2">
                        {{ $productsCount }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-cyan-100 flex items-center justify-center text-2xl">
                    📦
                </div>

            </div>

        </div>

        {{-- REPOR --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">
                        Produtos a Repor
                    </p>

                    <h2 class="text-2xl font-bold mt-2">

                        @if($lowStock == 0)

                            <span class="text-green-600">
                                ✓
                            </span>

                        @else

                            <span class="text-red-600">
                                {{ $lowStock }}
                            </span>

                        @endif

                    </h2>

                    <p class="text-sm mt-1 text-gray-500">

                        @if($lowStock == 0)
                            Stock saudável
                        @else
                            Requer atenção
                        @endif

                    </p>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">
                    ⚠️
                </div>

            </div>

        </div>

    </div>

    {{-- AÇÕES --}}
    <div class="mt-10">

        <h2 class="text-xl font-bold mb-5">
            Ações Rápidas
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <a href="{{ route('products.index') }}"
               class="bg-white rounded-3xl p-6 shadow-md hover:shadow-xl transition">

                <div class="text-4xl mb-3">📦</div>

                <h3 class="font-bold text-lg">Produtos</h3>

                <p class="text-gray-500 text-sm">
                    Gerir catálogo e stock
                </p>

            </a>

            <a href="{{ route('sales.index') }}"
               class="bg-white rounded-3xl p-6 shadow-md hover:shadow-xl transition">

                <div class="text-4xl mb-3">💰</div>

                <h3 class="font-bold text-lg">Vendas</h3>

                <p class="text-gray-500 text-sm">
                    Histórico de vendas
                </p>

            </a>

            <a href="{{ route('pos') }}"
               class="bg-white rounded-3xl p-6 shadow-md hover:shadow-xl transition">

                <div class="text-4xl mb-3">🛒</div>

                <h3 class="font-bold text-lg">POS</h3>

                <p class="text-gray-500 text-sm">
                    Abrir ponto de venda
                </p>

            </a>

        </div>

    </div>

    {{-- PAINÉIS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-10">

        {{-- ÚLTIMAS VENDAS --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6">

            <h2 class="text-xl font-bold mb-4">
                🧾 Últimas Vendas
            </h2>

            @forelse($latestSales as $sale)

                <div class="flex justify-between border-b py-3">

                    <span>Venda #{{ $sale->id }}</span>

                    <span class="font-bold text-green-600">
                        {{ number_format($sale->total,2) }} MZN
                    </span>

                </div>

            @empty

                <p class="text-gray-500">
                    Sem vendas.
                </p>

            @endforelse

        </div>

        {{-- ALERTAS --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6">

            <h2 class="text-xl font-bold mb-4 text-red-600">
                ⚠ Produtos a Repor
            </h2>

            @forelse($lowStockProducts as $product)

                <div class="flex justify-between items-center border-b py-3">

                    <div>

                        <p class="font-semibold">
                            {{ $product->name }}
                        </p>

                        <p class="text-sm text-gray-500">
                            🔴 Crítico
                        </p>

                    </div>

                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full font-semibold">
                        {{ $product->quantity }}
                    </span>

                </div>

            @empty

                <p class="text-green-600 font-semibold">
                    ✅ Sem alertas de stock.
                </p>

            @endforelse

        </div>

        {{-- TOP PRODUTOS --}}
        <div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6">

            <h2 class="text-xl font-bold mb-4">
                🏆 Mais Vendidos
            </h2>

            @forelse($topProducts as $item)

                <div class="flex justify-between border-b py-3">

                    <span>
                        {{ $item->product?->name ?? 'Produto removido' }}
                    </span>

                    <span class="font-bold text-indigo-600">
                        {{ $item->total_sold }}
                    </span>

                </div>

            @empty

                <p class="text-gray-500">
                    Sem dados.
                </p>

            @endforelse

        </div>

    </div>

</div>
<div class="bg-white rounded-3xl shadow-md border border-slate-100 p-6 mt-10">

    <h2 class="text-xl font-bold mb-4">
        📈 Vendas últimos 7 dias
    </h2>

    <canvas id="salesChart"></canvas>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($salesChart->pluck('date')) !!},
        datasets: [{
            label: 'Vendas (MZN)',
            data: {!! json_encode($salesChart->pluck('total')) !!},
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79,70,229,0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        }
    }
});
</script>
</x-app-layout>