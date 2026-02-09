@extends('layouts.app')

@section('title', 'Dashboard - Kasiria')
@section('page_title', 'Dashboard')

@section('breadcrumb')
    <li class="flex items-center">
        <i class="fas fa-home mr-2"></i> Dashboard
    </li>
@endsection

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-400">Selamat Datang, {{ auth()->user()->nama ?? 'Admin' }}!</h1>
            <p class="text-slate-400 mt-1">Berikut adalah ringkasan performa toko hari ini.</p>
        </div>
        <div>
            <a href="{{ route('transactions.create') }}" class="glass-btn flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Transaksi
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Sales Card -->
        <div class="glass-panel relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/20 rounded-full blur-xl group-hover:bg-blue-500/30 transition-all"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-400 text-sm font-medium">Total Penjualan</p>
                        <h3 class="text-2xl font-bold text-white mt-1">Rp 5.2M</h3>
                    </div>
                    <div class="p-2 bg-blue-500/20 rounded-lg text-blue-400">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs">
                    <span class="text-emerald-400 flex items-center gap-1 bg-emerald-500/10 px-2 py-1 rounded-full">
                        <i class="fas fa-arrow-up"></i> +12%
                    </span>
                    <span class="text-slate-500 ml-2">bulan ini</span>
                </div>
            </div>
        </div>

        <!-- Transactions Card -->
        <div class="glass-panel relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-500/20 rounded-full blur-xl group-hover:bg-purple-500/30 transition-all"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-400 text-sm font-medium">Jumlah Transaksi</p>
                        <h3 class="text-2xl font-bold text-white mt-1">245</h3>
                    </div>
                    <div class="p-2 bg-purple-500/20 rounded-lg text-purple-400">
                        <i class="fas fa-receipt text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs">
                    <span class="text-emerald-400 flex items-center gap-1 bg-emerald-500/10 px-2 py-1 rounded-full">
                        <i class="fas fa-arrow-up"></i> +8%
                    </span>
                    <span class="text-slate-500 ml-2">minggu ini</span>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="glass-panel relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-pink-500/20 rounded-full blur-xl group-hover:bg-pink-500/30 transition-all"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-400 text-sm font-medium">Total Pengguna</p>
                        <h3 class="text-2xl font-bold text-white mt-1">42</h3>
                    </div>
                    <div class="p-2 bg-pink-500/20 rounded-lg text-pink-400">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs">
                    <span class="text-blue-400 flex items-center gap-1 bg-blue-500/10 px-2 py-1 rounded-full">
                        <i class="fas fa-plus"></i> 5 new
                    </span>
                    <span class="text-slate-500 ml-2">minggu ini</span>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="glass-panel relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-500/20 rounded-full blur-xl group-hover:bg-orange-500/30 transition-all"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-400 text-sm font-medium">Produk Aktif</p>
                        <h3 class="text-2xl font-bold text-white mt-1">156</h3>
                    </div>
                    <div class="p-2 bg-orange-500/20 rounded-lg text-orange-400">
                        <i class="fas fa-box text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs">
                    <span class="text-amber-400 flex items-center gap-1 bg-amber-500/10 px-2 py-1 rounded-full">
                        <i class="fas fa-exclamation-triangle"></i> 8 low stock
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Sales Chart -->
        <div class="glass-panel lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-chart-area text-blue-400"></i> Analytics Penjualan
                </h3>
                <select class="glass-input text-xs py-1 px-3">
                    <option class="text-slate-900">7 Hari Terakhir</option>
                    <option class="text-slate-900">Bulan Ini</option>
                    <option class="text-slate-900">Tahun Ini</option>
                </select>
            </div>
            <div id="salesChart" class="w-full h-80"></div>
        </div>

        <!-- Top Cashier -->
        <div class="glass-panel">
            <h3 class="text-lg font-semibold text-white mb-6 flex items-center gap-2">
                <i class="fas fa-trophy text-yellow-400"></i> Top Kasir
            </h3>
            <div class="space-y-4">
                @foreach([
                    ['name' => 'Ahmad Wijaya', 'amount' => 'Rp 1.2M', 'percent' => 90, 'color' => 'bg-yellow-400'],
                    ['name' => 'Siti Nurhaliza', 'amount' => 'Rp 980K', 'percent' => 75, 'color' => 'bg-slate-400'],
                    ['name' => 'Budi Santoso', 'amount' => 'Rp 750K', 'percent' => 60, 'color' => 'bg-orange-400']
                ] as $cashier)
                <div class="p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-white">{{ $cashier['name'] }}</span>
                        <span class="text-sm font-bold text-blue-400">{{ $cashier['amount'] }}</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-1.5">
                        <div class="{{ $cashier['color'] }} h-1.5 rounded-full" style="width: {{ $cashier['percent'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-6 text-center">
                <a href="#" class="text-xs text-blue-400 hover:text-blue-300">Lihat Leaderboard Lengkap</a>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="glass-panel">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                <i class="fas fa-clock text-emerald-400"></i> Transaksi Terbaru
            </h3>
            <a href="{{ route('transactions.index') }}" class="text-sm text-blue-400 hover:text-blue-300">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/10 text-xs text-slate-400 uppercase tracking-wider">
                        <th class="p-3">ID Transaksi</th>
                        <th class="p-3">Pelanggan</th>
                        <th class="p-3">Kasir</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Waktu</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-white/5">
                    @foreach([
                        ['id' => '#TRX001', 'cust' => 'Andi Pratama', 'cash' => 'Ahmad Wijaya', 'total' => 'Rp 250.000', 'status' => 'Selesai', 'time' => '10:30 AM', 'status_color' => 'bg-emerald-500/20 text-emerald-400'],
                        ['id' => '#TRX002', 'cust' => 'Rini Kusuma', 'cash' => 'Siti Nurhaliza', 'total' => 'Rp 180.000', 'status' => 'Selesai', 'time' => '10:45 AM', 'status_color' => 'bg-emerald-500/20 text-emerald-400'],
                        ['id' => '#TRX003', 'cust' => 'Doni Setiawan', 'cash' => 'Budi Santoso', 'total' => 'Rp 420.000', 'status' => 'Pending', 'time' => '11:00 AM', 'status_color' => 'bg-yellow-500/20 text-yellow-400']
                    ] as $trx)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="p-3 font-medium text-white">{{ $trx['id'] }}</td>
                        <td class="p-3 text-slate-300">{{ $trx['cust'] }}</td>
                        <td class="p-3 text-slate-300">{{ $trx['cash'] }}</td>
                        <td class="p-3 font-semibold text-white">{{ $trx['total'] }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $trx['status_color'] }}">
                                {{ $trx['status'] }}
                            </span>
                        </td>
                        <td class="p-3 text-slate-400">{{ $trx['time'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            series: [{
                name: 'Penjualan',
                data: [31, 40, 28, 51, 42, 109, 100]
            }],
            chart: {
                height: 320,
                type: 'area',
                toolbar: { show: false },
                background: 'transparent'
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
                labels: { style: { colors: '#94a3b8' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { style: { colors: '#94a3b8' } }
            },
            grid: {
                borderColor: 'rgba(255, 255, 255, 0.1)',
                strokeDashArray: 4,
            },
            theme: { mode: 'dark' },
            colors: ['#3b82f6']
        };

        var chart = new ApexCharts(document.querySelector("#salesChart"), options);
        chart.render();
    });
</script>
@endsection
