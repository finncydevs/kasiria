@extends('layouts.app')

@section('title', 'Pembayaran Transaksi - Kasiria')
@section('page_title', 'Pembayaran Transaksi')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('transactions.index') }}" class="hover:text-blue-400 transition-colors">Transaksi</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Pembayaran
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 glass-panel">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                <i class="fas fa-receipt text-blue-400"></i> Ringkasan Transaksi #{{ $transaction->transaction_number }}
            </h2>
            
            <div class="overflow-x-auto rounded-xl border border-white/10 mb-6">
                <table class="w-full text-left">
                    <thead class="bg-white/5 text-xs text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="p-4">Produk</th>
                            <th class="p-4 text-right">Qty</th>
                            <th class="p-4 text-right">Harga</th>
                            <th class="p-4 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($transaction->items as $item)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="p-4 text-white">{{ optional($item->product)->nama_produk ?? 'Produk' }}</td>
                                <td class="p-4 text-right text-slate-300">{{ $item->quantity }}</td>
                                <td class="p-4 text-right text-slate-300">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="p-4 text-right font-medium text-emerald-400">Rp {{ number_format($item->total ?? $item->subtotal ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col items-end space-y-2 text-sm text-slate-300 border-t border-white/10 pt-4">
                <div class="flex justify-between w-full md:w-1/2">
                    <span>Subtotal</span>
                    <span class="font-medium text-white">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between w-full md:w-1/2">
                    <span>Diskon</span>
                    <span class="font-medium text-red-400">-Rp {{ number_format($transaction->discount ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between w-full md:w-1/2">
                    <span>Pajak</span>
                    <span class="font-medium text-white">+Rp {{ number_format($transaction->tax ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between w-full md:w-1/2 pt-2 border-t border-white/10 mt-2">
                    <span class="text-lg font-bold text-white">Total</span>
                    <span class="text-lg font-bold text-emerald-400">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="glass-panel h-fit bg-gradient-to-br from-blue-900/20 to-purple-900/20 border-blue-500/10">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <i class="fas fa-credit-card text-blue-400"></i> Pembayaran
            </h3>
            
            <div class="bg-white/5 p-4 rounded-xl border border-white/5 mb-6">
                <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Metode Pembayaran</p>
                <p class="text-white font-medium text-lg">{{ ucfirst($transaction->payment_method) }}</p>
            </div>

            <button type="button" id="pay-button" class="glass-btn bg-emerald-600/80 hover:bg-emerald-600 text-white w-full py-3 shadow-lg shadow-emerald-500/20 text-lg font-semibold mb-3">
                <i class="fas fa-lock mr-2"></i> Bayar Sekarang
            </button>

            <a href="{{ route('transactions.show', $transaction) }}" class="glass-btn bg-white/5 hover:bg-white/10 text-slate-300 w-full text-center py-2.5">
                Kembali
            </a>

            <div class="mt-6 flex items-center justify-center gap-2 text-xs text-slate-500 opacity-70">
                <i class="fas fa-shield-alt"></i>
                <span>Pembayaran aman dengan Midtrans</span>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap Script -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            // Trigger snap payment popup
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    // Payment success
                    console.log('Payment successful:', result);
                    alert('Pembayaran berhasil! Transaksi sedang diproses.');
                    window.location.href = "{{ route('transactions.show', $transaction) }}";
                },
                onPending: function(result){
                    console.log('Payment pending:', result);
                    alert('Pembayaran sedang diproses, silakan selesaikan di browser Anda.');
                },
                onError: function(result){
                    console.log('Payment error:', result);
                    alert('Pembayaran gagal! Silakan coba lagi.');
                },
                onClose: function(){
                    console.log('Payment popup closed');
                }
            });
        });
    </script>
@endsection
