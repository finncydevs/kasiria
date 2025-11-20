@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold">Daftar Transaksi</span>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Transaksi Baru
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                <tr>
                    <td>#{{ $t->transaction_number ?? $t->id }}</td>
                    <td>{{ optional($t->created_at)->format('d M Y H:i') }}</td>
                    <td>{{ $t->pelanggan->nama ?? $t->customer_name ?? 'Umum' }}</td>
                    <td class="text-end">Rp {{ number_format($t->total ?? 0, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($t->payment_method ?? ($t->metode_bayar ?? '')) }}</td>
                    <td>
                        <span class="badge bg-{{ $t->status === 'completed' ? 'success' : ($t->status === 'refunded' ? 'warning' : 'secondary') }}">{{ $t->status }}</span>
                    </td>
                    <td>
                        <a href="{{ route('transactions.show', $t) }}" class="btn btn-info btn-sm text-white">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $transactions->links() }}
    </div>
</div>
@endsection
