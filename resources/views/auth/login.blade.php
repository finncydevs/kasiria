<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kasiria</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <!-- Background Decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-[-1]">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-blue-600/20 blur-[100px] animate-blob"></div>
        <div class="absolute top-[40%] -right-[10%] w-[40%] h-[40%] rounded-full bg-purple-600/20 blur-[100px] animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[30%] h-[30%] rounded-full bg-pink-600/20 blur-[100px] animate-blob animation-delay-4000"></div>
    </div>

    <div class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-2 rounded-2xl overflow-hidden shadow-2xl border border-white/10 glass">
        
        <!-- Left Side (Form) -->
        <div class="p-8 md:p-12 relative z-10 bg-slate-900/60 backdrop-blur-xl">
            <div class="mb-8 text-center md:text-left">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-500/30 mb-4 mx-auto md:mx-0">
                    K
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang</h2>
                <p class="text-slate-400">Masuk untuk mengelola bisnis Anda bersama Kasiria.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-300 mb-2">Email / Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-envelope"></i></span>
                        <input type="text" name="username" class="glass-input w-full pl-10" placeholder="user@kasiria.com" value="{{ old('username') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="glass-input w-full pl-10" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded bg-white/10 border-white/20 text-blue-500 focus:ring-blue-500/50">
                        <span class="text-sm text-slate-400">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-sm text-blue-400 hover:text-blue-300 transition-colors">Lupa Password?</a>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold shadow-lg shadow-blue-500/30 transition-all transform hover:scale-[1.02]">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-slate-400 text-sm">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-white hover:text-blue-400 font-medium transition-colors">Daftar disini</a>
                </p>
            </div>
        </div>

        <!-- Right Side (Decorative) -->
        <div class="hidden md:flex flex-col items-center justify-center p-12 relative overflow-hidden bg-gradient-to-br from-blue-900/40 via-purple-900/40 to-slate-900/40">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80')] bg-cover bg-center opacity-10 mix-blend-overlay"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] to-transparent"></div>
            
            <div class="relative z-10 text-center">
                <div class="mb-6 inline-flex p-4 rounded-full bg-white/5 border border-white/10 backdrop-blur-md shadow-2xl animate-float">
                    <i class="fas fa-chart-pie text-5xl text-blue-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">Kelola Bisnis Lebih Mudah</h3>
                <p class="text-slate-300 leading-relaxed max-w-sm mx-auto">
                    Pantau penjualan, stok, dan laporan keuangan dalam satu dashboard yang modern dan intuitif.
                </p>
                
                <div class="mt-8 flex gap-2 justify-center">
                    <span class="w-2 h-2 rounded-full bg-white"></span>
                    <span class="w-2 h-2 rounded-full bg-white/30"></span>
                    <span class="w-2 h-2 rounded-full bg-white/30"></span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/e686fa0059.js" crossorigin="anonymous"></script>
</body>
</html>
