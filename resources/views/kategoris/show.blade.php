@extends('layouts.app')

@section('title', 'Detail Kategori - Kasiria')
@section('page_title', 'Detail Kategori')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('kategoris.index') }}" class="hover:text-blue-400 transition-colors">Kategori</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        {{ $kategori->nama_kategori }}
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Info Card -->
        <div class="glass-panel h-fit">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-tag text-blue-400"></i> Informasi
                </h2>
                <div class="flex gap-2">
                    <a href="{{ route('kategoris.edit', $kategori) }}" class="p-2 rounded-lg bg-yellow-500/10 text-yellow-400 hover:bg-yellow-500/20 transition-colors" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf @method('DELETE')
                        <button class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-colors" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Nama Kategori</span>
                    <p class="text-white text-lg font-medium">{{ $kategori->nama_kategori }}</p>
                </div>
                
                <div>
                    <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Deskripsi</span>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        {{ $kategori->deskripsi ?: '-' }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-white/5 p-3 rounded-lg text-center">
                        <span class="block text-2xl font-bold text-blue-400">{{ $kategori->getProductCountAttribute() }}</span>
                        <span class="text-xs text-slate-400">Produk</span>
                    </div>
                    <div class="bg-white/5 p-3 rounded-lg text-center">
                         <span class="block text-2xl font-bold text-emerald-400">{{ $kategori->products()->sum('stok') }}</span>
                         <span class="text-xs text-slate-400">Total Stok</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products List -->
        <div class="lg:col-span-2 glass-panel">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                <i class="fas fa-box text-purple-400"></i> Produk Terkait
            </h2>

            <div class="overflow-x-auto rounded-xl border border-white/10">
                <table class="w-full text-left">
                    <thead class="bg-white/5 text-xs text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="p-4">SKU</th>
                            <th class="p-4">Nama Produk</th>
                            <th class="p-4">Harga</th>
                            <th class="p-4 text-center">Stok</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($products as $product)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="p-4 text-slate-400 text-sm">{{ $product->kode_barcode ?? $product->sku }}</td>
                                <td class="p-4 font-medium text-white group-hover:text-blue-400 transition-colors">
                                    {{ $product->nama_produk ?? $product->name }}
                                </td>
                                <td class="p-4 text-slate-300">
                                    Rp {{ number_format($product->harga_jual ?? $product->price ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-center">
                                    @php 
                                        $stok = $product->stok ?? $product->stock ?? 0;
                                        $min = $product->min_stock ?? 0;
                                        $color = $stok <= $min ? 'text-red-400 bg-red-500/10 border-red-500/20' : 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20';
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs font-medium border {{ $color }}">
                                        {{ $stok }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <a href="{{ route('products.show', $product) }}" class="text-slate-400 hover:text-white transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-500">
                                    <p>Belum ada produk dalam kategori ini.</p>
                                    <a href="{{ route('products.create') }}" class="text-blue-400 text-sm hover:underline mt-2 inline-block">Tambah Produk</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
