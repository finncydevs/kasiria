<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasiria - Admin Dashboard')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-blue: #1e40af;
            --light-blue: #3b82f6;
            --darker-blue: #1e3a8a;
            --white: #ffffff;
            --light-gray: #f8fafc;
            --border-gray: #e2e8f0;
            --text-dark: #1f2937;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-gray);
            color: var(--text-dark);
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--light-blue) 100%);
            padding-top: 0;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            background-color: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-header .logo {
            width: 45px;
            height: 45px;
            background-color: var(--white);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--primary-blue);
            font-size: 20px;
        }

        .sidebar-header .brand {
            color: var(--white);
            font-size: 1.3rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .sidebar-brand-text {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .sidebar-menu {
            padding: 2rem 0;
            list-style: none;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu-title {
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-top: 1rem;
        }

        .sidebar-menu-title:first-of-type {
            margin-top: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.85rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-size: 0.95rem;
        }

        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--white);
            border-left-color: var(--white);
            padding-left: 1.35rem;
        }

        .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: var(--white);
            border-left-color: var(--white);
            font-weight: 600;
        }

        .sidebar-menu i {
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 280px;
            padding-top: 70px;
            min-height: 100vh;
            background-color: var(--light-gray);
        }

        .topbar {
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            height: 70px;
            background-color: var(--white);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            z-index: 999;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .topbar-left h5 {
            margin: 0;
            color: var(--text-dark);
            font-weight: 600;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .search-box {
            position: relative;
            display: flex;
            align-items: center;
            background-color: var(--light-gray);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-gray);
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            width: 200px;
            padding: 0.5rem;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .search-box input::placeholder {
            color: #9ca3af;
        }

        .search-box i {
            color: #9ca3af;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification-icon,
        .settings-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-gray);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .notification-icon:hover,
        .settings-icon:hover {
            background-color: var(--light-blue);
            color: var(--white);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--light-blue), var(--primary-blue));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }

        /* Breadcrumb */
        .breadcrumb-container {
            padding: 1.5rem 2rem;
            background-color: var(--white);
            border-bottom: 1px solid var(--border-gray);
        }

        .breadcrumb {
            margin: 0;
            background-color: transparent;
        }

        .breadcrumb-item {
            color: #6b7280;
        }

        .breadcrumb-item.active {
            color: var(--text-dark);
            font-weight: 600;
        }

        .breadcrumb-item a {
            color: var(--light-blue);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-blue);
        }

        /* Page Content */
        .page-content {
            padding: 2rem;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2rem;
            color: var(--text-dark);
            font-weight: 700;
            margin: 0;
        }

        .page-header-buttons {
            display: flex;
            gap: 1rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: var(--white);
            border-bottom: 1px solid var(--border-gray);
            padding: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--light-blue);
            border: none;
            color: var(--white);
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-blue);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-secondary {
            background-color: var(--light-gray);
            border: 1px solid var(--border-gray);
            color: var(--text-dark);
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: var(--border-gray);
            border-color: #cbd5e1;
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar,
        body::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track,
        body::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb,
        body::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover,
        body::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                background: linear-gradient(135deg, var(--primary-blue) 0%, var(--light-blue) 100%);
            }

            .main-content {
                margin-left: 0;
                padding-top: 0;
            }

            .topbar {
                left: 0;
                position: static;
            }

            .sidebar-menu {
                display: flex;
                overflow-x: auto;
                padding: 1rem 0;
            }

            .sidebar-menu a {
                white-space: nowrap;
                padding: 0.75rem 1rem;
            }

            .topbar-left {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-box {
                width: 100%;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-header-buttons {
                width: 100%;
                margin-top: 1rem;
            }

            .page-header-buttons .btn {
                flex: 1;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <h5>@yield('page_title', 'Dashboard')</h5>
            </div>

            <div class="topbar-right">
                <div class="search-box">
                    <input type="text" placeholder="Cari...">
                    <i class="fas fa-search"></i>
                </div>

                <div class="user-menu">
                    <button class="notification-icon" title="Notifikasi">
                        <i class="fas fa-bell"></i>
                    </button>
                    <button class="settings-icon" title="Pengaturan">
                        <i class="fas fa-sliders-h"></i>
                    </button>
                    <a href="#" class="user-avatar" title="Profil">
                        {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 1)) }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Breadcrumb -->
        @hasSection('breadcrumb')
            <div class="breadcrumb-container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
        @endif

        <!-- Page Content -->
        <div class="page-content">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Ada kesalahan!</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar active link
        document.addEventListener('DOMContentLoaded', function() {
            const currentLocation = location.pathname;
            const menuItems = document.querySelectorAll('.sidebar-menu a');

            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentLocation) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        });

        // Notification bell animation
        document.querySelector('.notification-icon').addEventListener('click', function() {
            this.style.transform = 'scale(1.1)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });
    </script>

    @yield('scripts')
</body>
</html>
