<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    protected $fillable = [
        'product_id',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
	public function index(Request $request)
{
    $query = StockEntry::with('product');

    // 🔍 filtro por produto
    if ($request->product_id) {
        $query->where('product_id', $request->product_id);
    }

    // 📅 filtro por data inicial
    if ($request->from) {
        $query->whereDate('created_at', '>=', $request->from);
    }

    // 📅 filtro por data final
    if ($request->to) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    $entries = $query->latest()->paginate(10);

    $products = Product::all();

    return view('stock.history', compact('entries', 'products'));
}
}