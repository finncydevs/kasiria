<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

   public function __construct()
    {
        // ===============================================
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            if (!in_array($user->role, ['owner', 'kasir'])) {
                // Jika kasir mencoba mengakses, alihkan ke dashboard
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk mengelola Kategori.');
            }
            return $next($request);
        });
    }

    /**
     * Display sales report.
     */
    public function sales()
    {
        $transactions = Transaction::with('cashier')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('reports.sales', compact('transactions'));
    }

    /**
     * Display daily sales report.
     */
    public function dailySales(Request $request)
    {
        $date = $request->input('date', today());

        $dailySales = Transaction::whereDate('created_at', $date)
            ->with('cashier')
            ->selectRaw('DATE(created_at) as date, SUM(total) as total, COUNT(*) as count')
            ->groupBy('date')
            ->first();

        $transactions = Transaction::whereDate('created_at', $date)
            ->with('cashier', 'items.product')
            ->get();

        return view('reports.daily-sales', compact('date', 'dailySales', 'transactions'));
    }

    /**
     * Display monthly sales report.
     */
    public function monthlySales(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $monthlySales = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->selectRaw('DATE(created_at) as date, SUM(total) as total, COUNT(*) as count')
            ->groupBy('date')
            ->get();

        $totalSales = $monthlySales->sum('total');
        $totalTransactions = $monthlySales->sum('count');

        return view('reports.monthly-sales', compact('month', 'year', 'monthlySales', 'totalSales', 'totalTransactions'));
    }

    /**
     * Display product performance report.
     */
    public function products()
    {
        $products = Product::withCount('transactionItems')
            ->withSum('transactionItems', 'quantity')
            ->get()
            ->sortByDesc('transaction_items_sum_quantity');

        return view('reports.products', compact('products'));
    }

    /**
     * Display cashier performance report.
     */
    public function cashiers()
    {
        $cashiers = User::where('role', 'kasir')
            ->withCount('transactions')
            ->withSum('transactions', 'total')
            ->orderBy('transactions_sum_total', 'desc')
            ->get();

        return view('reports.cashiers', compact('cashiers'));
    }

    /**
     * Export reports to CSV.
     */
    public function export(Request $request)
    {
        $type = $request->input('type', 'sales');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $fileName = 'laporan_' . $type . '_' . now()->format('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        if ($type === 'sales') {
            return response()->stream(function () use ($startDate, $endDate) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['ID', 'Nomor Transaksi', 'Kasir', 'Total', 'Tanggal']);

                $transactions = Transaction::when($startDate, fn ($q) => $q->where('created_at', '>=', $startDate))
                    ->when($endDate, fn ($q) => $q->where('created_at', '<=', $endDate))
                    ->with('cashier')
                    ->get();

                foreach ($transactions as $transaction) {
                    fputcsv($handle, [
                        $transaction->id,
                        $transaction->transaction_number,
                        $transaction->cashier->nama,
                        $transaction->total,
                        $transaction->created_at->format('Y-m-d H:i:s'),
                    ]);
                }

                fclose($handle);
            }, 200, $headers);
        }

        return back()->with('error', 'Tipe laporan tidak ditemukan.');
    }
}
