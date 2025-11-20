<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo">K</div>
        <div>
            <div class="brand">Kasiria</div>
            <div class="sidebar-brand-text">Admin Panel</div>
        </div>
    </div>

    <ul class="sidebar-menu">
        <li class="sidebar-menu-title">Menu Utama</li>
        <li>
            <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('users.index') }}" class="@if(request()->routeIs('users.*')) active @endif">
                <i class="fas fa-users"></i>
                Pengguna
            </a>
        </li>

        <li class="sidebar-menu-title">Transaksi</li>
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

        <li class="sidebar-menu-title">Laporan</li>
        <li>
            <a href="{{ route('reports.sales') }}" class="@if(request()->routeIs('reports.*')) active @endif">
                <i class="fas fa-chart-line"></i>
                Laporan Penjualan
            </a>
        </li>

        <li class="sidebar-menu-title">Pengaturan</li>
        <li>
            <a href="{{ route('settings') }}" class="@if(request()->routeIs('settings')) active @endif">
                <i class="fas fa-cog"></i>
                Pengaturan
            </a>
        </li>
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
