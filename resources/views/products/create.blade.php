<x-app-layout>

<div style="padding:20px;">

<h2>Novo Produto</h2>

<form method="POST" action="{{ route('products.store') }}">
@csrf

<input type="text" name="name" placeholder="Nome"><br><br>
<input type="number" name="price" placeholder="Preço"><br><br>
<input type="number" name="quantity" placeholder="Stock"><br><br>

<button>Guardar</button>

</form>

</div>

</x-app-layout>