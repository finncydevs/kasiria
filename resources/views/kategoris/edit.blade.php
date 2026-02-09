@extends('layouts.app')

@section('title', 'Edit Kategori - Kasiria')
@section('page_title', 'Edit Kategori')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('kategoris.index') }}" class="hover:text-blue-400 transition-colors">Kategori</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Edit
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 glass-panel">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                <i class="fas fa-edit text-blue-400"></i> Edit Kategori
            </h2>
            
            <form action="{{ route('kategoris.update', $kategori) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Nama Kategori</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-tag"></i></span>
                            <input type="text" name="nama_kategori" class="glass-input w-full pl-10" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                        </div>
                        @error('nama_kategori')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Deskripsi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-align-left"></i></span>
                            <textarea name="deskripsi" rows="4" class="glass-input w-full pl-10">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                        </div>
                        @error('deskripsi')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-white/10 flex gap-3">
                        <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white px-6 py-2.5 shadow-lg shadow-blue-500/20">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('kategoris.index') }}" class="glass-btn bg-white/5 hover:bg-white/10 text-slate-300 px-6 py-2.5">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="glass-panel h-fit bg-gradient-to-br from-blue-900/20 to-purple-900/20 border-blue-500/10">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-blue-400"></i> Statistik Kategori
            </h3>
            <div class="space-y-4 text-sm text-slate-300">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/5 p-4 rounded-xl text-center border border-white/5">
                        <span class="block text-2xl font-bold text-white mb-1">{{ $kategori->getProductCountAttribute() }}</span>
                        <span class="text-xs text-slate-400 uppercase tracking-wide">Total Produk</span>
                    </div>
                    <div class="bg-white/5 p-4 rounded-xl text-center border border-white/5">
                         <span class="block text-2xl font-bold text-white mb-1">{{ $kategori->products()->sum('stok') }}</span>
                         <span class="text-xs text-slate-400 uppercase tracking-wide">Total Stok</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-white/10 text-xs text-slate-500 flex justify-between">
                    <span>Dibuat: {{ $kategori->created_at->format('d/m/Y') }}</span>
                    <span>Update: {{ $kategori->updated_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
