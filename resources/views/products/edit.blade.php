@extends('layouts.admin')

@section('title', 'Edit Produk - Kasiria')
@section('page_title', 'Edit Produk')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white fw-bold">
            <i class="fas fa-edit me-2"></i>Edit Produk
        </div>
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5 class="alert-heading">
                        <i class="fas fa-exclamation-circle me-2"></i>Terdapat Kesalahan!
                    </h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Nama Produk -->
                    <div class="col-md-6 mb-3">
                        <label for="nama_produk" class="form-label fw-bold">
                            <i class="fas fa-box text-primary me-2"></i>Nama Produk
                        </label>
                        <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                            id="nama_produk" name="nama_produk"
                            value="{{ old('nama_produk', $product->nama_produk) }}"
                            placeholder="Masukkan nama produk" required>
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kode Barcode -->
                    <div class="col-md-6 mb-3">
                        <label for="kode_barcode" class="form-label fw-bold">
                            <i class="fas fa-barcode text-primary me-2"></i>Kode Barcode
                        </label>
                        <input type="text" class="form-control @error('kode_barcode') is-invalid @enderror"
                            id="kode_barcode" name="kode_barcode"
                            value="{{ old('kode_barcode', $product->kode_barcode) }}"
                            placeholder="Masukkan kode barcode" required>
                        @error('kode_barcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Kategori -->
                    <div class="col-md-4 mb-3">
                        <label for="kategori_id" class="form-label fw-bold">
                            <i class="fas fa-tag text-primary me-2"></i>Kategori
                        </label>
                        <select class="form-select @error('kategori_id') is-invalid @enderror"
                            id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->kategori_id }}"
                                    @if(old('kategori_id', $product->kategori_id) == $kategori->kategori_id) selected @endif>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Satuan -->
                    <div class="col-md-4 mb-3">
                        <label for="satuan" class="form-label fw-bold">
                            <i class="fas fa-balance-scale text-primary me-2"></i>Satuan
                        </label>
                        <input type="text" class="form-control @error('satuan') is-invalid @enderror"
                            id="satuan" name="satuan"
                            value="{{ old('satuan', $product->satuan) }}"
                            placeholder="Contoh: Pcs, Box" required>
                        @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div class="col-md-4 mb-3">
                        <label for="stok" class="form-label fw-bold">
                            <i class="fas fa-cubes text-primary me-2"></i>Stok
                        </label>
                        <input type="number" class="form-control @error('stok') is-invalid @enderror"
                            id="stok" name="stok"
                            value="{{ old('stok', $product->stok) }}"
                            placeholder="Masukkan jumlah stok" required>
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Harga Beli -->
                    <div class="col-md-6 mb-3">
                        <label for="harga_beli" class="form-label fw-bold">
                            <i class="fas fa-money-bill-wave text-success me-2"></i>Harga Beli
                        </label>
                        <input type="number" class="form-control @error('harga_beli') is-invalid @enderror"
                            id="harga_beli" name="harga_beli"
                            value="{{ old('harga_beli', $product->harga_beli) }}"
                            placeholder="Masukkan harga beli" step="0.01" required>
                        @error('harga_beli')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Harga Jual -->
                    <div class="col-md-6 mb-3">
                        <label for="harga_jual" class="form-label fw-bold">
                            <i class="fas fa-money-bill-wave text-danger me-2"></i>Harga Jual
                        </label>
                        <input type="number" class="form-control @error('harga_jual') is-invalid @enderror"
                            id="harga_jual" name="harga_jual"
                            value="{{ old('harga_jual', $product->harga_jual) }}"
                            placeholder="Masukkan harga jual" step="0.01" required>
                        @error('harga_jual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label fw-bold">
                        <i class="fas fa-align-left text-info me-2"></i>Deskripsi
                    </label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                        id="deskripsi" name="deskripsi" rows="3"
                        placeholder="Masukkan deskripsi produk">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" name="status"
                            value="1" @if(old('status', $product->status)) checked @endif>
                        <label class="form-check-label fw-bold" for="status">
                            <i class="fas fa-check-circle text-success me-2"></i>Aktif
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
