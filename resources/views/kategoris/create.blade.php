@extends('layouts.app')

@section('title', 'Tambah Kategori - Kasiria')
@section('page_title', 'Tambah Kategori')

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
        Tambah
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 glass-panel">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                <i class="fas fa-plus-circle text-blue-400"></i> Tambah Kategori Baru
            </h2>
            
            <form action="{{ route('kategoris.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Nama Kategori</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-tag"></i></span>
                            <input type="text" name="nama_kategori" class="glass-input w-full pl-10" placeholder="Masukkan nama kategori" value="{{ old('nama_kategori') }}" required>
                        </div>
                        @error('nama_kategori')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Deskripsi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-align-left"></i></span>
                            <textarea name="deskripsi" rows="4" class="glass-input w-full pl-10" placeholder="Deskripsi singkat kategori...">{{ old('deskripsi') }}</textarea>
                        </div>
                        @error('deskripsi')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-white/10 flex gap-3">
                        <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white px-6 py-2.5 shadow-lg shadow-blue-500/20">
                            <i class="fas fa-save mr-2"></i> Simpan
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
                <i class="fas fa-info-circle text-blue-400"></i> Informasi
            </h3>
            <div class="space-y-4 text-sm text-slate-300">
                <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                    <p class="font-medium text-white mb-1"><i class="fas fa-tag mr-2 text-blue-400"></i>Nama Kategori</p>
                    <p class="text-slate-400 text-xs">Gunakan nama yang unik dan mudah dikenali untuk mengelompokkan produk Anda.</p>
                </div>
                <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                    <p class="font-medium text-white mb-1"><i class="fas fa-pencil-alt mr-2 text-purple-400"></i>Deskripsi</p>
                    <p class="text-slate-400 text-xs">Tambahkan penjelasan singkat untuk membantu staff mengenali jenis produk dalam kategori ini.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
