@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="header mb-5">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white mb-1">Halo, {{ $user->nama }}! 👋</h1>
            <p class="text-slate-400 text-sm">Selamat datang di member area Kasiria.</p>
        </div>
        <div class="flex items-center gap-3">
             <div class="px-4 py-1.5 rounded-full text-sm font-bold border {{ $badgeColor }}">
                <i class="fas fa-crown mr-1"></i> {{ $memberStatus }} Member
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Points Card -->
    <div class="glass-panel p-6 relative overflow-hidden group col-span-1 md:col-span-2">
        <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity">
            <i class="fas fa-star text-9xl text-yellow-500"></i>
        </div>
        <div class="relative z-10 flex flex-col h-full justify-between">
            <div>
                <h3 class="text-slate-400 text-sm font-medium mb-1 uppercase tracking-wider">Poin Loyalty</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-5xl font-bold text-white">{{ number_format($user->points) }}</span>
                    <span class="text-slate-400 font-medium">pts</span>
                </div>
            </div>
            
            <div class="mt-6">
                <div class="w-full bg-white/10 rounded-full h-2 mb-2">
                    @php
                        $percentage = 0;
                        $nextLevel = '';
                        $pointsNeeded = 0;
                        if ($user->points < 1000) {
                            $percentage = ($user->points / 1000) * 100;
                            $nextLevel = 'Silver';
                            $pointsNeeded = 1000 - $user->points;
                        } elseif ($user->points < 5000) {
                            $percentage = (($user->points - 1000) / 4000) * 100;
                            $nextLevel = 'Gold';
                            $pointsNeeded = 5000 - $user->points;
                        } else {
                            $percentage = 100;
                            $nextLevel = 'Max Level';
                            $pointsNeeded = 0;
                        }
                    @endphp
                    <div class="bg-blue-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                </div>
                @if($pointsNeeded > 0)
                    <p class="text-xs text-slate-400">Dapatkan <span class="text-white font-bold">{{ number_format($pointsNeeded) }}</span> poin lagi untuk mencapai member {{ $nextLevel }}!</p>
                @else
                    <p class="text-xs text-green-400 font-medium"><i class="fas fa-check-circle mr-1"></i> Kamu adalah member prioritas!</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Order CTA -->
    <div class="glass-panel p-6 flex flex-col justify-center items-center text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-purple-600/20 opacity-50"></div>
        <div class="relative z-10 w-full">
            <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/30">
                <i class="fas fa-utensils text-white text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Lapar?</h3>
            <p class="text-slate-300 text-sm mb-6 line-clamp-2">Pesan makanan dan minuman favoritmu tanpa antri.</p>
            <a href="{{ route('pelanggan.order') }}" class="btn btn-primary w-full group">
                Buat Pesanan Baru <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="glass-panel p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-white">Riwayat Pesanan Terakhir</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 text-sm border-b border-white/10">
                    <th class="pb-3 pl-4 font-medium">No. Transaksi</th>
                    <th class="pb-3 font-medium">Tanggal</th>
                    <th class="pb-3 font-medium">Total</th>
                    <th class="pb-3 font-medium">Status</th>
                    <th class="pb-3 pr-4 font-medium">Items</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($recentOrders as $order)
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors group">
                    <td class="py-4 pl-4 font-mono text-slate-300">{{ $order->transaction_number }}</td>
                    <td class="py-4 text-slate-300">{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td class="py-4 font-bold text-white">Rp {{ number_format($order->total) }}</td>
                    <td class="py-4">
                        @if($order->status == 'completed')
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">Selesai</span>
                        @elseif($order->status == 'pending')
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Pending</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">{{ ucfirst($order->status) }}</span>
                        @endif
                    </td>
                    <td class="py-4 pr-4 text-slate-400">
                        {{ $order->items_count ?? $order->items->sum('quantity') }} items
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-slate-500">
                        <i class="fas fa-receipt text-4xl mb-3 opacity-30"></i>
                        <p>Belum ada pesanan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
