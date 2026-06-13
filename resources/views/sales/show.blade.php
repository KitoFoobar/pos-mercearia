<x-app-layout>

<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">
        Venda #{{ $sale->id }}
    </h1>

    <table class="w-full border">

        <tr class="bg-gray-200">
            <th class="p-2">Produto</th>
            <th class="p-2">Qtd</th>
            <th class="p-2">Preço</th>
        </tr>

        @foreach($sale->items as $item)

        <tr>
            <td class="p-2">
                {{ $item->product->name }}
            </td>

            <td class="p-2">
                {{ $item->quantity }}
            </td>

            <td class="p-2">
                {{ number_format($item->price,2) }} MZN
            </td>
        </tr>

        @endforeach

    </table>

    <div class="mt-6 text-xl font-bold">
        Total:
        {{ number_format($sale->total,2) }} MZN
    </div>

</div>

</x-app-layout>