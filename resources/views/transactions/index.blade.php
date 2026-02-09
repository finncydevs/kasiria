@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page_title', 'Riwayat Transaksi')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Transaksi
    </li>
@endsection

@section('content')
<div class="glass-panel">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-xl font-semibold text-white">Daftar Transaksi</h2>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <div class="relative w-full md:w-64">
                <i class="fas fa-search absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-sm"></i>
                <input type="text" placeholder="Cari transaksi..." class="glass-input w-full pl-9">
            </div>
            
            <a href="{{ route('transactions.create') }}" class="glass-btn flex items-center gap-2 whitespace-nowrap">
                <i class="fas fa-plus"></i> <span class="hidden sm:inline">Transaksi Baru</span>
            </a>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex gap-2 mb-6 border-b border-white/10 overflow-x-auto">
        <a href="{{ route('transactions.index') }}" 
           class="px-4 py-2 text-sm font-medium border-b-2 transition-colors {{ !request('status') ? 'border-blue-500 text-blue-400' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
           Semua
        </a>
        <a href="{{ route('transactions.index', ['status' => 'pending']) }}" 
           class="px-4 py-2 text-sm font-medium border-b-2 transition-colors {{ request('status') == 'pending' ? 'border-yellow-500 text-yellow-400 bg-yellow-500/5' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
           <i class="fas fa-clock mr-1"></i> Pesanan Masuk
        </a>
        <a href="{{ route('transactions.index', ['status' => 'completed']) }}" 
           class="px-4 py-2 text-sm font-medium border-b-2 transition-colors {{ request('status') == 'completed' ? 'border-green-500 text-green-400' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
           Riwayat Selesai
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-white/10 text-xs text-slate-400 uppercase tracking-wider">
                    <th class="p-4">ID</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Pelanggan</th>
                    <th class="p-4 text-right">Total</th>
                    <th class="p-4">Metode</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-white/5">
                @forelse($transactions as $t)
                <tr class="hover:bg-white/5 transition-colors group">
                    <td class="p-4 font-medium text-white group-hover:text-blue-400 transition-colors">
                        #{{ $t->transaction_number ?? $t->id }}
                    </td>
                    <td class="p-4 text-slate-300">
                        {{ optional($t->created_at)->format('d M Y H:i') }}
                    </td>
                    <td class="p-4 text-slate-300">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-slate-700 flex items-center justify-center text-xs text-white">
                                {{ substr($t->pelanggan->nama ?? $t->customer_name ?? 'U', 0, 1) }}
                            </div>
                            {{ $t->pelanggan->nama ?? $t->customer_name ?? 'Umum' }}
                        </div>
                    </td>
                    <td class="p-4 text-right font-bold text-white">
                        Rp {{ number_format($t->total ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="p-4 text-slate-300">
                        <span class="px-2 py-1 rounded text-xs border border-white/10 bg-white/5">
                            {{ ucfirst($t->payment_method ?? ($t->metode_bayar ?? '-')) }}
                        </span>
                    </td>
                    <td class="p-4">
                        @php
                            $status = $t->status;
                            $color = match($status) {
                                'completed' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
                                'pending' => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20',
                                'refunded' => 'text-red-400 bg-red-500/10 border-red-500/20',
                                default => 'text-slate-400 bg-slate-500/10 border-slate-500/20'
                            };
                            $icon = match($status) {
                                'completed' => 'fa-check',
                                'pending' => 'fa-clock',
                                'refunded' => 'fa-undo',
                                default => 'fa-circle'
                            };
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium border {{ $color }} flex items-center gap-1 w-fit">
                            <i class="fas {{ $icon }} text-[10px]"></i> {{ ucfirst($status) }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <a href="{{ route('transactions.show', $t) }}" class="p-2 rounded-lg hover:bg-white/10 text-blue-400 transition-all" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-receipt text-4xl mb-3 opacity-20"></i>
                            <p>Belum ada transaksi</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
