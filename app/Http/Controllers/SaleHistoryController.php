<?php

namespace App\Http\Controllers;

use App\Models\Sale;

class SaleHistoryController extends Controller
{
    public function index()
    {
        $sales = Sale::latest()->get();

        return view('sales.index', compact('sales'));
    }

    public function show($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);

        return view('sales.show', compact('sale'));
    }
}