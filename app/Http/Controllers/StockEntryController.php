<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockEntry;
use Illuminate\Http\Request;

class StockEntryController extends Controller
{
    public function create()
    {
        $products = Product::all();
        return view('stock.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // aumenta stock
        $product->quantity += $request->quantity;
        $product->save();

        // guarda histórico
        StockEntry::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'Stock atualizado com sucesso!');
    }
	public function index(Request $request)
{
    $query = \App\Models\StockEntry::with('product');

    // filtro por produto
    if ($request->product_id) {
        $query->where('product_id', $request->product_id);
    }

    // filtro data inicial
    if ($request->from) {
        $query->whereDate('created_at', '>=', $request->from);
    }

    // filtro data final
    if ($request->to) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    $entries = $query->latest()->paginate(10);

    $products = \App\Models\Product::all();

    return view('stock.history', compact('entries', 'products'));
}
}