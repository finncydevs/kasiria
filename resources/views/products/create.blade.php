@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
            <li class="breadcrumb-item active">Tambah Produk</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-4">
        <h1 class="h3 text-dark fw-bold">
            <i class="fas fa-plus text-primary me-2"></i>Tambah Produk Baru
        </h1>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Kesalahan!</strong>
                            <ul class="mb-0 ms-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf

                        <!-- Nama Produk -->
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label fw-bold">
                                <i class="fas fa-cube text-primary me-2"></i>Nama Produk
                            </label>
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                                id="nama_produk" name="nama_produk" placeholder="Masukkan nama produk"
                                value="{{ old('nama_produk') }}" required>
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kode Barcode -->
                        <div class="mb-3">
                            <label for="kode_barcode" class="form-label fw-bold">
                                <i class="fas fa-barcode text-info me-2"></i>Kode Barcode
                            </label>
                            <input type="text" class="form-control @error('kode_barcode') is-invalid @enderror"
                                id="kode_barcode" name="kode_barcode" placeholder="Masukkan kode barcode"
                                value="{{ old('kode_barcode') }}" required>
                            @error('kode_barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label fw-bold">
                                <i class="fas fa-tag text-success me-2"></i>Kategori
                            </label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror"
                                id="kategori_id" name="kategori_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->kategori_id }}"
                                        @if(old('kategori_id') == $kategori->kategori_id) selected @endif>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Harga Beli -->
                            <div class="col-md-6 mb-3">
                                <label for="harga_beli" class="form-label fw-bold">
                                    <i class="fas fa-money-bill text-warning me-2"></i>Harga Beli
                                </label>
                                <input type="number" step="0.01" class="form-control @error('harga_beli') is-invalid @enderror"
                                    id="harga_beli" name="harga_beli" placeholder="0"
                                    value="{{ old('harga_beli') }}" required>
                                @error('harga_beli')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Harga Jual -->
                            <div class="col-md-6 mb-3">
                                <label for="harga_jual" class="form-label fw-bold">
                                    <i class="fas fa-tag text-danger me-2"></i>Harga Jual
                                </label>
                                <input type="number" step="0.01" class="form-control @error('harga_jual') is-invalid @enderror"
                                    id="harga_jual" name="harga_jual" placeholder="0"
                                    value="{{ old('harga_jual') }}" required>
                                @error('harga_jual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Stok -->
                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label fw-bold">
                                    <i class="fas fa-boxes text-secondary me-2"></i>Stok
                                </label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                    id="stok" name="stok" placeholder="0"
                                    value="{{ old('stok', 0) }}" required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Satuan -->
                            <div class="col-md-6 mb-3">
                                <label for="satuan" class="form-label fw-bold">
                                    <i class="fas fa-ruler me-2"></i>Satuan
                                </label>
                                <input type="text" class="form-control @error('satuan') is-invalid @enderror"
                                    id="satuan" name="satuan" placeholder="pcs, box, dll"
                                    value="{{ old('satuan') }}">
                                @error('satuan')
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
                                placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status"
                                    value="1" @if(old('status', true)) checked @endif>
                                <label class="form-check-label fw-bold" for="status">
                                    <i class="fas fa-check-circle text-success me-2"></i>Aktif
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="col-lg-4">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-info-circle text-info me-2"></i>Informasi
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>Kode Barcode:</strong><br>
                            <small class="text-muted">Kode unik untuk setiap produk</small>
                        </li>
                        <li class="mb-2">
                            <strong>Harga:</strong><br>
                            <small class="text-muted">Harga Beli = Cost, Harga Jual = Selling Price</small>
                        </li>
                        <li class="mb-2">
                            <strong>Satuan:</strong><br>
                            <small class="text-muted">Contoh: pcs, box, kg, ltr</small>
                        </li>
                        <li>
                            <strong>Kategori:</strong><br>
                            <small class="text-muted">Pilih dari daftar kategori yang tersedia</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
