@extends('layouts.app')

@section('title', 'Tambah Produk - Kasiria')
@section('page_title', 'Tambah Produk')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('products.index') }}" class="hover:text-blue-400 transition-colors">Produk</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Tambah
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2 glass-panel">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                <i class="fas fa-box-open text-blue-400"></i> Tambah Produk Baru
            </h2>

            @if ($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl">
                    <ul class="mb-0 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <!-- Nama Produk -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Nama Produk</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-slate-500"><i class="fas fa-cube"></i></span>
                            <input type="text" name="nama_produk" class="glass-input w-full pl-10" placeholder="Masukkan nama produk" value="{{ old('nama_produk') }}" required>
                        </div>
                    </div>

                    <!-- Kode Barcode -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Kode Barcode</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-slate-500"><i class="fas fa-barcode"></i></span>
                            <input type="text" name="kode_barcode" class="glass-input w-full pl-10" placeholder="Scan atau ketik kode barcode" value="{{ old('kode_barcode') }}" required>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Kategori</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-slate-500"><i class="fas fa-tag"></i></span>
                            <select name="kategori_id" class="glass-input w-full pl-10" required>
                                <option value="" class="text-slate-800">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id') == $kategori->kategori_id ? 'selected' : '' }} class="text-slate-800">
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Harga Beli -->
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Harga Beli</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-slate-500">Rp</span>
                                <input type="number" name="harga_beli" class="glass-input w-full pl-10" placeholder="0" value="{{ old('harga_beli') }}" required>
                            </div>
                        </div>

                        <!-- Harga Jual -->
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Harga Jual</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-slate-500">Rp</span>
                                <input type="number" name="harga_jual" class="glass-input w-full pl-10" placeholder="0" value="{{ old('harga_jual') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Stok -->
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Stok Awal</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-slate-500"><i class="fas fa-cubes"></i></span>
                                <input type="number" name="stok" class="glass-input w-full pl-10" placeholder="0" value="{{ old('stok', 0) }}" required>
                            </div>
                        </div>

                        <!-- Satuan -->
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Satuan</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-slate-500"><i class="fas fa-ruler"></i></span>
                                <input type="text" name="satuan" class="glass-input w-full pl-10" placeholder="pcs, box, dll" value="{{ old('satuan') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" class="glass-input w-full" rows="3" placeholder="Deskripsi produk...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center cursor-pointer gap-3">
                            <div class="relative inline-block w-10 h-6 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="status" id="status" value="1" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer peer checked:right-0 checked:border-emerald-500 transition-all duration-300 right-4 border-slate-300" {{ old('status', true) ? 'checked' : '' }} />
                                <div class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-700 cursor-pointer peer-checked:bg-emerald-500/50 transition-colors duration-300"></div>
                            </div>
                            <span class="text-slate-200 font-medium">Produk Aktif</span>
                        </label>
                    </div>

                    <div class="flex gap-3 mt-6 pt-4 border-t border-white/10">
                        <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white px-6 py-2.5 shadow-lg shadow-blue-500/20">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                        <a href="{{ route('products.index') }}" class="glass-btn bg-white/5 hover:bg-white/10 text-slate-300 px-6 py-2.5">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Info Section -->
        <div class="glass-panel bg-white/5 h-fit">
            <h5 class="font-medium text-white mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-400"></i> Informasi Produk
            </h5>
            <div class="space-y-4 text-sm text-slate-300">
                <div class="p-3 rounded-lg bg-white/5 border border-white/5">
                    <strong class="text-purple-400 block mb-1">Kode Barcode</strong>
                    <p class="text-slate-400">Gunakan barcode scanner atau ketik manual kode unik produk.</p>
                </div>
                <div class="p-3 rounded-lg bg-white/5 border border-white/5">
                    <strong class="text-emerald-400 block mb-1">Harga Jual & Beli</strong>
                    <p class="text-slate-400">Pastikan margin keuntungan sesuai. Harga beli digunakan untuk laporan laba rugi.</p>
                </div>
                <div class="p-3 rounded-lg bg-white/5 border border-white/5">
                    <strong class="text-amber-400 block mb-1">Stok & Satuan</strong>
                    <p class="text-slate-400">Pantau stok secara berkala. Satuan membantu dalam identifikasi kemasan produk.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
