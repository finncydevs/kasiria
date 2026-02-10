@extends('layouts.app')

@section('title', 'Data Pelanggan - Kasiria')
@section('page_title', 'Data Pelanggan')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Pelanggan
    </li>
@endsection

@section('content')
    <div class="glass-panel">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-xl font-semibold text-white">Data Pelanggan</h2>
                <p class="text-slate-400 text-sm mt-1">Kelola data pelanggan dan level keanggotaan.</p>
            </div>
            
            <a href="{{ route('pelanggans.create') }}" class="glass-btn flex items-center gap-2">
                <i class="fas fa-plus"></i> <span>Tambah Pelanggan</span>
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 glass-panel bg-white/5 !p-4">
            <form method="GET" action="{{ route('pelanggans.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3">
                <div class="md:col-span-5 relative">
                    <i class="fas fa-search absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400"></i>
                    <input type="text" name="search" class="glass-input w-full pl-10" placeholder="Cari nama, no HP, atau email..." value="{{ request('search') }}">
                </div>
                <div class="md:col-span-3">
                    <select name="status" class="glass-input w-full">
                        <option value="" class="text-slate-800">-- Semua Status --</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }} class="text-slate-800">Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }} class="text-slate-800">Tidak Aktif</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white w-full">
                        <i class="fas fa-search mr-2"></i> Cari
                    </button>
                </div>
                <div class="md:col-span-2">
                    <a href="{{ route('pelanggans.index') }}" class="glass-btn bg-white/5 hover:bg-white/10 text-slate-300 w-full text-center">
                        <i class="fas fa-redo mr-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto rounded-xl border border-white/10">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-xs text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4 w-16">No</th>
                        <th class="p-4">Nama Pelanggan</th>
                        <th class="p-4">Kontak</th>
                        <th class="p-4">Member Level</th>
                        <th class="p-4 text-center">Poin</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($pelanggans as $index => $pelanggan)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="p-4 text-slate-400 text-center">
                                {{ ($pelanggans->currentPage() - 1) * $pelanggans->perPage() + $loop->iteration }}
                            </td>
                            <td class="p-4 font-medium text-white group-hover:text-blue-400 transition-colors">
                                {{ $pelanggan->nama }}
                            </td>
                            <td class="p-4 text-slate-300 text-sm">
                                <div class="flex flex-col gap-1">
                                    <span class="flex items-center gap-2"><i class="fas fa-phone text-xs text-slate-500 w-4"></i> {{ $pelanggan->no_hp ?? '-' }}</span>
                                    <span class="flex items-center gap-2"><i class="fas fa-envelope text-xs text-slate-500 w-4"></i> {{ $pelanggan->email ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                @if($pelanggan->member_level)
                                    <span class="px-2 py-1 rounded text-xs bg-purple-500/10 text-purple-400 border border-purple-500/20">
                                        {{ $pelanggan->member_level }}
                                    </span>
                                @else
                                    <span class="text-slate-500 text-xs italic">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <span class="text-yellow-400 font-bold"><i class="fas fa-coins text-[10px] mr-1"></i> {{ $pelanggan->poin }}</span>
                            </td>
                            <td class="p-4 text-center">
                                @if($pelanggan->status)
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('pelanggans.show', $pelanggan) }}" class="p-2 rounded-lg hover:bg-white/10 text-blue-400 transition-colors" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pelanggans.edit', $pelanggan) }}" class="p-2 rounded-lg hover:bg-white/10 text-yellow-400 transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pelanggans.destroy', $pelanggan) }}" method="POST" class="inline-block" onsubmit="return confirmSubmit(event, 'Yakin ingin menghapus pelanggan ini? Semua data terkait akan hilang.', 'Hapus Pelanggan', 'delete')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 rounded-lg hover:bg-red-500/10 text-red-400 transition-colors" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-users text-4xl mb-3 opacity-20"></i>
                                    <p>Belum ada pelanggan ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $pelanggans->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
