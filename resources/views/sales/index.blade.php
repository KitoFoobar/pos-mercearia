<x-app-layout>

<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">
        Histórico de Vendas
    </h1>

    <table class="w-full border">

        <tr class="bg-gray-200">
            <th class="p-2">Venda</th>
            <th class="p-2">Data</th>
            <th class="p-2">Total</th>
            <th class="p-2">Ação</th>
        </tr>

        @foreach($sales as $sale)

        <tr class="border">
            <td class="p-2">#{{ $sale->id }}</td>

            <td class="p-2">
                {{ $sale->created_at }}
            </td>

            <td class="p-2">
                {{ number_format($sale->total,2) }} MZN
            </td>

            <td class="p-2">

                <a
                    href="{{ route('sales.show',$sale->id) }}"
                    class="bg-blue-600 text-white px-3 py-1 rounded"
                >
                    Ver
                </a>

            </td>
        </tr>

        @endforeach

    </table>

</div>

</x-app-layout>