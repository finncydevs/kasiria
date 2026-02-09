@extends('layouts.app')

@section('title', $product->nama_produk . ' - Produk')
@section('page_title', $product->nama_produk)

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
        Detail
    </li>
@endsection

@section('content')
    <div class="glass-panel">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 border-b border-white/10 pb-4">
            <div>
                <h2 class="text-xl font-semibold text-white">Detail Produk</h2>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('products.edit', $product) }}" class="glass-btn text-sm px-4 py-2 flex items-center gap-2 text-yellow-400 border-yellow-500/30 hover:bg-yellow-500/10">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('products.index') }}" class="glass-btn text-sm px-4 py-2">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Sidebar / Image placeholder -->
            <div class="md:col-span-1">
                <div class="bg-white/5 rounded-2xl p-6 text-center border border-white/10 h-full flex flex-col items-center justify-center min-h-[250px]">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-3xl shadow-xl shadow-blue-500/20 mb-4">
                        <i class="fas fa-box-open text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">{{ $product->nama_produk }}</h3>
                    <p class="px-3 py-1 rounded bg-white/10 text-xs text-slate-300 font-mono inline-block mb-4">
                        {{ $product->kode_barcode }}
                    </p>
                    
                    <div class="flex flex-wrap justify-center gap-2">
                        @if($product->kategori)
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-500/10 text-purple-400 border border-purple-500/20">
                            {{ $product->kategori->nama_kategori }}
                        </span>
                        @endif
                        
                        @if($product->status)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20">
                                Nonaktif
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Details -->
            <div class="md:col-span-2">
                <div class="bg-white/5 rounded-2xl p-6 border border-white/10 h-full">
                    <h4 class="text-lg font-medium text-white mb-4 border-b border-white/5 pb-2">Informasi Detail</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Harga Beli</span>
                                <span class="text-slate-200 font-medium text-lg">Rp {{ number_format($product->harga_beli, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Harga Jual</span>
                                <span class="text-emerald-400 font-bold text-xl">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Margin</span>
                                @php $margin = $product->harga_jual - $product->harga_beli; @endphp
                                <span class="{{ $margin >= 0 ? 'text-blue-400' : 'text-red-400' }} font-medium">
                                    Rp {{ number_format($margin, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Stok Saat Ini</span>
                                <span class="text-white font-bold text-2xl">{{ $product->stok }} <span class="text-sm font-normal text-slate-400">{{ $product->satuan }}</span></span>
                            </div>
                            <div>
                                <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Deskripsi</span>
                                <p class="text-slate-300 text-sm leading-relaxed">
                                    {{ $product->deskripsi ?? 'Tidak ada deskripsi.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 pt-4 border-t border-white/5 flex justify-end">
                         <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 text-sm flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-red-500/10 transition-colors">
                                <i class="fas fa-trash"></i> Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
