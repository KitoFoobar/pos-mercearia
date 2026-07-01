<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ], [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.string' => 'O nome do produto deve ser um texto válido.',
            'name.max' => 'O nome do produto não pode ter mais de 255 caracteres.',

            'price.required' => 'O preço do produto é obrigatório.',
            'price.numeric' => 'O preço deve ser um número válido.',
            'price.min' => 'O preço não pode ser negativo.',

            'quantity.required' => 'A quantidade em stock é obrigatória.',
            'quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'quantity.min' => 'A quantidade não pode ser negativa.',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer',
    ], [
        'name.required' => 'O nome do produto é obrigatório.',
        'price.required' => 'O preço do produto é obrigatório.',
        'quantity.required' => 'Informe a quantidade a adicionar ou remover.',
    ]);

    // 🔥 STOCK INTELIGENTE (incremento/decremento)
    $product->quantity += $validated['quantity'];

    // Atualiza dados normais
    $product->name = $validated['name'];
    $product->price = $validated['price'];

    $product->save();

    return redirect()->route('products.index')
        ->with('success', 'Produto atualizado com sucesso!');
}
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produto removido com sucesso!');
    }
}