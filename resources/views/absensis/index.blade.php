@extends('layouts.app')

@section('title', 'Laporan Absensi')

@section('page_title', 'Laporan Absensi')

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
            <span class="text-sm font-medium text-white">Laporan Absensi</span>
        </div>
    </li>
@endsection

@section('content')
<div class="space-y-6 animate-fade-in-up">

    <!-- Action Bar & Filter -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <!-- Date Filter Form -->
        <form action="{{ route('absensis.index') }}" method="GET" class="relative w-full sm:w-auto">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fas fa-calendar-alt"></i>
                </span>
                <input type="date" name="date" class="glass-input pl-10 pr-4 py-2 w-full sm:w-64 cursor-pointer" 
                       value="{{ $date }}" 
                       onchange="this.form.submit()">
            </div>
        </form>

        <!-- Scan Button -->
        <a href="{{ route('absensis.scan') }}" class="glass-btn flex items-center gap-2 w-full sm:w-auto justify-center">
            <i class="fas fa-qrcode"></i>
            <span>Scan Absensi</span>
        </a>
    </div>

    <!-- Stats Summary (Optional Enhancement) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass-panel p-4 flex items-center gap-3">
             <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-400">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 uppercase">Total Hadir</p>
                <p class="text-lg font-bold text-white">{{ $absensis->where('status', 'hadir')->count() }}</p>
            </div>
        </div>
         <div class="glass-panel p-4 flex items-center gap-3">
             <div class="w-10 h-10 rounded-lg bg-yellow-500/20 flex items-center justify-center text-yellow-400">
                <i class="fas fa-clock"></i>
            </div>
             <div>
                <p class="text-xs text-slate-400 uppercase">Terlambat</p>
                <!-- Simple logic assumption: > 08:00 is late, can be customized -->
                <p class="text-lg font-bold text-white">{{ $absensis->where('jam_masuk', '>', '08:00:00')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Log Table -->
    <div class="glass-panel p-0 overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-white/10">
            <h3 class="text-lg font-bold text-white">Log Absensi</h3>
            <span class="text-sm text-slate-400 bg-white/5 px-3 py-1 rounded-full border border-white/5">
                {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/10 text-xs text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Karyawan</th>
                        <th class="px-6 py-4 font-semibold">Jabatan</th>
                        <th class="px-6 py-4 font-semibold text-center">Jam Masuk</th>
                        <th class="px-6 py-4 font-semibold text-center">Jam Keluar</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm text-slate-300">
                    @forelse($absensis as $absensi)
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs">
                                    {{ strtoupper(substr($absensi->karyawan->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-white group-hover:text-blue-400 transition-colors">{{ $absensi->karyawan->nama }}</div>
                                    <div class="text-xs text-slate-500">{{ $absensi->karyawan->kode_karyawan }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs bg-white/5 text-slate-400 border border-white/10">
                                {{ $absensi->karyawan->jabatan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-mono">
                            <span class="text-green-400">{{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 text-center font-mono">
                            @if($absensi->jam_keluar)
                                <span class="text-red-400">{{ \Carbon\Carbon::parse($absensi->jam_keluar)->format('H:i') }}</span>
                            @else
                                <span class="text-slate-600">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($absensi->status == 'hadir')
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-400 border border-green-500/30">Hadir</span>
                            @elseif($absensi->status == 'sakit')
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">Sakit</span>
                            @elseif($absensi->status == 'izin')
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-blue-500/20 text-blue-400 border border-blue-500/30">Izin</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-400 border border-red-500/30">Alpha</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-400 italic">
                            {{ $absensi->keterangan ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <div class="mb-2 w-12 h-12 rounded-full bg-white/5 mx-auto flex items-center justify-center">
                                <i class="fas fa-calendar-times text-xl"></i>
                            </div>
                            <p>Tidak ada data absensi untuk tanggal ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
