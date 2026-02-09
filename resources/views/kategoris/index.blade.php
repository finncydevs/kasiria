@extends('layouts.app')

@section('title', 'Data Kategori - Kasiria')
@section('page_title', 'Data Kategori')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Kategori
    </li>
@endsection

@section('content')
    <div class="glass-panel">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-xl font-semibold text-white">Data Kategori</h2>
                <p class="text-slate-400 text-sm mt-1">Kelola kategori produk untuk pengelompokan yang lebih baik.</p>
            </div>
            
            <a href="{{ route('kategoris.create') }}" class="glass-btn flex items-center gap-2">
                <i class="fas fa-plus"></i> <span>Tambah Kategori</span>
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="mb-6 glass-panel bg-white/5 !p-4">
            <form method="GET" action="{{ route('kategoris.index') }}" class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400"></i>
                    <input type="text" name="search" class="glass-input w-full pl-10" placeholder="Cari kategori..." value="{{ request('search') }}">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white px-6">
                        <i class="fas fa-search mr-2"></i> Cari
                    </button>
                    <a href="{{ route('kategoris.index') }}" class="glass-btn bg-white/5 hover:bg-white/10 text-slate-300 px-4">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto rounded-xl border border-white/10">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-xs text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4 w-16">No</th>
                        <th class="p-4">Nama Kategori</th>
                        <th class="p-4">Deskripsi</th>
                        <th class="p-4 text-center">Jumlah Produk</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($kategoris as $index => $kategori)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="p-4 text-slate-400 text-center">
                                {{ ($kategoris->currentPage() - 1) * $kategoris->perPage() + $loop->iteration }}
                            </td>
                            <td class="p-4 font-medium text-white group-hover:text-blue-400 transition-colors">
                                {{ $kategori->nama_kategori }}
                            </td>
                            <td class="p-4 text-slate-300 text-sm">
                                {{ Str::limit($kategori->deskripsi, 50) ?: '-' }}
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                    {{ $kategori->getProductCountAttribute() }} Produk
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('kategoris.show', $kategori) }}" class="p-2 rounded-lg hover:bg-white/10 text-blue-400 transition-colors" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kategoris.edit', $kategori) }}" class="p-2 rounded-lg hover:bg-white/10 text-yellow-400 transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kategori ini? Produk terkait mungkin akan terpengaruh.')">
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
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-tags text-4xl mb-3 opacity-20"></i>
                                    <p>Belum ada kategori ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $kategoris->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
