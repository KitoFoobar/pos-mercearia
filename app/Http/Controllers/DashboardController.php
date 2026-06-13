<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 📅 HOJE
        $today = Carbon::today();

        // 💰 VENDAS DE HOJE
        $salesToday = Sale::whereDate('created_at', $today)
            ->sum('total');

        // 📦 TOTAL DE PRODUTOS
        $productsCount = Product::count();

        // ⚠️ STOCK BAIXO
        $lowStockQuery = Product::where('quantity', '<=', 5);

        $lowStock = $lowStockQuery->count();
        $lowStockProducts = $lowStockQuery->get();

        // 🧾 ÚLTIMAS VENDAS (COM ITENS + PRODUTOS)
        $latestSales = Sale::with('items.product')
            ->latest()
            ->take(5)
            ->get();

        // 📊 VENDAS DA SEMANA
        $salesThisWeek = Sale::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->sum('total');

        // 📊 VENDAS DO MÊS
        $salesThisMonth = Sale::whereMonth('created_at', Carbon::now()->month)
            ->sum('total');

        // 🏆 TOP PRODUTOS MAIS VENDIDOS
        $topProducts = SaleItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'salesToday',
            'salesThisWeek',
            'salesThisMonth',
            'productsCount',
            'lowStock',
            'lowStockProducts',
            'latestSales',
            'topProducts'
        ));
    }
}