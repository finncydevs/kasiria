@extends('layouts.admin')

@section('title', $product->name . ' - Produk')
@section('page_title', $product->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
    <li class="breadcrumb-item active">{{ $product->name }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Detail Produk</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3>{{ $product->name }}</h3>
                    <p class="text-muted">SKU: {{ $product->sku }} | Kategori: {{ $product->category }}</p>
                    <p>{{ $product->description }}</p>

                    <ul class="list-unstyled">
                        <li><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</li>
                        <li><strong>Harga Pokok:</strong> Rp {{ number_format($product->cost, 0, ',', '.') }}</li>
                        <li><strong>Stok:</strong> {{ $product->stock }}</li>
                        <li><strong>Stok Minimum:</strong> {{ $product->min_stock }}</li>
                        <li><strong>Status:</strong> @if($product->status) <span class="badge bg-success">Aktif</span> @else <span class="badge bg-secondary">Nonaktif</span> @endif</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary w-100 mb-2"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger w-100" onclick="return confirm('Hapus produk ini?')"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
