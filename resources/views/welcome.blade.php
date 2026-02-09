<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Kasiria</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 100%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 100%, hsla(339,49%,30%,1) 0, transparent 50%);
            background-attachment: fixed;
            background-size: cover;
            overflow-x: hidden;
        }
        .text-glow {
            text-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }
    </style>
</head>
<body class="min-h-screen text-white relative">

    <!-- Background Decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-[-1]">
        <div class="absolute top-[10%] left-[20%] w-[30%] h-[30%] rounded-full bg-blue-600/20 blur-[100px] animate-blob"></div>
        <div class="absolute bottom-[20%] right-[10%] w-[40%] h-[40%] rounded-full bg-purple-600/20 blur-[100px] animate-blob animation-delay-2000"></div>
    </div>

    <!-- Navigation -->
    <nav class="absolute top-0 w-full p-6 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center font-bold text-white shadow-lg shadow-blue-500/30">K</div>
                <span class="font-bold text-xl tracking-wide">Kasiria</span>
            </div>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="glass-btn px-6 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-full font-medium transition-all">
                        Dashboard <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="glass-btn px-6 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-full font-medium transition-all mr-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="glass-btn px-6 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white rounded-full font-medium transition-all shadow-lg shadow-blue-500/30 border-0">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="container mx-auto px-6 pt-32 pb-16 min-h-screen flex flex-col justify-center text-center">
        <div class="max-w-4xl mx-auto relative z-10">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-md text-sm font-medium text-blue-300 mb-8 animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-blue-400 mr-2 animate-pulse"></span>
                Sistem Kasir Modern Terpercaya
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight animate-fade-in-up" style="animation-delay: 0.1s;">
                Kelola Bisnis Anda <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 text-glow">Lebih Cerdas</span>
            </h1>
            
            <p class="text-xl text-slate-300 mb-10 max-w-2xl mx-auto leading-relaxed animate-fade-in-up" style="animation-delay: 0.2s;">
                Optimalkan operasional toko, pantau stok real-time, dan analisis penjualan dengan dashboard interaktif Kasiria.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16 animate-fade-in-up" style="animation-delay: 0.3s;">
                <a href="{{ route('register') }}" class="px-8 py-4 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-bold text-lg shadow-xl shadow-blue-500/30 transition-all transform hover:scale-105">
                    Mulai Sekarang Gratis <i class="fas fa-rocket ml-2"></i>
                </a>
                <a href="#features" class="px-8 py-4 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold text-lg backdrop-blur-md transition-all">
                    Pelajari Lebih Lanjut
                </a>
            </div>

            <!-- Features Grid -->
            <div id="features" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-left animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="glass-panel p-6 hover:bg-white/10 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Transaksi Cepat</h3>
                    <p class="text-slate-400 text-sm">Proses pembayaran instan dengan dukungan berbagai metode pembayaran.</p>
                </div>
                
                <div class="glass-panel p-6 hover:bg-white/10 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Manajemen Stok</h3>
                    <p class="text-slate-400 text-sm">Pantau inventaris secara real-time dan dapatkan notifikasi stok menipis.</p>
                </div>
                
                <div class="glass-panel p-6 hover:bg-white/10 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Analisis Bisnis</h3>
                    <p class="text-slate-400 text-sm">Laporan penjualan lengkap untuk membantu pengambilan keputusan strategis.</p>
                </div>

                <div class="glass-panel p-6 hover:bg-white/10 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-pink-500/20 text-pink-400 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Member & Poin</h3>
                    <p class="text-slate-400 text-sm">Loyalty program terintegrasi untuk meningkatkan retensi pelanggan.</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="border-t border-white/10 bg-slate-900/50 backdrop-blur-lg">
        <div class="container mx-auto px-6 py-8 flex flex-col md:flex-row justify-between items-center text-slate-400 text-sm">
            <p>&copy; 2025 Kasiria. All rights reserved.</p>
            <div class="flex gap-4 mt-4 md:mt-0">
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-white transition-colors">Contact</a>
            </div>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/e686fa0059.js" crossorigin="anonymous"></script>
</body>
</html>
