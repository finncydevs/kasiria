<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Transaction::with(['cashier', 'items.product', 'pelanggan'])
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        $transactions = $query->paginate(20);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        // Assuming column is 'stok'
        $products = Product::where('status', true)->where('stok', '>', 0)->get();
        $pelanggans = Pelanggan::all();

        // Ensure this method exists in your Model, or remove it if using auto-increment ID
        $transactionNumber = method_exists(Transaction::class, 'generateTransactionNumber')
            ? Transaction::generateTransactionNumber()
            : 'TRX-' . time();

        return view('transactions.create', compact('products', 'pelanggans', 'transactionNumber'));
    }

    public function store(Request $request)
    {
        // Validate Request
        $validated = $request->validate([
            'pelanggan_id'       => 'nullable|exists:pelanggans,id',
            'payment_method'     => 'required|string|max:50',
            'payment_option'     => 'required|in:save_only,pay_now', // New: choose save or pay now
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:produks,id', // Ensure table name is correct (produks or products)
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.discount'   => 'nullable|numeric|min:0',
            'discount'           => 'nullable|numeric|min:0',
            'tax'                => 'nullable|numeric|min:0',
            'amount_paid'        => 'required|numeric|min:0',
            'notes'              => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                // Use lockForUpdate to prevent race conditions on stock
                $product = Product::where('id', $item['product_id'])->lockForUpdate()->first();

                if (!$product) {
                    throw new \Exception("Produk tidak ditemukan.");
                }

                if ($product->stok < $item['quantity']) {
                    throw new \Exception("Stok produk {$product->nama_produk} tidak mencukupi.");
                }

                $unitPrice = $product->harga_jual;
                $quantity = (int)$item['quantity'];
                $itemDiscount = isset($item['discount']) ? (float)$item['discount'] : 0;

                $itemSubtotal = ($unitPrice * $quantity) - $itemDiscount;
                $subtotal += $itemSubtotal;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'quantity'   => $quantity,
                    'unit_price' => $unitPrice,
                    'discount'   => $itemDiscount,
                    'subtotal'   => $itemSubtotal, // Ensure your DB table has this column, or remove if calculated on fly
                    'total'      => $itemSubtotal, // Redundant? adjust based on your DB schema
                ];

                // Decrement Stock
                $product->decrement('stok', $quantity);
            }

            $globalDiscount = $request->discount ?? 0;
            $globalTax = $request->tax ?? 0;
            $grandTotal = ($subtotal - $globalDiscount) + $globalTax;

            // Validate Payment Amount
            if ($request->amount_paid < $grandTotal) {
                throw new \Exception("Jumlah bayar kurang dari total transaksi.");
            }

            $change = $request->amount_paid - $grandTotal;

            // Create Transaction Header
            $transaction = Transaction::create([
                'transaction_number' => $request->transaction_number ?? 'TRX-'.time(), // Handle logic
                'cashier_id'     => auth()->id() ?? 1,
                'pelanggan_id'   => $request->pelanggan_id,
                'payment_method' => $request->payment_method,
                'subtotal'       => $subtotal,
                'discount'       => $globalDiscount,
                'tax'            => $globalTax,
                'total'          => $grandTotal,
                'amount_paid'    => $validated['payment_option'] === 'pay_now' ? 0 : $request->amount_paid,
                'change'         => $validated['payment_option'] === 'pay_now' ? 0 : $change,
                'notes'          => $request->notes,
                'status'         => $validated['payment_option'] === 'pay_now' ? 'pending' : 'completed',
            ]);

            // Create Transaction Items
            // Assumes relation name is 'items' in Transaction model
            $transaction->items()->createMany($itemsData);

            // Award Points to Cashier (User)
            // Rule: 1 Point per 1000 IDR
            $pointsEarned = intval($grandTotal / 1000);
            if ($pointsEarned > 0 && auth()->check()) {
                auth()->user()->addPoints($pointsEarned, "Sales Commission: TRX-" . $transaction->transaction_number);
            }

            DB::commit();

            // If pay_now, redirect to payment page
            if ($validated['payment_option'] === 'pay_now') {
                return redirect()->route('payment.snap', $transaction->id)
                                 ->with('success', 'Silakan lanjutkan pembayaran.');
            }

            return redirect()->route('transactions.show', $transaction->id)
                             ->with('success', 'Transaksi berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['cashier', 'items.product', 'pelanggan']);
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show printable receipt for a transaction.
     */
    public function receipt(Transaction $transaction)
    {
        $transaction->load(['cashier', 'items.product', 'pelanggan']);

        return view('transactions.receipt', compact('transaction'));
    }

    public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi tidak dalam status pending.');
        }

        try {
            DB::beginTransaction();
            
            $transaction->update(['status' => 'completed']);
            
            // If points/commission logic needs to happen on approval instead of creation
            // It could be moved here. Current logic awards points on creation.

            DB::commit();
            return back()->with('success', 'Transaksi berhasil disetujui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyetujui transaksi: ' . $e->getMessage());
        }
    }

    public function refund(Request $request, Transaction $transaction)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        try {
            DB::beginTransaction();

            foreach ($transaction->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    // FIXED: usage of 'stok' instead of 'stock'
                    $product->increment('stok', $item->quantity);
                }
            }

            $transaction->update(['status' => 'refunded']);

            DB::commit();
            return back()->with('success', 'Transaksi berhasil dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
