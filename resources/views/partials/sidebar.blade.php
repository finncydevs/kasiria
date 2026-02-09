<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo">K</div>
        <div>
            <div class="brand">Kasiria</div>
            <div class="sidebar-brand-text">Admin Panel</div>
        </div>
    </div>

    {{-- Ambil objek user yang sedang login --}}
    @php
        $user = Auth::user();
    @endphp

    <ul class="sidebar-menu">
        <li class="sidebar-menu-title">Menu Utama</li>
        <li>
            {{-- Dashboard dapat diakses oleh semua role --}}
            <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </li>

        {{-- Pengguna: Hanya untuk Admin dan Owner --}}
        @if ($user->role === 'admin' )
        <li>
            <a href="{{ route('users.index') }}" class="@if(request()->routeIs('users.*')) active @endif">
                <i class="fas fa-users"></i>
                Pengguna
            </a>
        </li>
        @endif

        @if ($user->role === 'kasir')
        <li class="sidebar-menu-title">Transaksi</li>
        {{-- Transaksi: Dapat diakses oleh semua role (kasir, admin, owner) --}}
        <li>
            <a href="{{ route('transactions.index') }}" class="@if(request()->routeIs('transactions.*')) active @endif">
                <i class="fas fa-receipt"></i>
                Penjualan
            </a>
        </li>
        <li>
            <a href="{{ route('products.index') }}" class="@if(request()->routeIs('products.*')) active @endif">
                <i class="fas fa-box"></i>
                Produk
            </a>
        </li>
        <li>
            <a href="{{ route('kategoris.index') }}" class="@if(request()->routeIs('kategoris.*')) active @endif">
                <i class="fas fa-tags"></i>
                Kategori
            </a>
        </li>
        <li>
            <a href="{{ route('pelanggans.index') }}" class="@if(request()->routeIs('pelanggans.*')) active @endif">
                <i class="fas fa-user-friends"></i>
                Pelanggan
            </a>
        </li>
        @endif

        {{-- Laporan Penjualan: Hanya untuk Admin dan Owner --}}
        @if ($user->role === 'kasir' || $user->role === 'owner')
        <li class="sidebar-menu-title">Laporan</li>
        <li>
            <a href="{{ route('reports.sales') }}" class="@if(request()->routeIs('reports.*')) active @endif">
                <i class="fas fa-chart-line"></i>
                Laporan Penjualan
            </a>
        </li>
        @endif

        {{-- Pengaturan: Hanya untuk Admin dan Owner --}}
        @if ($user->role === 'admin' || $user->role === 'owner')
        <li class="sidebar-menu-title">Pengaturan</li>
        <li>
            <a href="{{ route('settings') }}" class="@if(request()->routeIs('settings')) active @endif">
                <i class="fas fa-cog"></i>
                Pengaturan
            </a>
        </li>
        @endif

        <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                Keluar
            </a>
        </li>
    </ul>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
