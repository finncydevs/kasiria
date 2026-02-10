@extends('layouts.app')

@section('title', $user->nama . ' - Pengguna')
@section('page_title', $user->nama)

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('users.index') }}" class="hover:text-blue-400 transition-colors">Pengguna</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Detail
    </li>
@endsection

@section('content')
    <div class="glass-panel">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 border-b border-white/10 pb-4">
            <div>
                <h2 class="text-xl font-semibold text-white">Detail Pengguna</h2>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('users.edit', $user) }}" class="glass-btn text-sm px-4 py-2 flex items-center gap-2 text-yellow-400 border-yellow-500/30 hover:bg-yellow-500/10">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('users.index') }}" class="glass-btn text-sm px-4 py-2">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1">
                <div class="bg-white/5 rounded-2xl p-6 text-center border border-white/10">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-3xl shadow-xl shadow-blue-500/20 mx-auto mb-4">
                        {{ substr($user->nama, 0, 1) }}
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">{{ $user->nama }}</h3>
                    <p class="text-slate-400 text-sm mb-4">{{ '@' . $user->username }}</p>
                    
                    <div class="flex justify-center gap-2 mb-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            {{ ucfirst($user->role) }}
                        </span>
                        @if($user->status)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20">
                                Nonaktif
                            </span>
                        @endif
                    </div>
                    
                    <form action="{{ route('users.reset-password', $user) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full glass-btn text-xs py-2 text-slate-300 hover:text-white border-white/10 hover:bg-white/5" onclick="return confirmSubmit(event, 'Reset password pengguna ini ke default? Password akan diubah menjadi default sistem.', 'Reset Password', 'warning')">
                            <i class="fas fa-key mr-2"></i> Reset Password
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="md:col-span-2">
                <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                    <h4 class="text-lg font-medium text-white mb-4 border-b border-white/5 pb-2">Informasi Kontak</h4>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <span class="text-slate-400 text-sm">Email</span>
                            <span class="col-span-2 text-slate-200 font-medium">{{ $user->email }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <span class="text-slate-400 text-sm">Nomor HP</span>
                            <span class="col-span-2 text-slate-200 font-medium">{{ $user->no_hp ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <span class="text-slate-400 text-sm">Terdaftar Sejak</span>
                            <span class="col-span-2 text-slate-200 font-medium">{{ $user->created_at->format('d F Y') }}</span>
                        </div>
                    </div>
                    
                    @if($user->points > 0)
                    <h4 class="text-lg font-medium text-white mb-4 mt-8 border-b border-white/5 pb-2">Loyalty Points</h4>
                    <div class="flex items-center gap-3">
                         <div class="w-10 h-10 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center">
                             <i class="fas fa-star"></i>
                         </div>
                         <div>
                             <p class="text-2xl font-bold text-white">{{ number_format($user->points) }}</p>
                             <p class="text-xs text-slate-400">Total Poin Terkumpul</p>
                         </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
