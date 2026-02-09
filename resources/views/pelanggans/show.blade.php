@extends('layouts.app')

@section('title', 'Detail Pelanggan - Kasiria')
@section('page_title', 'Detail Pelanggan')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('pelanggans.index') }}" class="hover:text-blue-400 transition-colors">Pelanggan</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        {{ $pelanggan->nama }}
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Info Columns -->
        <div class="glass-panel h-fit space-y-6">
            <!-- Profile Info -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-user-circle text-blue-400"></i> Profil
                    </h2>
                    <div class="flex gap-2">
                        <a href="{{ route('pelanggans.edit', $pelanggan) }}" class="p-2 rounded-lg bg-yellow-500/10 text-yellow-400 hover:bg-yellow-500/20 transition-colors" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('pelanggans.destroy', $pelanggan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-colors" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="p-3 rounded-xl bg-white/5 border border-white/5">
                        <span class="text-xs text-slate-500 block mb-1">Nama Lengkap</span>
                        <p class="text-white font-medium">{{ $pelanggan->nama }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-white/5 border border-white/5">
                        <span class="text-xs text-slate-500 block mb-1">Kontak</span>
                        <div class="flex flex-col gap-1">
                            @if($pelanggan->email)
                                <a href="mailto:{{ $pelanggan->email }}" class="text-blue-400 hover:underline text-sm flex items-center gap-2">
                                    <i class="fas fa-envelope text-xs"></i> {{ $pelanggan->email }}
                                </a>
                            @endif
                            @if($pelanggan->no_hp)
                                <a href="https://wa.me/{{ str_replace(['0', '+', ' ', '-'], '', $pelanggan->no_hp) }}" target="_blank" class="text-emerald-400 hover:underline text-sm flex items-center gap-2">
                                    <i class="fab fa-whatsapp text-xs"></i> {{ $pelanggan->no_hp }}
                                </a>
                            @endif
                            @if(!$pelanggan->email && !$pelanggan->no_hp)
                                <span class="text-slate-400 text-sm italic">-</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-white/5 border border-white/5">
                        <span class="text-xs text-slate-500 block mb-1">Alamat</span>
                        <p class="text-slate-300 text-sm">{{ $pelanggan->alamat ?: '-' }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-white/5 border border-white/5 flex justify-between items-center">
                        <span class="text-xs text-slate-500">Status Akun</span>
                        @if($pelanggan->status)
                            <span class="px-2 py-1 rounded text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Aktif</span>
                        @else
                            <span class="px-2 py-1 rounded text-xs font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20">Nonaktif</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats Info -->
            <div class="pt-6 border-t border-white/10">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2 mb-4">
                    <i class="fas fa-chart-pie text-purple-400"></i> Statistik
                </h2>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gradient-to-br from-blue-600/20 to-blue-900/20 p-3 rounded-xl border border-blue-500/20 text-center">
                        <span class="block text-xl font-bold text-white">{{ $pelanggan->getTotalTransactionsAttribute() }}</span>
                        <span class="text-xs text-blue-300">Transaksi</span>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-600/20 to-yellow-900/20 p-3 rounded-xl border border-yellow-500/20 text-center">
                        <span class="block text-xl font-bold text-yellow-400">{{ $pelanggan->poin }}</span>
                        <span class="text-xs text-yellow-300">Poin</span>
                    </div>
                    <div class="col-span-2 bg-gradient-to-br from-emerald-600/20 to-emerald-900/20 p-3 rounded-xl border border-emerald-500/20 text-center">
                        <span class="block text-xl font-bold text-emerald-400">Rp {{ number_format($pelanggan->getTotalSpendingAttribute(), 0, ',', '.') }}</span>
                        <span class="text-xs text-emerald-300">Total Belanja</span>
                    </div>
                </div>
                
                 @if($pelanggan->member_level)
                    <div class="mt-4 p-3 rounded-xl bg-purple-500/10 border border-purple-500/20 text-center">
                        <span class="text-xs text-purple-300 uppercase tracking-widest block mb-1">Level Member</span>
                        <span class="text-lg font-bold text-white">{{ $pelanggan->member_level }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Transactions History -->
        <div class="lg:col-span-2 glass-panel">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                <i class="fas fa-history text-slate-400"></i> Riwayat Transaksi
            </h2>

            <div class="overflow-x-auto rounded-xl border border-white/10">
                <table class="w-full text-left">
                    <thead class="bg-white/5 text-xs text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="p-4">No Transaksi</th>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="p-4 font-medium text-white group-hover:text-blue-400 transition-colors">
                                    {{ $transaction->transaction_number }}
                                </td>
                                <td class="p-4 text-slate-400 text-sm">
                                    {{ $transaction->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="p-4 font-medium text-emerald-400">
                                    Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                </td>
                                <td class="p-4">
                                     @if ($transaction->status === 'completed')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            Selesai
                                        </span>
                                    @elseif ($transaction->status === 'pending')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('transactions.show', $transaction) }}" class="p-2 rounded-lg hover:bg-white/10 text-blue-400 transition-colors" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('transactions.receipt', $transaction) }}" class="p-2 rounded-lg hover:bg-white/10 text-purple-400 transition-colors" title="Cetak">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-500">
                                    <p>Belum ada riwayat transaksi.</p>
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
    </div>
@endsection
