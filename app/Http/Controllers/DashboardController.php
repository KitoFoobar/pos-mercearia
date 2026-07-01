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

        // 🧾 ÚLTIMAS VENDAS
        $latestSales = Sale::with('items.product')
            ->latest()
            ->take(5)
            ->get();

        // 📊 VENDAS SEMANA
        $salesThisWeek = Sale::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->sum('total');

        // 📊 VENDAS MÊS
        $salesThisMonth = Sale::whereMonth('created_at', Carbon::now()->month)
            ->sum('total');

        // 🏆 TOP PRODUTOS MAIS VENDIDOS
        $topProducts = SaleItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->take(5)
            ->get();

        // 📈 GRÁFICO DE VENDAS (ÚLTIMOS 7 DIAS)
        $salesChart = Sale::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('dashboard', compact(
            'salesToday',
            'salesThisWeek',
            'salesThisMonth',
            'productsCount',
            'lowStock',
            'lowStockProducts',
            'latestSales',
            'topProducts',
            'salesChart'
        ));
    }
}