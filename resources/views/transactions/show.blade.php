@extends('layouts.admin')

@section('title', 'Detail Transaksi - ' . ($transaction->transaction_number ?? ''))
@section('page_title', 'Transaksi ' . ($transaction->transaction_number ?? ''))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transaksi</a></li>
    <li class="breadcrumb-item active">{{ $transaction->transaction_number }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Detail Transaksi</span>
            <div>
                <a href="{{ route('transactions.receipt', $transaction) }}" class="btn btn-sm btn-info" target="_blank"><i class="fas fa-print"></i> Struk</a>
                @if($transaction->status !== 'refunded')
                    <form action="{{ route('transactions.refund', $transaction) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Proses pengembalian untuk transaksi ini?')"><i class="fas fa-undo"></i> Refund</button>
                    </form>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5>Informasi</h5>
                    <p><strong>No.:</strong> {{ $transaction->transaction_number }}</p>
                    <p><strong>Kasir:</strong> {{ $transaction->cashier->nama ?? $transaction->cashier->username ?? '—' }}</p>
                    <p><strong>Customer:</strong> {{ $transaction->customer_name ?? '-' }}</p>
                    <p><strong>Metode:</strong> {{ ucfirst($transaction->payment_method) }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Ringkasan</h5>
                    <ul class="list-unstyled">
                        <li><strong>Subtotal:</strong> Rp {{ number_format($transaction->subtotal,0,',','.') }}</li>
                        <li><strong>Diskon:</strong> Rp {{ number_format($transaction->discount ?? 0,0,',','.') }}</li>
                        <li><strong>Pajak:</strong> Rp {{ number_format($transaction->tax ?? 0,0,',','.') }}</li>
                        <li><strong>Total:</strong> Rp {{ number_format($transaction->total,0,',','.') }}</li>
                        <li><strong>Dibayar:</strong> Rp {{ number_format($transaction->amount_paid,0,',','.') }}</li>
                        <li><strong>Kembalian:</strong> Rp {{ number_format($transaction->change,0,',','.') }}</li>
                        <li><strong>Status:</strong> <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : ($transaction->status === 'refunded' ? 'warning' : 'secondary') }}">{{ ucfirst($transaction->status) }}</span></li>
                    </ul>
                </div>
            </div>

            <h5>Items</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Diskon</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->items as $item)
                            <tr>
                                <td>{{ $item->product->name ?? '—' }}</td>
                                <td>Rp {{ number_format($item->unit_price,0,',','.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->discount ?? 0,0,',','.') }}</td>
                                <td>Rp {{ number_format($item->total,0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
