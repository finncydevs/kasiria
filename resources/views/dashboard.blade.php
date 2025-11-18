@extends('layouts.admin')

@section('title', 'Dashboard - Kasiria')
@section('page_title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">
        <i class="fas fa-home"></i> Dashboard
    </li>
@endsection

@section('content')
    <div class="page-header">
        <h1>Selamat Datang di Kasiria!</h1>
        <div class="page-header-buttons">
            <button class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Transaksi
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Penjualan</h6>
                            <h3 class="mb-0" style="color: #1e40af;">Rp 5.2M</h3>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> +12% bulan ini</small>
                        </div>
                        <div style="font-size: 2.5rem; color: #3b82f6; opacity: 0.2;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Jumlah Transaksi</h6>
                            <h3 class="mb-0" style="color: #1e40af;">245</h3>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> +8% dari minggu lalu</small>
                        </div>
                        <div style="font-size: 2.5rem; color: #3b82f6; opacity: 0.2;">
                            <i class="fas fa-receipt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Pengguna</h6>
                            <h3 class="mb-0" style="color: #1e40af;">42</h3>
                            <small class="text-info"><i class="fas fa-user-plus"></i> +5 pengguna baru</small>
                        </div>
                        <div style="font-size: 2.5rem; color: #3b82f6; opacity: 0.2;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Produk Aktif</h6>
                            <h3 class="mb-0" style="color: #1e40af;">156</h3>
                            <small class="text-warning"><i class="fas fa-exclamation-circle"></i> 8 stok habis</small>
                        </div>
                        <div style="font-size: 2.5rem; color: #3b82f6; opacity: 0.2;">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-line"></i> Penjualan Bulan Ini
                </div>
                <div class="card-body" style="height: 300px; display: flex; align-items: center; justify-content: center;">
                    <p class="text-muted">
                        <i class="fas fa-chart-bar" style="font-size: 3rem; margin-bottom: 1rem;"></i><br>
                        Chart akan ditampilkan di sini (Gunakan Chart.js atau ApexCharts)
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-users"></i> Top Kasir
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item" style="border: none; padding: 0.75rem 0;">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-star" style="color: #fbbf24;"></i> Ahmad Wijaya</span>
                                <span style="color: #3b82f6; font-weight: 600;">Rp 1.2M</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar" style="width: 90%; background-color: #3b82f6;"></div>
                            </div>
                        </div>
                        <div class="list-group-item" style="border: none; padding: 0.75rem 0;">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-star" style="color: #fbbf24;"></i> Siti Nurhaliza</span>
                                <span style="color: #3b82f6; font-weight: 600;">Rp 980K</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar" style="width: 75%; background-color: #3b82f6;"></div>
                            </div>
                        </div>
                        <div class="list-group-item" style="border: none; padding: 0.75rem 0;">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-star" style="color: #fbbf24;"></i> Budi Santoso</span>
                                <span style="color: #3b82f6; font-weight: 600;">Rp 750K</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar" style="width: 60%; background-color: #3b82f6;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-history"></i> Transaksi Terbaru
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr style="background-color: #f8fafc;">
                                    <th>ID Transaksi</th>
                                    <th>Pelanggan</th>
                                    <th>Kasir</th>
                                    <th>Jumlah Item</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>#TRX001</strong></td>
                                    <td>Andi Pratama</td>
                                    <td>Ahmad Wijaya</td>
                                    <td>5</td>
                                    <td>Rp 250.000</td>
                                    <td><span class="badge" style="background-color: #10b981; color: white;">Selesai</span></td>
                                    <td>10:30 AM</td>
                                </tr>
                                <tr>
                                    <td><strong>#TRX002</strong></td>
                                    <td>Rini Kusuma</td>
                                    <td>Siti Nurhaliza</td>
                                    <td>3</td>
                                    <td>Rp 180.000</td>
                                    <td><span class="badge" style="background-color: #10b981; color: white;">Selesai</span></td>
                                    <td>10:45 AM</td>
                                </tr>
                                <tr>
                                    <td><strong>#TRX003</strong></td>
                                    <td>Doni Setiawan</td>
                                    <td>Budi Santoso</td>
                                    <td>7</td>
                                    <td>Rp 420.000</td>
                                    <td><span class="badge" style="background-color: #fbbf24; color: white;">Pending</span></td>
                                    <td>11:00 AM</td>
                                </tr>
                                <tr>
                                    <td><strong>#TRX004</strong></td>
                                    <td>Elsa Gunawan</td>
                                    <td>Ahmad Wijaya</td>
                                    <td>2</td>
                                    <td>Rp 95.000</td>
                                    <td><span class="badge" style="background-color: #10b981; color: white;">Selesai</span></td>
                                    <td>11:15 AM</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <a href="#" style="color: #3b82f6; text-decoration: none; font-weight: 500;">
                            <i class="fas fa-arrow-right"></i> Lihat semua transaksi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
