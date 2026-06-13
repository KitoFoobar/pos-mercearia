<x-app-layout>

<div style="padding:20px;">

<h2>Editar Produto</h2>

<form method="POST" action="{{ route('products.update', $product) }}">
@csrf
@method('PUT')

<input type="text" name="name" value="{{ $product->name }}"><br><br>
<input type="number" name="price" value="{{ $product->price }}"><br><br>
<input type="number" name="quantity" value="{{ $product->quantity }}"><br><br>

<button>Atualizar</button>

</form>

</div>

</x-app-layout>