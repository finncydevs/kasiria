<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics.
     */
    public function index()
    {
        if (auth()->user()->isPelanggan()) {
            return redirect()->route('pelanggan.dashboard');
        }

        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // Get statistics
        $totalSales = Transaction::whereDate('created_at', $today)->sum('total');
        $transactionCount = Transaction::whereDate('created_at', $today)->count();
        $totalUsers = User::where('status', true)->count();
    // Default minimum stock threshold (produks table doesn't have min_stock column)
    $minStockThreshold = 10;
    $lowStockProducts = Product::where('stok', '<=', $minStockThreshold)->count();

        // Monthly sales trend
        $monthlySales = Transaction::whereDate('created_at', '>=', $thisMonth)
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->get();

        // Top cashiers
        $topCashiers = User::withCount(['transactions' => function ($query) use ($thisMonth) {
                $query->where('created_at', '>=', $thisMonth);
            }])
            ->withSum(['transactions' => function ($query) use ($thisMonth) {
                $query->where('created_at', '>=', $thisMonth);
            }], 'total')
            ->where('role', 'kasir')
            ->orderBy('transactions_sum_total', 'desc')
            ->take(5)
            ->get();

        // Recent transactions
        $recentTransactions = Transaction::with(['cashier', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Low stock products
        $lowStockList = Product::where('stok', '<=', $minStockThreshold)
            ->orderBy('stok', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', [
            'totalSales' => $totalSales,
            'transactionCount' => $transactionCount,
            'totalUsers' => $totalUsers,
            'lowStockProducts' => $lowStockProducts,
            'monthlySales' => $monthlySales,
            'topCashiers' => $topCashiers,
            'recentTransactions' => $recentTransactions,
            'lowStockList' => $lowStockList,
        ]);
    }
}
