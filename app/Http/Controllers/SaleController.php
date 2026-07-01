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
        $products = Product::orderBy('name')->get();

        return view('sales.pos', compact('products'));
    }

    public function checkout(Request $request)
    {
        $cart = $request->cart;

        /*
        |--------------------------------------------------------------------------
        | VALIDAR CARRINHO
        |--------------------------------------------------------------------------
        */

        if (!$cart || count($cart) === 0) {

            return response()->json([
                'error' => 'Carrinho vazio!'
            ], 400);
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDAR STOCK ANTES DE CRIAR VENDA
        |--------------------------------------------------------------------------
        */

        foreach ($cart as $item) {

            $product = Product::find($item['id']);

            if (!$product) {

                return response()->json([
                    'error' => 'Produto não encontrado.'
                ], 400);
            }

            if ($product->quantity < $item['qty']) {

                return response()->json([
                    'error' => "Stock insuficiente para {$product->name}"
                ], 400);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CALCULAR VALORES
        |--------------------------------------------------------------------------
        */

        $total = $request->total;
        $cash  = $request->cash ?? 0;
        $change = $cash - $total;

        /*
        |--------------------------------------------------------------------------
        | CRIAR VENDA
        |--------------------------------------------------------------------------
        */

        $sale = Sale::create([
            'total' => $total,
            'received' => $cash,
            'change' => $change
        ]);

        /*
        |--------------------------------------------------------------------------
        | GUARDAR ITENS E BAIXAR STOCK
        |--------------------------------------------------------------------------
        */

        foreach ($cart as $item) {

            $product = Product::find($item['id']);

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $item['qty'],
                'price' => $product->price
            ]);

            $product->quantity -= $item['qty'];
            $product->save();
        }

        /*
        |--------------------------------------------------------------------------
        | RESPOSTA
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'message' => 'Venda realizada com sucesso!',
            'sale_id' => $sale->id
        ]);
    }

    public function receipt($id)
    {
        $sale = Sale::with([
            'items.product'
        ])->findOrFail($id);

        return view('sales.receipt', compact('sale'));
    }
}