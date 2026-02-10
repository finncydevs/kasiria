@extends('layouts.app')

@section('title', 'Order Produk')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-white mb-1">Menu Kami</h1>
        <p class="text-slate-400 text-sm">Pilih makanan dan minuman favoritmu.</p>
    </div>
    <div class="text-slate-400 text-sm">
        Saldo Poin: <span class="text-white font-bold">{{ number_format(auth()->user()->points) }}</span>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 pb-24">
    @foreach($products as $product)
    <div class="glass-panel p-4 flex flex-col h-full group hover:bg-white/10 transition-colors">
        <div class="aspect-square rounded-xl bg-slate-800 mb-4 overflow-hidden relative">
            @if($product->gambar)
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-slate-600">
                    <i class="fas fa-image text-3xl"></i>
                </div>
            @endif
            
            <div class="absolute top-2 right-2">
                <span class="px-2 py-1 rounded bg-black/60 text-white text-xs backdrop-blur-sm">
                    Stok: {{ $product->stok }}
                </span>
            </div>
        </div>
        
        <h3 class="text-white font-medium mb-1 line-clamp-1">{{ $product->nama_produk }}</h3>
        <p class="text-blue-400 font-bold mb-4">Rp {{ number_format($product->harga_jual) }}</p>
        
        <div class="mt-auto">
            <div x-data="{ qty: 0 }" class="flex items-center justify-between bg-white/5 rounded-lg p-1 border border-white/10">
                <button type="button" 
                    @click="if(qty > 0) { qty--; removeFromCart({{ $product->id }}); }"
                    class="w-8 h-8 rounded bg-white/5 hover:bg-white/10 text-white flex items-center justify-center transition-colors disabled:opacity-50"
                    :disabled="qty <= 0">
                    <i class="fas fa-minus text-xs"></i>
                </button>
                
                <span class="text-white font-mono font-medium w-8 text-center" x-text="qty"></span>
                
                <button type="button" 
                    @click="if(qty < {{ $product->stok }}) { qty++; addToCart({{ $product->id }}, '{{ $product->nama_produk }}', {{ $product->harga_jual }}); }"
                    class="w-8 h-8 rounded bg-blue-600 hover:bg-blue-500 text-white flex items-center justify-center transition-colors shadow-lg shadow-blue-500/20 disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="qty >= {{ $product->stok }}">
                    <i class="fas fa-plus text-xs"></i>
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Floating Action Bar / Cart -->
<div x-data="cartDisplay" class="fixed bottom-0 left-0 md:left-64 right-0 p-4 bg-gray-900/90 backdrop-blur-xl border-t border-white/10 transition-transform duration-300 transform translate-y-full"
     :class="{ 'translate-y-0': totalQty > 0, 'translate-y-full': totalQty === 0 }">
    <div class="container mx-auto max-w-4xl flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-blue-500/30">
                <span x-text="totalQty"></span>
            </div>
            <div>
                <p class="text-slate-400 text-xs uppercase tracking-wider font-medium">Total Pesanan</p>
                <p class="text-white font-bold text-xl">Rp <span x-text="formatRupiah(totalPrice)"></span></p>
            </div>
        </div>
        
        <button type="button" @click="submitOrder" :disabled="loading" class="btn btn-primary px-8 py-3 rounded-xl flex items-center gap-2 disabled:opacity-70">
            <span x-show="!loading">Pesan Sekarang</span>
            <span x-show="loading"><i class="fas fa-spinner fa-spin"></i> Memproses...</span>
            <i x-show="!loading" class="fas fa-chevron-right text-sm"></i>
        </button>
    </div>
</div>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    const cart = {};

    function addToCart(id, name, price) {
        if (!cart[id]) {
            cart[id] = { id, name, price, qty: 0 };
        }
        cart[id].qty++;
        updateCartDisplay();
    }

    function removeFromCart(id) {
        if (cart[id]) {
            cart[id].qty--;
            if (cart[id].qty <= 0) {
                delete cart[id];
            }
        }
        updateCartDisplay();
    }

    function updateCartDisplay() {
        // Dispatch event for Alpine to pick up
        window.dispatchEvent(new CustomEvent('cart-updated', { 
            detail: { cart } 
        }));
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('cartDisplay', () => ({
            totalQty: 0,
            totalPrice: 0,
            loading: false,

            init() {
                window.addEventListener('cart-updated', (e) => {
                    const cart = e.detail.cart;
                    this.totalQty = Object.values(cart).reduce((acc, item) => acc + item.qty, 0);
                    this.totalPrice = Object.values(cart).reduce((acc, item) => acc + (item.price * item.qty), 0);
                });
            },

            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            },

            submitOrder() {
                if (this.totalQty === 0) return;
                
                this.loading = true;
                const items = Object.values(cart).map(item => ({ id: item.id, qty: item.qty }));

                fetch('{{ route("pelanggan.storeOrder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ items })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, "Berhasil", "success");
                        setTimeout(() => {
                             window.location.href = data.redirect;
                        }, 1500);
                    } else {
                        showAlert('Error: ' + data.message, "Gagal", "error");
                        this.loading = false;
                    }
                })
                .catch(error => {
                    showAlert('Terjadi kesalahan sistem.', "System Error", "error");
                    console.error(error);
                    this.loading = false;
                });
            }
        }));
    });
</script>
@endpush
@endsection
