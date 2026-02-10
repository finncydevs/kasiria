<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasiria - Admin Dashboard')</title>
    
    <!-- Fonts & Icons -->
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    @yield('styles')
</head>
<body class="antialiased overflow-x-hidden">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity lg:hidden" onclick="toggleSidebar()"></div>

    @include('partials.sidebar')

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
<script src="https://kit.fontawesome.com/e686fa0059.js" crossorigin="anonymous"></script>
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
    @stack('scripts')
</body>
</html>
