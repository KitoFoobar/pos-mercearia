<x-app-layout>

<div style="padding:20px;">

    <h2>Produtos</h2>

    <a href="{{ route('products.create') }}">
        ➕ Novo Produto
    </a>

    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Stock</th>
            <th>Ações</th>
        </tr>

        @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->quantity }}</td>
            <td>
                <a href="{{ route('products.edit', $product) }}">Editar</a>

                <form method="POST" action="{{ route('products.destroy', $product) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button>Apagar</button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>

</div>

</x-app-layout>