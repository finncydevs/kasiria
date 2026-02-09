@extends('layouts.app')

@section('title', 'Detail Transaksi - ' . ($transaction->transaction_number ?? ''))
@section('page_title', 'Detail Transaksi')

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
        {{ $transaction->transaction_number }}
    </li>
@endsection

@section('content')
    <div class="glass-panel">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 border-b border-white/10 pb-4">
            <div>
                <h2 class="text-xl font-semibold text-white">Detail Transaksi</h2>
                <p class="text-slate-400 text-sm mt-1">ID: <span class="text-blue-400 font-mono">{{ $transaction->transaction_number }}</span></p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('transactions.receipt', $transaction) }}" class="glass-btn text-sm px-4 py-2 flex items-center gap-2" target="_blank">
                    <i class="fas fa-print"></i> Struk
                </a>
                @if($transaction->status !== 'refunded')
                    <form action="{{ route('transactions.refund', $transaction) }}" method="POST" class="inline-block" onsubmit="return confirm('Proses pengembalian untuk transaksi ini?')">
                        @csrf
                        <button type="submit" class="bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 px-4 py-2 rounded-xl text-sm font-medium transition-all flex items-center gap-2">
                            <i class="fas fa-undo"></i> Refund
                        </button>
                    </form>
                @endif
                <a href="{{ route('transactions.index') }}" class="bg-white/5 hover:bg-white/10 text-slate-300 border border-white/10 px-4 py-2 rounded-xl text-sm font-medium transition-all">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                <h5 class="text-lg font-medium text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-400"></i> Informasi Umum
                </h5>
                <div class="space-y-3">
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Tanggal</span>
                        <span class="text-slate-200">{{ optional($transaction->created_at)->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Kasir</span>
                        <span class="text-slate-200">{{ $transaction->cashier->nama ?? $transaction->cashier->username ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Pelanggan</span>
                        <span class="text-slate-200">{{ $transaction->customer_name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between pb-2">
                        <span class="text-slate-400">Metode Bayar</span>
                        <span class="text-slate-200 px-2 py-0.5 rounded bg-white/10 text-xs">{{ ucfirst($transaction->payment_method) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                <h5 class="text-lg font-medium text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-calculator text-emerald-400"></i> Ringkasan Pembayaran
                </h5>
                <div class="space-y-3">
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Subtotal</span>
                        <span class="text-slate-200 font-mono">Rp {{ number_format($transaction->subtotal,0,',','.') }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Diskon</span>
                        <span class="text-red-400 font-mono">- Rp {{ number_format($transaction->discount ?? 0,0,',','.') }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Pajak</span>
                        <span class="text-slate-200 font-mono">+ Rp {{ number_format($transaction->tax ?? 0,0,',','.') }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="font-bold text-white">Total Akhir</span>
                        <span class="font-bold text-emerald-400 text-lg font-mono">Rp {{ number_format($transaction->total,0,',','.') }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Dibayar</span>
                        <span class="text-slate-200 font-mono">Rp {{ number_format($transaction->amount_paid,0,',','.') }}</span>
                    </div>
                    <div class="flex justify-between pt-1">
                        <span class="text-slate-400">Kembalian</span>
                        <span class="text-emerald-400 font-mono">Rp {{ number_format($transaction->change,0,',','.') }}</span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/10 text-center">
                        @php
                            $status = $transaction->status;
                            $color = match($status) {
                                'completed' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
                                'pending' => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20',
                                'refunded' => 'text-red-400 bg-red-500/10 border-red-500/20',
                                default => 'text-slate-400 bg-slate-500/10 border-slate-500/20'
                            };
                        @endphp
                        <span class="px-4 py-1.5 rounded-full text-sm font-bold border {{ $color }} inline-block">
                            {{ strtoupper($status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="text-lg font-medium text-white mb-4">Item Transaksi</h5>
        <div class="overflow-x-auto rounded-xl border border-white/10">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-xs text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Produk</th>
                        <th class="p-4 text-right">Harga Satuan</th>
                        <th class="p-4 text-center">Jumlah</th>
                        <th class="p-4 text-right">Diskon Item</th>
                        <th class="p-4 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($transaction->items as $item)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="p-4 text-slate-200">{{ $item->product->nama_produk ?? $item->product->name ?? '—' }}</td>
                            <td class="p-4 text-right text-slate-300 font-mono">Rp {{ number_format($item->unit_price,0,',','.') }}</td>
                            <td class="p-4 text-center text-slate-300">{{ $item->quantity }}</td>
                            <td class="p-4 text-right text-slate-300 font-mono">{{ $item->discount > 0 ? 'Rp '.number_format($item->discount,0,',','.') : '-' }}</td>
                            <td class="p-4 text-right font-bold text-emerald-400 font-mono">Rp {{ number_format($item->total,0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
