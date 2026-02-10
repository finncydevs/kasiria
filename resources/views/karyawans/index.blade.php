@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('page_title', 'Data Karyawan')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium hover:text-white transition-colors">
            <i class="fas fa-home mr-2"></i>
            Dashboard
        </a>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-xs mx-2"></i>
            <span class="text-sm font-medium text-white">Data Karyawan</span>
        </div>
    </li>
@endsection

@section('content')
<div class="space-y-6 animate-fade-in-up">
    
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="relative w-full sm:w-64">
             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-slate-400"></i>
            </div>
            <input type="text" id="searchInput" class="glass-input pl-10 w-full" placeholder="Cari karyawan...">
        </div>
        
        <a href="{{ route('karyawans.create') }}" class="glass-btn flex items-center gap-2">
            <i class="fas fa-plus"></i>
            <span>Tambah Karyawan</span>
        </a>
    </div>

    <!-- Employee Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($karyawans as $karyawan)
        <div class="glass-panel group relative overflow-hidden transition-all hover:-translate-y-1 hover:shadow-blue-500/10">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-id-card text-8xl text-white"></i>
            </div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col h-full">
                <!-- Header: Initial & Role -->
                <div class="flex items-start justify-between mb-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-2xl font-bold text-white shadow-lg">
                        {{ strtoupper(substr($karyawan->nama, 0, 2)) }}
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-300 border border-blue-500/30">
                            {{ $karyawan->jabatan }}
                        </span>
                        <span class="mt-1 text-xs text-slate-400 font-mono">{{ $karyawan->kode_karyawan }}</span>
                    </div>
                </div>

                <!-- Info -->
                <div class="mt-2 space-y-2 flex-1">
                    <h3 class="text-lg font-bold text-white truncate" title="{{ $karyawan->nama }}">{{ $karyawan->nama }}</h3>
                    
                    @if($karyawan->user)
                    <div class="flex items-center text-sm text-slate-300">
                        <i class="fas fa-user-circle w-5 text-center text-purple-400 mr-2"></i>
                        <span class="truncate">{{ $karyawan->user->username }}</span>
                    </div>
                    @endif
                    
                    <div class="flex items-center text-sm text-slate-300">
                        <i class="fas fa-phone w-5 text-center text-green-400 mr-2"></i>
                        <span>{{ $karyawan->no_hp ?? '-' }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 flex items-center justify-between border-t border-white/10 pt-4">
                    <a href="{{ route('karyawans.print-qr', $karyawan->id) }}" class="text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors flex items-center gap-1">
                        <i class="fas fa-qrcode"></i> QR Code
                    </a>
                    
                    <div class="flex items-center gap-2">
                        <a href="{{ route('karyawans.edit', $karyawan->id) }}" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-yellow-400 transition-colors" title="Edit">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                        <form action="{{ route('karyawans.destroy', $karyawan->id) }}" method="POST" onsubmit="return confirm('Hapus karyawan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-red-500/20 flex items-center justify-center text-red-400 hover:text-red-300 transition-colors" title="Hapus">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        <!-- Empty State -->
        @if($karyawans->isEmpty())
        <div class="col-span-full py-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/5 mb-4">
                <i class="fas fa-users-slash text-3xl text-slate-500"></i>
            </div>
            <h3 class="text-lg font-medium text-white">Belum ada data karyawan</h3>
            <p class="text-slate-400 mt-1">Silakan tambahkan karyawan baru.</p>
        </div>
        @endif
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let cards = document.querySelectorAll('.glass-panel');

    cards.forEach(card => {
        let text = card.textContent.toLowerCase();
        if(text.includes(filter)) {
            card.style.display = "";
        } else {
            card.style.display = "none";
        }
    });
});
</script>
@endsection
