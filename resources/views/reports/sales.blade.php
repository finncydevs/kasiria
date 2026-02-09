@extends('layouts.app')

@section('title', 'Laporan Penjualan - Kasiria')
@section('page_title', 'Laporan Penjualan')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Laporan Penjualan
    </li>
@endsection

@section('content')
    <div class="glass-panel">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 border-b border-white/10 pb-4">
            <div>
                <h2 class="text-xl font-semibold text-white">Laporan Penjualan</h2>
                <p class="text-slate-400 text-sm mt-1">Rekapitulasi transaksi penjualan berdasarkan periode.</p>
            </div>
            
            <div class="flex items-center gap-3">
                 <div class="px-4 py-2 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium">
                    Total: Rp {{ number_format($transactions->sum('total'), 0, ',', '.') }}
                 </div>
            </div>
        </div>

        <div class="mb-6 glass-panel bg-white/5 !p-4">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="glass-input w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="glass-input w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Kasir</label>
                    <select name="cashier_id" class="glass-input w-full">
                        <option value="" class="text-slate-800">Semua Kasir</option>
                        @foreach(\App\Models\User::where('role','!=','owner')->get() as $c)
                            <option value="{{ $c->id }}" {{ request('cashier_id') == $c->id ? 'selected' : '' }} class="text-slate-800">
                                {{ $c->nama ?? $c->username }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white flex-1">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    <a href="{{ route('reports.export', array_merge(request()->all(), ['type' => 'sales'])) }}" class="glass-btn bg-emerald-600/80 hover:bg-emerald-600 text-white px-3" title="Export CSV">
                        <i class="fas fa-file-csv"></i>
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto rounded-xl border border-white/10">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-xs text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">No. Transaksi</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Kasir</th>
                        <th class="p-4">Pelanggan</th>
                        <th class="p-4">Metode</th>
                        <th class="p-4 text-right">Total</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="p-4 font-medium text-white group-hover:text-blue-400 transition-colors">
                                <a href="{{ route('transactions.show', $tx) }}">
                                    {{ $tx->transaction_number }}
                                </a>
                            </td>
                            <td class="p-4 text-slate-300 text-sm">
                                {{ $tx->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-4 text-slate-300">
                                {{ $tx->cashier->nama ?? $tx->cashier->username ?? '-' }}
                            </td>
                            <td class="p-4 text-slate-300">
                                {{ $tx->customer_name ?? '-' }}
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded text-xs bg-white/10 text-slate-300 border border-white/10">
                                    {{ ucfirst($tx->payment_method) }}
                                </span>
                            </td>
                            <td class="p-4 text-right font-medium text-emerald-400">
                                Rp {{ number_format($tx->total, 0, ',', '.') }}
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('transactions.receipt', $tx) }}" class="p-2 rounded-lg hover:bg-white/10 text-blue-400 transition-colors" target="_blank" title="Cetak Struk">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-file-invoice-dollar text-4xl mb-3 opacity-20"></i>
                                    <p>Tidak ada data transaksi perihode ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $transactions->appends(request()->all())->links() }}
        </div>
    </div>
@endsection
