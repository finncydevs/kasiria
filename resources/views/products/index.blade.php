@extends('layouts.app')

@section('title', 'Daftar Produk - Kasiria')
@section('page_title', 'Manajemen Produk')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Produk
    </li>
@endsection

@section('content')
    <div class="glass-panel">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-xl font-semibold text-white">Daftar Produk</h2>
                <p class="text-slate-400 text-sm mt-1">Kelola inventaris, harga, dan stok produk.</p>
            </div>
            
            <a href="{{ route('products.create') }}" class="glass-btn flex items-center gap-2">
                <i class="fas fa-plus"></i> <span>Tambah Produk</span>
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 glass-panel bg-white/5 !p-4">
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400"></i>
                    <input type="text" name="search" class="glass-input w-full pl-10" placeholder="Cari nama produk atau barcode..." value="{{ request('search') }}">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white px-6">
                        <i class="fas fa-search mr-2"></i> Cari
                    </button>
                    <a href="{{ route('products.index') }}" class="glass-btn bg-white/5 hover:bg-white/10 text-slate-300 px-4">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto rounded-xl border border-white/10">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-xs text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Gambar</th>
                        <th class="p-4">Barcode</th>
                        <th class="p-4">Nama Produk</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4 text-right">Harga Beli</th>
                        <th class="p-4 text-right">Harga Jual</th>
                        <th class="p-4 text-center">Stok</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($products as $product)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="p-4">
                                @if($product->gambar)
                                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-10 h-10 rounded-lg object-cover border border-white/10">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-slate-500 border border-white/10">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 text-slate-400 font-mono text-xs">
                                <span class="bg-white/5 px-2 py-1 rounded border border-white/10">{{ $product->kode_barcode }}</span>
                            </td>
                            <td class="p-4 font-medium text-white group-hover:text-blue-400 transition-colors">
                                <a href="{{ route('products.show', $product) }}">{{ $product->nama_produk }}</a>
                            </td>
                            <td class="p-4">
                                @if($product->kategori)
                                    <span class="px-2 py-1 rounded text-xs bg-purple-500/10 text-purple-400 border border-purple-500/20">
                                        {{ $product->kategori->nama_kategori }}
                                    </span>
                                @else
                                    <span class="text-slate-500 text-xs italic">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-right text-slate-400 text-sm">
                                Rp {{ number_format($product->harga_beli, 0, ',', '.') }}
                            </td>
                            <td class="p-4 text-right text-emerald-400 font-medium text-sm">
                                Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                            </td>
                            <td class="p-4 text-center">
                                @if($product->stok > 10)
                                    <span class="text-emerald-400 font-bold">{{ $product->stok }}</span>
                                @elseif($product->stok > 0)
                                    <span class="text-yellow-400 font-bold">{{ $product->stok }}</span>
                                @else
                                    <span class="text-red-400 font-bold">Habis</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if($product->status)
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block" title="Aktif"></span>
                                @else
                                    <span class="w-2 h-2 rounded-full bg-slate-500 inline-block" title="Nonaktif"></span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('products.edit', $product) }}" class="p-2 rounded-lg hover:bg-white/10 text-yellow-400 transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirmSubmit(event, 'Apakah Anda yakin ingin menghapus produk ini? pervubahan tidak dapat dikembalikan.', 'Hapus Produk', 'delete')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 rounded-lg hover:bg-red-500/10 text-red-400 transition-colors" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-box-open text-4xl mb-3 opacity-20"></i>
                                    <p>Belum ada produk ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
