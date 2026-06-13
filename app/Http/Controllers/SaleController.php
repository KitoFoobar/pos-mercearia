<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('sales.pos', compact('products'));
    }

    public function checkout(Request $request)
    {
        $cart = $request->cart;

        // 🧠 1. validar carrinho vazio
        if (!$cart || count($cart) === 0) {
            return response()->json([
                'message' => 'Carrinho vazio!'
            ], 400);
        }

        // 💰 2. criar venda principal
        $sale = Sale::create([
            'total' => $request->total
        ]);

        // 🧾 3. percorrer itens do carrinho
        foreach ($cart as $item) {

            $product = Product::find($item['id']);

            // ❌ validar produto
            if (!$product) {
                continue;
            }

            // ❌ validar stock suficiente
            if ($product->quantity < $item['qty']) {
                return response()->json([
                    'message' => "Stock insuficiente para: {$product->name}"
                ], 400);
            }

            // 🧾 guardar item da venda
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $item['qty'],
                'price' => $product->price
            ]);

            // 📉 baixar stock
            $product->quantity -= $item['qty'];
            $product->save();
        }

        return response()->json([
            'message' => 'Venda realizada com sucesso!',
            'sale_id' => $sale->id
        ]);
    }
}