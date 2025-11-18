@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Kasiria')
@section('page_title', 'Laporan Penjualan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Penjualan</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end mb-3">
                <div class="col-md-3">
                    <label class="form-label">Dari</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sampai</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kasir</label>
                    <select name="cashier_id" class="form-select">
                        <option value="">Semua</option>
                        @foreach(\App\Models\User::where('role','kasir')->get() as $c)
                            <option value="{{ $c->id }}" {{ request('cashier_id') == $c->id ? 'selected' : '' }}>{{ $c->nama ?? $c->username }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary">Filter</button>
                        <a href="{{ route('reports.export', array_merge(request()->all(), ['type' => 'sales'])) }}" class="btn btn-outline-success">Export CSV</a>
                    </div>
                </div>
            </form>

            <div class="mb-3">
                <strong>Total (halaman):</strong> Rp {{ number_format($transactions->sum('total'),0,',','.') }}
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>No. Transaksi</th>
                            <th>Kasir</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tx)
                            <tr>
                                <td>{{ $tx->id }}</td>
                                <td><a href="{{ route('transactions.show', $tx) }}">{{ $tx->transaction_number }}</a></td>
                                <td>{{ $tx->cashier->nama ?? $tx->cashier->username ?? '-' }}</td>
                                <td>{{ $tx->customer_name ?? '-' }}</td>
                                <td>Rp {{ number_format($tx->total,0,',','.') }}</td>
                                <td>{{ ucfirst($tx->payment_method) }}</td>
                                <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('transactions.receipt', $tx) }}" class="btn btn-sm btn-info" target="_blank"><i class="fas fa-print"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $transactions->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
@endsection
