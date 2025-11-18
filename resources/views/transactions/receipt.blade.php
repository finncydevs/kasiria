@extends('layouts.admin')

@section('title', 'Struk - ' . ($transaction->transaction_number ?? ''))

@section('content')
    <div class="card p-3" id="receipt">
        <div class="text-center mb-3">
            <h4>Kasiria</h4>
            <small>Struk Transaksi</small>
        </div>

        <p>No: <strong>{{ $transaction->transaction_number }}</strong></p>
        <p>Tanggal: {{ $transaction->created_at->format('Y-m-d H:i') }}</p>
        <p>Kasir: {{ $transaction->cashier->nama ?? $transaction->cashier->username ?? '—' }}</p>

        <hr>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="text-end">Jumlah</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? '—' }}</td>
                        <td class="text-end">{{ $item->quantity }}</td>
                        <td class="text-end">Rp {{ number_format($item->total,0,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>
        <div class="text-end">
            <p>Subtotal: Rp {{ number_format($transaction->subtotal,0,',','.') }}</p>
            <p>Diskon: Rp {{ number_format($transaction->discount ?? 0,0,',','.') }}</p>
            <p>Pajak: Rp {{ number_format($transaction->tax ?? 0,0,',','.') }}</p>
            <h5>Total: Rp {{ number_format($transaction->total,0,',','.') }}</h5>
            <p>Dibayar: Rp {{ number_format($transaction->amount_paid,0,',','.') }}</p>
            <p>Kembali: Rp {{ number_format($transaction->change,0,',','.') }}</p>
        </div>

        <div class="text-center mt-3">
            <button class="btn btn-sm btn-primary" onclick="window.print()">Cetak</button>
            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-secondary">Tutup</a>
        </div>
    </div>
@endsection
