@extends('layouts.admin')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pelanggans.index') }}">Data Pelanggan</a></li>
            <li class="breadcrumb-item active">{{ $pelanggan->nama }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-dark fw-bold">
            <i class="fas fa-user text-primary me-2"></i>{{ $pelanggan->nama }}
        </h1>
        <div class="btn-group" role="group">
            <a href="{{ route('pelanggans.edit', $pelanggan) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <form action="{{ route('pelanggans.destroy', $pelanggan) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                    <i class="fas fa-trash me-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Info Cards Row -->
    <div class="row mb-4">
        <!-- Personal Info Card -->
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>Informasi Pribadi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">Nama:</div>
                        <div class="col-sm-8">{{ $pelanggan->nama }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">Email:</div>
                        <div class="col-sm-8">
                            @if ($pelanggan->email)
                                <a href="mailto:{{ $pelanggan->email }}">{{ $pelanggan->email }}</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">No HP:</div>
                        <div class="col-sm-8">
                            @if ($pelanggan->no_hp)
                                <a href="https://wa.me/{{ str_replace(['0', '+', ' ', '-'], '', $pelanggan->no_hp) }}" target="_blank">
                                    <i class="fab fa-whatsapp text-success me-1"></i>{{ $pelanggan->no_hp }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">Alamat:</div>
                        <div class="col-sm-8">
                            @if ($pelanggan->alamat)
                                {{ $pelanggan->alamat }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 fw-bold text-muted">Status:</div>
                        <div class="col-sm-8">
                            @if ($pelanggan->status)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Member & Points Card -->
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-crown me-2"></i>Member & Poin
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">Member Level:</div>
                        <div class="col-sm-8">
                            @if ($pelanggan->member_level)
                                <span class="badge bg-info">{{ $pelanggan->member_level }}</span>
                            @else
                                <span class="text-muted">Belum ditentukan</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">Total Poin:</div>
                        <div class="col-sm-8">
                            <span class="badge bg-warning text-dark fs-6">{{ $pelanggan->poin }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">Total Transaksi:</div>
                        <div class="col-sm-8">
                            <span class="badge bg-primary">{{ $pelanggan->getTotalTransactionsAttribute() }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-muted">Total Belanja:</div>
                        <div class="col-sm-8">
                            <strong>Rp {{ number_format($pelanggan->getTotalSpendingAttribute(), 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 fw-bold text-muted">Bergabung:</div>
                        <div class="col-sm-8">
                            {{ $pelanggan->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="fas fa-receipt me-2"></i>Riwayat Transaksi
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No Transaksi</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td class="fw-bold">{{ $transaction->transaction_number }}</td>
                            <td>{{ $transaction->cashier->nama ?? '-' }}</td>
                            <td>
                                <strong>Rp {{ number_format($transaction->total, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $transaction->payment_method }}</span>
                            </td>
                            <td>
                                @if ($transaction->status === 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif ($transaction->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">Refund</span>
                                @endif
                            </td>
                            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('transactions.show', $transaction) }}"
                                        class="btn btn-outline-primary" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('transactions.receipt', $transaction) }}"
                                        class="btn btn-outline-info" title="Cetak">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($transactions->count())
            <div class="card-footer bg-light">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
