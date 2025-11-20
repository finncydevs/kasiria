@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kategoris.index') }}">Data Kategori</a></li>
            <li class="breadcrumb-item active">Tambah Kategori</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-4">
        <h1 class="h3 text-dark fw-bold">
            <i class="fas fa-plus text-primary me-2"></i>Tambah Kategori Baru
        </h1>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('kategoris.store') }}" method="POST">
                        @csrf

                        <!-- Nama Kategori -->
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label fw-bold">
                                <i class="fas fa-tag text-primary me-2"></i>Nama Kategori
                            </label>
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                id="nama_kategori" name="nama_kategori" placeholder="Masukkan nama kategori"
                                value="{{ old('nama_kategori') }}" required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold">
                                <i class="fas fa-align-left text-info me-2"></i>Deskripsi
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                id="deskripsi" name="deskripsi" rows="4"
                                placeholder="Masukkan deskripsi kategori...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">
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
                            <strong>Nama Kategori:</strong><br>
                            <small class="text-muted">Nama unik untuk setiap kategori produk</small>
                        </li>
                        <li>
                            <strong>Deskripsi:</strong><br>
                            <small class="text-muted">Penjelasan singkat tentang kategori (opsional)</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
