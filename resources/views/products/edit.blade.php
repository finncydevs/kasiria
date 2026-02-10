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

            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Foto Produk</label>
                        
                        <!-- Current Image Preview -->
                        @if($product->gambar)
                            <div class="mb-3">
                                <p class="text-xs text-slate-500 mb-2">Foto Saat Ini:</p>
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="Current Image" class="h-32 rounded-lg object-cover border border-white/10">
                            </div>
                        @endif

                        <div class="flex items-center justify-center w-full">
                            <label for="gambar" class="flex flex-col items-center justify-center w-full h-32 border-2 border-white/10 border-dashed rounded-lg cursor-pointer bg-white/5 hover:bg-white/10 transition-colors group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-slate-400 mb-2 group-hover:text-blue-400 transition-colors"></i>
                                    <p class="text-xs text-slate-400">Ganti Foto (Max 2MB)</p>
                                    <p class="text-[10px] text-slate-500">Biarkan kosong jika tidak ingin mengubah</p>
                                </div>
                                <input id="gambar" name="gambar" type="file" class="hidden" accept="image/*" onchange="previewImage(this)">
                            </label>
                        </div>
                        <div id="image-preview" class="mt-2 hidden">
                            <p class="text-xs text-slate-500 mb-2">Preview Foto Baru:</p>
                            <img src="" alt="Preview" class="h-32 rounded-lg object-cover border border-white/10">
                        </div>
                    </div>

                    <!-- Nama Produk -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Nama Produk</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-cube"></i></span>
                            <input type="text" name="nama_produk" class="glass-input w-full pl-10" value="{{ old('nama_produk', $product->nama_produk) }}" required>
                        </div>
                    </div>

                    <!-- Kode Barcode -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Kode Barcode</label>
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-barcode"></i></span>
                                <input type="text" name="kode_barcode" id="kode_barcode" class="glass-input w-full pl-10" value="{{ old('kode_barcode', $product->kode_barcode) }}" required>
                            </div>
                            <button type="button" class="glass-btn px-4 bg-white/5 hover:bg-white/10 active:bg-blue-500/20 transition-colors" onclick="toggleScanner()" title="Scan Barcode">
                                <i class="fas fa-qrcode text-blue-400"></i>
                            </button>
                        </div>

                        <!-- Scanner Container -->
                        <div id="product-scanner-wrapper" class="hidden mt-4 rounded-lg overflow-hidden border border-white/10 relative bg-black/20">
                             <x-scanner />
                             <button type="button" class="absolute top-2 right-2 bg-red-500/80 hover:bg-red-500 text-white rounded-full p-1 w-8 h-8 flex items-center justify-center z-10 shadow-lg backdrop-blur-sm transition-colors" onclick="toggleScanner()">
                                <i class="fas fa-times"></i>
                             </button>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Kategori</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-tag"></i></span>
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
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">Rp</span>
                                <input type="number" name="harga_beli" class="glass-input w-full pl-10" value="{{ old('harga_beli', $product->harga_beli) }}" required>
                            </div>
                        </div>

                        <!-- Harga Jual -->
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Harga Jual</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">Rp</span>
                                <input type="number" name="harga_jual" class="glass-input w-full pl-10" value="{{ old('harga_jual', $product->harga_jual) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Stok -->
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Stok</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-cubes"></i></span>
                                <input type="number" name="stok" class="glass-input w-full pl-10" value="{{ old('stok', $product->stok) }}" required>
                            </div>
                        </div>

                        <!-- Satuan -->
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Satuan</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-ruler"></i></span>
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
    
    @push('scripts')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const img = preview.querySelector('img');
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        function toggleScanner() {
            const container = document.getElementById('product-scanner-wrapper');
            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                // Check if startScanner is available (from x-scanner component)
                if (typeof startScanner === 'function') {
                    startScanner();
                }
            } else {
                container.classList.add('hidden');
                // Check if stopScanner is available
                if (typeof stopScanner === 'function') {
                    stopScanner();
                }
            }
        }

        document.addEventListener('code-scanned', function(e) {
            const code = e.detail;
            document.getElementById('kode_barcode').value = code;
            
            // Visual feedback
            const input = document.getElementById('kode_barcode');
            input.classList.add('bg-emerald-500/20', 'text-emerald-300');
            setTimeout(() => {
                input.classList.remove('bg-emerald-500/20', 'text-emerald-300');
            }, 1000);
        });
    </script>
    @endpush
@endsection
