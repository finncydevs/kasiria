@extends('layouts.admin')

@section('title', 'Detail Kategori')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kategoris.index') }}">Data Kategori</a></li>
            <li class="breadcrumb-item active">{{ $kategori->nama_kategori }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-dark fw-bold">
            <i class="fas fa-tag text-primary me-2"></i>{{ $kategori->nama_kategori }}
        </h1>
        <div class="btn-group" role="group">
            <a href="{{ route('kategoris.edit', $kategori) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                    <i class="fas fa-trash me-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Info Card -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-tag me-2"></i>Informasi Kategori
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">Nama:</div>
                        <div class="col-sm-8">{{ $kategori->nama_kategori }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">Deskripsi:</div>
                        <div class="col-sm-8">
                            @if ($kategori->deskripsi)
                                {{ $kategori->deskripsi }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">Dibuat:</div>
                        <div class="col-sm-8">{{ $kategori->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 fw-bold text-muted">Diubah:</div>
                        <div class="col-sm-8">{{ $kategori->updated_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Statistik
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-center">
                                <h3 class="text-primary fw-bold">{{ $kategori->getProductCountAttribute() }}</h3>
                                <small class="text-muted">Total Produk</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-center">
                                <h3 class="text-success fw-bold">
                                    @php
                                        // produk table uses 'stok' column
                                        $totalStock = $kategori->products()->sum('stok');
                                    @endphp
                                    {{ $totalStock }}
                                </h3>
                                <small class="text-muted">Total Stok</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="fas fa-box me-2"></i>Produk dalam Kategori Ini
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>SKU</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="fw-bold">{{ $product->kode_barcode ?? $product->sku }}</td>
                            <td>{{ $product->nama_produk ?? $product->name }}</td>
                            <td>Rp {{ number_format($product->harga_jual ?? $product->price ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @php $stok = $product->stok ?? $product->stock ?? 0; @endphp
                                @php $min = $product->min_stock ?? 0; @endphp
                                @if ($stok <= $min)
                                    <span class="badge bg-warning">{{ $stok }}</span>
                                @else
                                    <span class="badge bg-success">{{ $stok }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($product->status)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('products.show', $product) }}"
                                        class="btn btn-outline-primary" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}"
                                        class="btn btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada produk dalam kategori ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($products->count())
            <div class="card-footer bg-light">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
