@extends('layouts.app')

@section('title', 'Edit Produk - ' . $product->nama_produk)
@section('page_title', 'Edit Produk')

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
        Edit
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2 glass-panel">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                <i class="fas fa-edit text-yellow-400"></i> Edit Produk
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

            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <!-- Nama Produk -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Nama Produk</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-slate-500"><i class="fas fa-cube"></i></span>
                            <input type="text" name="nama_produk" class="glass-input w-full pl-10" value="{{ old('nama_produk', $product->nama_produk) }}" required>
                        </div>
                    </div>

                    <!-- Kode Barcode -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Kode Barcode</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-slate-500"><i class="fas fa-barcode"></i></span>
                            <input type="text" name="kode_barcode" class="glass-input w-full pl-10" value="{{ old('kode_barcode', $product->kode_barcode) }}" required>
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
                                    <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id', $product->kategori_id) == $kategori->kategori_id ? 'selected' : '' }} class="text-slate-800">
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
                                <input type="number" name="harga_beli" class="glass-input w-full pl-10" value="{{ old('harga_beli', $product->harga_beli) }}" required>
                            </div>
                        </div>

                        <!-- Harga Jual -->
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Harga Jual</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-slate-500">Rp</span>
                                <input type="number" name="harga_jual" class="glass-input w-full pl-10" value="{{ old('harga_jual', $product->harga_jual) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Stok -->
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Stok</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-slate-500"><i class="fas fa-cubes"></i></span>
                                <input type="number" name="stok" class="glass-input w-full pl-10" value="{{ old('stok', $product->stok) }}" required>
                            </div>
                        </div>

                        <!-- Satuan -->
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Satuan</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-slate-500"><i class="fas fa-ruler"></i></span>
                                <input type="text" name="satuan" class="glass-input w-full pl-10" value="{{ old('satuan', $product->satuan) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" class="glass-input w-full" rows="3">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center cursor-pointer gap-3">
                            <div class="relative inline-block w-10 h-6 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="status" id="status" value="1" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer peer checked:right-0 checked:border-emerald-500 transition-all duration-300 right-4 border-slate-300" {{ old('status', $product->status) ? 'checked' : '' }} />
                                <div class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-700 cursor-pointer peer-checked:bg-emerald-500/50 transition-colors duration-300"></div>
                            </div>
                            <span class="text-slate-200 font-medium">Produk Aktif</span>
                        </label>
                    </div>

                    <div class="flex gap-3 mt-6 pt-4 border-t border-white/10">
                        <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white px-6 py-2.5 shadow-lg shadow-blue-500/20">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('products.index') }}" class="glass-btn bg-white/5 hover:bg-white/10 text-slate-300 px-6 py-2.5">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Info Section -->
        <div class="glass-panel bg-white/5 h-fit border-l-4 border-l-yellow-500">
            <h5 class="font-medium text-white mb-2">Edit Mode</h5>
            <p class="text-sm text-slate-400 mb-4">
                Anda sedang mengedit produk <strong>{{ $product->nama_produk }}</strong>. Pastikan data yang dimasukkan akurat terutama harga dan stok.
            </p>
            
            <div class="p-3 rounded-lg bg-black/20 border border-white/5 text-center">
                <p class="text-xs text-slate-500 mb-1">Keuntungan per unit</p>
                @php
                    $margin = $product->harga_jual - $product->harga_beli;
                @endphp
                <p class="text-lg font-bold {{ $margin >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                    Rp {{ number_format($margin, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
@endsection
