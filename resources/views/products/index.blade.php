@extends('layouts.admin')

@section('title', 'Produk - Kasiria')
@section('page_title', 'Produk')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title m-0">
                <i class="fas fa-box me-2"></i>Daftar Produk
            </h1>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Produk
            </a>
        </div>
    </div>

    <!-- Search Filter -->
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari nama produk atau kode barcode..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fas fa-search me-2"></i>Cari
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo me-2"></i>Reset
                </a>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white fw-bold">
            <i class="fas fa-table me-2"></i>Data Produk
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><i class="fas fa-barcode me-2"></i>Kode Barcode</th>
                            <th><i class="fas fa-box me-2"></i>Nama Produk</th>
                            <th><i class="fas fa-tag me-2"></i>Kategori</th>
                            <th class="text-end"><i class="fas fa-money-bill me-2"></i>Harga Beli</th>
                            <th class="text-end"><i class="fas fa-money-bill-wave me-2"></i>Harga Jual</th>
                            <th class="text-center"><i class="fas fa-cubes me-2"></i>Stok</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $product->kode_barcode }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none fw-semibold">
                                        {{ $product->nama_produk }}
                                    </a>
                                </td>
                                <td>
                                    @if($product->kategori)
                                        <span class="badge bg-info">{{ $product->kategori->nama_kategori }}</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    Rp {{ number_format($product->harga_beli, 0, ',', '.') }}
                                </td>
                                <td class="text-end fw-semibold text-danger">
                                    Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if($product->stok > 0)
                                        <span class="badge bg-success">{{ $product->stok }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $product->stok }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($product->status)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-times-circle me-1"></i>Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                                onclick="if(confirm('Hapus produk ini?')) this.parentForm.submit();">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-inbox text-muted me-2"></i>Belum ada produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <nav aria-label="Page navigation" class="mt-4">
                    {{ $products->links('pagination::bootstrap-5') }}
                </nav>
            @endif
        </div>
    </div>
@endsection
