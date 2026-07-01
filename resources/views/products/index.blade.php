<x-app-layout>

<div class="p-6">

    <!-- Cabeçalho -->

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                📦 Gestão de Produtos
            </h1>

            <p class="text-gray-500 mt-1">
                Controle de produtos e stock
            </p>
        </div>

        <a href="{{ route('products.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700
                  text-white px-5 py-3 rounded-xl
                  shadow-lg font-semibold
                  transition">

            ➕ Novo Produto
		</a>
		<div class="bg-white rounded-2xl shadow p-4 mb-6">

    <form method="GET">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="🔍 Pesquisar produto..."
            class="w-full border-gray-300 rounded-xl">

    </form>

</div>

    </div>

    <!-- Resumo -->

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <div class="bg-white rounded-2xl shadow p-5">

            <p class="text-gray-500">
                Total Produtos
            </p>

            <h2 class="text-3xl font-bold">
                {{ $products->count() }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-5">

            <p class="text-gray-500">
                Produtos Ativos
            </p>

            <h2 class="text-3xl font-bold text-green-600">
                {{ $products->count() }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-5">

            <p class="text-gray-500">
                Stock Crítico
            </p>

            <h2 class="text-3xl font-bold text-red-600">
                {{ $products->where('quantity','<=',5)->count() }}
            </h2>

        </div>

    </div>

    <!-- Tabela -->

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="text-left p-4">
                        Produto
                    </th>

                    <th class="text-left p-4">
                        Preço
                    </th>

                    <th class="text-left p-4">
                        Stock
                    </th>

                    <th class="text-center p-4">
                        Ações
                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($products as $product)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-4 font-medium">

                        {{ $product->name }}

                    </td>

                    <td class="p-4">

                        {{ number_format($product->price,2) }} MZN

                    </td>

                    <td class="p-4">

@if($product->quantity <= 5)

    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
        🔴 Crítico
    </span>

@elseif($product->quantity <= 10)

    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
        🟡 Baixo
    </span>

@else

    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
        🟢 Normal
    </span>

@endif

<div class="text-xs text-gray-500 mt-1">
    {{ $product->quantity }} unidades
</div>

                    </td>

                    <td class="p-4">

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('products.edit', $product) }}"
                               class="bg-yellow-500 hover:bg-yellow-600
                                      text-black px-4 py-2 rounded-lg">

                                ✏ Editar

                            </a>

                            <form method="POST"
                                  action="{{ route('products.destroy',$product) }}"
                                  onsubmit="return confirm('Deseja realmente apagar este produto?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-500 hover:bg-red-600
                                           text-white px-4 py-2 rounded-lg">

                                    🗑 Apagar

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4"
                        class="text-center p-10 text-gray-500">

                        Nenhum produto cadastrado.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>