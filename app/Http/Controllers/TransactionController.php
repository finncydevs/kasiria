<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions.
     */
    public function index()
    {
        $transactions = Transaction::with(['cashier', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        $products = Product::where('status', true)->get();
        $transactionNumber = Transaction::generateTransactionNumber();

        return view('transactions.create', compact('products', 'transactionNumber'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:100',
            'payment_method' => 'required|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $itemsData = [];

            // Calculate subtotal and prepare items
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $itemSubtotal = $item['quantity'] * $item['unit_price'];
                $itemDiscount = $item['discount'] ?? 0;
                $itemTotal = $itemSubtotal - $itemDiscount;

                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $itemSubtotal,
                    'discount' => $itemDiscount,
                    'total' => $itemTotal,
                ];

                $subtotal += $itemTotal;

                // Update product stock
                $product->update(['stock' => $product->stock - $item['quantity']]);
            }

            $discount = $validated['discount'] ?? 0;
            $tax = $validated['tax'] ?? 0;
            $total = $subtotal - $discount + $tax;
            $change = $validated['amount_paid'] - $total;

            // Create transaction
            $transaction = Transaction::create([
                'transaction_number' => Transaction::generateTransactionNumber(),
                'cashier_id' => auth()->id(),
                'customer_name' => $validated['customer_name'],
                'payment_method' => $validated['payment_method'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'amount_paid' => $validated['amount_paid'],
                'change' => $change,
                'notes' => $validated['notes'] ?? null,
                'status' => 'completed',
            ]);

            // Create transaction items
            foreach ($itemsData as $itemData) {
                $transaction->items()->create($itemData);
            }

            DB::commit();

            return redirect()->route('transactions.show', $transaction)->with('success', 'Transaksi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membuat transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['cashier', 'items.product']);
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Get transaction details (API).
     */
    public function details(Transaction $transaction)
    {
        return response()->json($transaction->load(['cashier', 'items.product']));
    }

    /**
     * Generate receipt for transaction.
     */
    public function receipt(Transaction $transaction)
    {
        $transaction->load(['cashier', 'items.product']);
        return view('transactions.receipt', compact('transaction'));
    }

    /**
     * Process refund for transaction.
     */
    public function refund(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Restore product stock
            foreach ($transaction->items as $item) {
                $product = Product::findOrFail($item->product_id);
                $product->update(['stock' => $product->stock + $item->quantity]);
            }

            // Update transaction status
            $transaction->update(['status' => 'refunded']);

            DB::commit();

            return back()->with('success', 'Transaksi berhasil dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pengembalian: ' . $e->getMessage());
        }
    }
}
