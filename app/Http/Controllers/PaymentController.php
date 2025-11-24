<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Configure Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Show Midtrans Snap payment page for a transaction.
     */
    public function showSnap(Transaction $transaction)
    {
        try {
            $orderId = 'TRX-' . $transaction->id . '-' . time();

            $transactionDetails = [
                'order_id' => $orderId,
                'gross_amount' => (int)$transaction->total,
            ];

            $customerDetails = [
                'first_name' => auth()->user()->nama ?? 'Customer',
                'email' => auth()->user()->email ?? 'customer@example.com',
                'phone' => auth()->user()->no_hp ?? '',
            ];

            $itemDetails = [];
            foreach ($transaction->items as $item) {
                $itemDetails[] = [
                    'id' => $item->product_id,
                    'price' => (int)$item->unit_price,
                    'quantity' => (int)$item->quantity,
                    'name' => optional($item->product)->nama_produk ?? 'Product',
                ];
            }

            $payload = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $itemDetails,
            ];

            $snapToken = Snap::getSnapToken($payload);

            return view('payment.snap', compact('transaction', 'snapToken'));
        } catch (\Exception $e) {
            // Log detailed info for debugging (do not log full keys in production)
            \Log::error('Midtrans showSnap error', [
                'transaction_id' => $transaction->id,
                'server_key_prefix' => substr(config('services.midtrans.server_key'), 0, 6),
                'is_production' => config('services.midtrans.is_production'),
                'exception' => $e->getMessage(),
            ]);

            return back()->with('error', 'Error generating payment token: ' . $e->getMessage());
        }
    }

    /**
     * Create a payment token for a transaction via Midtrans Snap.
     */
    public function createPayment(Request $request)
    {
        $validated = $request->validate([
            'transaction_data' => 'required|json',
        ]);

        // Decode transaction data from form submission
        $txData = json_decode($validated['transaction_data'], true);

        try {
            // Generate a unique transaction ID (you can use transaction_number later)
            $orderId = 'TRX-' . time() . '-' . random_int(1000, 9999);

            $transactionDetails = [
                'order_id' => $orderId,
                'gross_amount' => (int)$txData['total'],
            ];

            $customerDetails = [
                'first_name' => auth()->user()->nama ?? 'Customer',
                'email' => auth()->user()->email ?? 'customer@example.com',
                'phone' => auth()->user()->no_hp ?? '',
            ];

            $itemDetails = [];
            foreach ($txData['items'] as $item) {
                $itemDetails[] = [
                    'id' => $item['product_id'],
                    'price' => (int)$item['unit_price'],
                    'quantity' => (int)$item['quantity'],
                    'name' => $item['product_name'] ?? 'Product',
                ];
            }

            $payload = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $itemDetails,
                'custom_field1' => json_encode($txData), // Store entire transaction data
            ];

            // Generate Snap token
            $snapToken = Snap::getSnapToken($payload);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Exception $e) {
            // Log payload and exception for debugging
            \Log::error('Midtrans createPayment error', [
                'order_id' => $orderId ?? null,
                'server_key_prefix' => substr(config('services.midtrans.server_key'), 0, 6),
                'is_production' => config('services.midtrans.is_production'),
                'payload' => isset($payload) ? json_encode($payload) : null,
                'exception' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error creating payment: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Handle Midtrans webhook callback.
     */
    public function handleCallback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;

        // Find transaction by order_id (you may need to store order_id in transactions table)
        // For now, we'll log the callback
        \Log::info('Midtrans callback received', [
            'order_id' => $orderId,
            'status' => $transactionStatus,
            'gross_amount' => $request->gross_amount,
        ]);

        // Update transaction status if payment is successful
        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            // Mark transaction as completed/paid
            // Transaction::where('order_id', $orderId)->update(['status' => 'completed', 'payment_status' => 'paid']);
        } elseif ($transactionStatus === 'deny' || $transactionStatus === 'cancel' || $transactionStatus === 'expire') {
            // Mark transaction as failed
            // Transaction::where('order_id', $orderId)->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * Cancel a pending payment.
     */
    public function cancelPayment(Transaction $transaction)
    {
        try {
            // You can add logic here to cancel the payment in Midtrans if needed
            $transaction->update(['status' => 'cancelled']);
            return back()->with('success', 'Pembayaran dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
