<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PelangganDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Calculate Member Status
        $memberStatus = 'Bronze';
        $badgeColor = 'text-amber-700 bg-amber-100 border-amber-200';
        
        if ($user->points >= 5000) {
            $memberStatus = 'Gold';
            $badgeColor = 'text-yellow-700 bg-yellow-100 border-yellow-200';
        } elseif ($user->points >= 1000) {
            $memberStatus = 'Silver';
            $badgeColor = 'text-slate-700 bg-slate-100 border-slate-200';
        }

        // Recent Orders
        $recentOrders = Transaction::where('customer_user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('user', 'memberStatus', 'badgeColor', 'recentOrders'));
    }

    public function order()
    {
        // Get active products with stock
        $products = Product::where('status', true)
            ->where('stok', '>', 0)
            ->get();
            
        return view('customer.order', compact('products'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $items = $request->items;
            $totalAmount = 0;
            $transactionItems = [];

            // Calculate total and prepare items
            foreach ($items as $item) {
                $product = Product::find($item['id']); // efficient enough for small cart
                
                if ($product->stok < $item['qty']) {
                    throw new \Exception("Stok produk {$product->nama_produk} tidak mencukupi.");
                }

                $subtotal = $product->harga_jual * $item['qty'];
                $totalAmount += $subtotal;

                $transactionItems[] = [
                    'product' => $product,
                    'qty' => $item['qty'],
                    'price' => $product->harga_jual,
                    'subtotal' => $subtotal
                ];
            }

            // Create Transaction
            $transaction = Transaction::create([
                'transaction_number' => Transaction::generateTransactionNumber(),
                'cashier_id' => null, // Self-service
                'customer_user_id' => $user->id,
                'customer_name' => $user->nama, // Snapshot name
                'payment_method' => 'cash', // Default to cash/pay at counter for now, or transfer
                'subtotal' => $totalAmount,
                'discount' => 0,
                'tax' => 0,
                'total' => $totalAmount,
                'amount_paid' => 0, // Not paid yet
                'change' => 0,
                'status' => 'pending', // Pending payment/processing
                'notes' => 'Self-service order via Web'
            ]);

            // Create Transaction Items and Deduct Stock
            foreach ($transactionItems as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal']
                ]);

                // Deduct stock immediately (or reserve it)
                $item['product']->decrement('stok', $item['qty']);
            }

            DB::commit();

            return response()->json([
                'success' => true, 
                'message' => 'Pesanan berhasil dibuat! Silahkan lakukan pembayaran di kasir.',
                'redirect' => route('pelanggan.dashboard')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false, 
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage()
            ], 400);
        }
    }
}
