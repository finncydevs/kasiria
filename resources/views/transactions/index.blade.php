@extends('layouts.admin')

@section('title', 'Transaksi - Kasiria')
@section('page_title', 'Transaksi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Transaksi</li>
@endsection

@section('content')
    <div class="page-header d-flex align-items-center justify-content-between">
        <h1>Transaksi</h1>
        <div>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Transaksi Baru</a>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. Transaksi</th>
                            <th>Kasir</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tx)
                            <tr>
                                <td><a href="{{ route('transactions.show', $tx) }}">{{ $tx->transaction_number }}</a></td>
                                <td>{{ $tx->cashier->nama ?? $tx->cashier->username ?? '—' }}</td>
                                <td>{{ $tx->customer_name ?? '-' }}</td>
                                <td>Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($tx->payment_method) }}</td>
                                <td>
                                    @if($tx->status === 'completed')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($tx->status === 'refunded')
                                        <span class="badge bg-warning">Dikembalikan</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($tx->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('transactions.show', $tx) }}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('transactions.receipt', $tx) }}" class="btn btn-sm btn-info" target="_blank"><i class="fas fa-print"></i></a>
                                    @if($tx->status !== 'refunded')
                                        <form action="{{ route('transactions.refund', $tx) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Proses pengembalian untuk transaksi ini?')"><i class="fas fa-undo"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection
