<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasiria - Admin Dashboard')</title>
    
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>
<body class="antialiased overflow-x-hidden">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 w-64 h-full glass-dark border-r border-white/10 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-white/10">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-500/30">K</div>
            <div class="ml-3">
                <h1 class="text-xl font-bold text-white tracking-wide">Kasiria</h1>
                <p class="text-xs text-slate-400 uppercase tracking-wider">Admin Panel</p>
            </div>
        </div>

        <!-- Menu -->
        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 px-3">Menu Utama</div>
            
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600/20 text-blue-400 border-l-2 border-blue-500' : '' }}">
                <i class="fas fa-home w-6 text-center"></i>
                <span class="ml-2">Dashboard</span>
            </a>
            
            <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 transition-all {{ request()->routeIs('users.*') ? 'bg-blue-600/20 text-blue-400 border-l-2 border-blue-500' : '' }}">
                <i class="fas fa-users w-6 text-center"></i>
                <span class="ml-2">Pengguna</span>
            </a>

            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-6 mb-2 px-3">Transaksi</div>

            <a href="{{ route('transactions.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 transition-all {{ request()->routeIs('transactions.*') ? 'bg-blue-600/20 text-blue-400 border-l-2 border-blue-500' : '' }}">
                <i class="fas fa-receipt w-6 text-center"></i>
                <span class="ml-2">Penjualan</span>
            </a>

            <a href="{{ route('products.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 transition-all {{ request()->routeIs('products.*') ? 'bg-blue-600/20 text-blue-400 border-l-2 border-blue-500' : '' }}">
                <i class="fas fa-box w-6 text-center"></i>
                <span class="ml-2">Produk</span>
            </a>

            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-6 mb-2 px-3">Laporan</div>

            <a href="{{ route('reports.sales') }}" class="flex items-center px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 transition-all {{ request()->routeIs('reports.*') ? 'bg-blue-600/20 text-blue-400 border-l-2 border-blue-500' : '' }}">
                <i class="fas fa-chart-line w-6 text-center"></i>
                <span class="ml-2">Laporan Penjualan</span>
            </a>

            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-6 mb-2 px-3">Pengaturan</div>

            <a href="{{ route('settings') }}" class="flex items-center px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 transition-all {{ request()->routeIs('settings') ? 'bg-blue-600/20 text-blue-400 border-l-2 border-blue-500' : '' }}">
                <i class="fas fa-cog w-6 text-center"></i>
                <span class="ml-2">Pengaturan</span>
            </a>

            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-3 py-2.5 rounded-lg text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all">
                <i class="fas fa-sign-out-alt w-6 text-center"></i>
                <span class="ml-2">Keluar</span>
            </a>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
        
        <!-- User Profile Mini -->
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-medium text-white">{{ auth()->user()->nama ?? 'User' }}</div>
                    <div class="text-xs text-slate-400">{{ ucfirst(auth()->user()->role ?? 'Guest') }} • <span class="text-yellow-400"><i class="fas fa-star text-[10px] mr-1"></i>{{ auth()->user()->points ?? 0 }} pts</span></div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen flex flex-col transition-all duration-300">
        <!-- Topbar -->
        <header class="glass sticky top-0 z-40 h-20 px-6 flex items-center justify-between backdrop-blur-md border-b border-white/10">
             <div class="flex items-center gap-4">
                 <button onclick="toggleSidebar()" class="lg:hidden text-slate-300 hover:text-white p-2">
                     <i class="fas fa-bars text-xl"></i>
                 </button>
                 <h2 class="text-xl font-semibold text-white">@yield('page_title', 'Dashboard')</h2>
             </div>

             <div class="flex items-center gap-6">
                 <!-- Search -->
                 <div class="hidden md:flex items-center glass-input rounded-full px-4 py-2 border border-white/10 bg-white/5 focus-within:bg-white/10 transition-all w-64">
                     <i class="fas fa-search text-slate-400 text-sm"></i>
                     <input type="text" placeholder="Cari..." class="bg-transparent border-none text-sm text-white ml-2 focus:outline-none w-full placeholder-slate-500">
                 </div>

                 <!-- Actions -->
                 <div class="flex items-center gap-3">
                     <button class="w-10 h-10 rounded-full flex items-center justify-center text-slate-300 hover:text-white hover:bg-white/10 transition-all relative">
                         <i class="fas fa-bell"></i>
                         <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-slate-900"></span>
                     </button>
                 </div>
             </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 p-6">
            <!-- Breadcrumb -->
            @hasSection('breadcrumb')
                <div class="mb-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-slate-400">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
            @endif

            <!-- Alerts -->
            @if ($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-200 px-4 py-3 rounded-xl flex items-start sm:items-center justify-between" role="alert">
                    <div>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-200 px-4 py-3 rounded-xl flex items-center justify-between" role="alert">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-200 px-4 py-3 rounded-xl flex items-center justify-between" role="alert">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </span>
                </div>
            @endif

            <!-- Main Yield -->
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>
    
    @yield('scripts')
</body>
</html>
