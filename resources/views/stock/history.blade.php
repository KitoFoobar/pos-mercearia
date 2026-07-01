<x-app-layout>

<div class="min-h-screen bg-slate-50 p-6">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Histórico de Stock</h1>
        <p class="text-gray-500">Entradas de reposição de produtos</p>
    </div>

    {{-- FILTROS --}}
    <form method="GET" class="bg-white p-4 rounded-2xl shadow mb-6">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            {{-- Produto --}}
            <select name="product_id" class="border rounded-xl p-2">
                <option value="">Todos os produtos</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}"
                        {{ request('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>

            {{-- Data inicial --}}
            <input type="date"
                   name="from"
                   value="{{ request('from') }}"
                   class="border rounded-xl p-2">

            {{-- Data final --}}
            <input type="date"
                   name="to"
                   value="{{ request('to') }}"
                   class="border rounded-xl p-2">

            {{-- Botão --}}
            <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-4 py-2 font-bold">
                Filtrar
            </button>

        </div>

    </form>

    {{-- TABELA --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full text-left">

            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-4">Produto</th>
                    <th class="p-4">Quantidade</th>
                    <th class="p-4">Data</th>
                </tr>
            </thead>

            <tbody>

                @forelse($entries as $entry)

                    <tr class="border-t hover:bg-gray-50">

                        {{-- Produto --}}
                        <td class="p-4 font-medium">
                            {{ $entry->product->name }}
                        </td>

                        {{-- Quantidade --}}
                        <td class="p-4 text-green-600 font-bold">
                            +{{ $entry->quantity }}
                        </td>

                        {{-- Data --}}
                        <td class="p-4 text-gray-500">
                            {{ $entry->created_at->format('d/m/Y H:i') }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="3" class="p-6 text-center text-gray-500">
                            Nenhum registo encontrado
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINAÇÃO --}}
    <div class="mt-4">
        {{ $entries->links() }}
    </div>

</div>

</x-app-layout>