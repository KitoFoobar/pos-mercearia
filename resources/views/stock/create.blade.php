<x-app-layout>

<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">Entrada de Stock</h1>

    @if(session('success'))
        <div class="bg-green-100 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('stock.store') }}" class="space-y-4">
        @csrf

        <div>
            <label>Produto</label>
            <select name="product_id" class="w-full border p-2">
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Quantidade</label>
            <input type="number" name="quantity" class="w-full border p-2">
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Adicionar Stock
        </button>

    </form>

</div>

</x-app-layout>