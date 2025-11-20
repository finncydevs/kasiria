@extends('layouts.admin')

@section('title', 'Cetak Struk #' . ($transaction->transaction_number ?? ''))

@push('styles')
<style>
    /* Tampilan di Layar */
    .receipt-container {
        width: 100%;
        max-width: 58mm; /* Standar lebar kertas thermal 58mm atau 80mm */
        margin: 20px auto;
        background: #fff;
        padding: 15px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        font-family: 'Courier New', Courier, monospace; /* Font kasir */
        font-size: 12px;
        color: #000;
    }

    .receipt-header {
        text-align: center;
        margin-bottom: 10px;
    }

    .receipt-title {
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .dashed-line {
        border-bottom: 1px dashed #000;
        margin: 5px 0;
        display: block;
        width: 100%;
    }

    .receipt-item {
        margin-bottom: 5px;
    }

    .item-name {
        display: block;
        font-weight: bold;
    }

    .item-details {
        display: flex;
        justify-content: space-between;
    }

    .receipt-footer {
        display: flex;
        justify-content: space-between;
        margin-bottom: 3px;
    }

    .total-row {
        font-weight: bold;
        font-size: 14px;
        border-top: 1px dashed #000;
        border-bottom: 1px dashed #000;
        padding: 5px 0;
        margin: 5px 0;
    }

    .text-center { text-align: center; }
    .text-end { text-align: right; }
    .fw-bold { font-weight: bold; }

    /* Tombol tidak ikut tercetak */
    .no-print {
        margin-top: 20px;
        text-align: center;
    }

    /* PENTING: Pengaturan saat PRINT dialog muncul */
    @media print {
        body * {
            visibility: hidden;
        }
        #receipt-area, #receipt-area * {
            visibility: visible;
        }
        #receipt-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
            box-shadow: none;
        }
        .no-print {
            display: none;
        }
        /* Hilangkan elemen layout admin jika ada */
        nav, header, footer, .sidebar {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')
    <div class="receipt-container" id="receipt-area">

        {{-- HEADER STRUK --}}
        <div class="receipt-header">
            <div class="receipt-title">KASIRIA STORE</div>
            <div>Jl. Contoh No. 123, Bandung</div>
            <div>Telp: 0812-3456-7890</div>
        </div>

        <div class="dashed-line"></div>

        <div>
            <div>No: {{ $transaction->transaction_number }}</div>
            <div>Tgl: {{ $transaction->created_at->format('d/m/Y H:i') }}</div>
            <div>Kasir: {{ $transaction->cashier->nama ?? 'Admin' }}</div>
            @if($transaction->pelanggan)
            <div>Plg: {{ $transaction->pelanggan->nama }}</div>
            @endif
        </div>

        <div class="dashed-line"></div>

        {{-- ITEMS --}}
        <div class="items-list">
            @foreach($transaction->items as $item)
                <div class="receipt-item">
                    {{-- Nama produk satu baris sendiri --}}
                    <div class="item-name">{{ $item->product->nama_produk ?? 'Item Terhapus' }}</div>
                    <div class="item-details">
                        {{-- Format: 2 x 10.000 --}}
                        <span>{{ $item->quantity }} x {{ number_format($item->unit_price, 0, ',', '.') }}</span>
                        <span>{{ number_format($item->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="dashed-line"></div>

        {{-- TOTALS --}}
        <div class="receipt-footer">
            <span>Subtotal</span>
            <span>{{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
        </div>

        @if(($transaction->discount ?? 0) > 0)
        <div class="receipt-footer">
            <span>Diskon</span>
            <span>-{{ number_format($transaction->discount, 0, ',', '.') }}</span>
        </div>
        @endif

        @if(($transaction->tax ?? 0) > 0)
        <div class="receipt-footer">
            <span>Pajak</span>
            <span>{{ number_format($transaction->tax, 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="receipt-footer total-row">
            <span>TOTAL</span>
            <span>{{ number_format($transaction->total, 0, ',', '.') }}</span>
        </div>

        <div class="receipt-footer">
            <span>Tunai/Bayar</span>
            <span>{{ number_format($transaction->amount_paid, 0, ',', '.') }}</span>
        </div>

        <div class="receipt-footer">
            <span>Kembali</span>
            <span>{{ number_format($transaction->change, 0, ',', '.') }}</span>
        </div>

        <div class="dashed-line"></div>

        <div class="text-center" style="margin-top: 10px;">
            <div>Terima Kasih</div>
            <div>Barang yang sudah dibeli</div>
            <div>tidak dapat ditukar kembali</div>
        </div>

        {{-- TOMBOL AKSI (Hanya tampil di layar) --}}
        <div class="no-print">
            <button class="btn btn-primary btn-sm" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak Struk
            </button>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection
