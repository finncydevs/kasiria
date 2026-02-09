<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Kasiria</title>
    
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
                radial-gradient(at 100% 100%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 0% 100%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 0% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <!-- Background Decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-[-1]">
        <div class="absolute top-[20%] right-[10%] w-[50%] h-[50%] rounded-full bg-purple-600/20 blur-[100px] animate-blob"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[40%] h-[40%] rounded-full bg-blue-600/20 blur-[100px] animate-blob animation-delay-2000"></div>
    </div>

    <div class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-2 rounded-2xl overflow-hidden shadow-2xl border border-white/10 glass">
        
        <!-- Right Side (Decorative) - Swapped for variety -->
        <div class="hidden md:flex flex-col items-center justify-center p-12 relative overflow-hidden bg-gradient-to-br from-indigo-900/40 via-slate-900/40 to-blue-900/40">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1556742046-63b128522e84?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80')] bg-cover bg-center opacity-10 mix-blend-overlay"></div>
            
            <div class="relative z-10 text-center">
                <h3 class="text-3xl font-bold text-white mb-4">Bergabung Bersama Kami</h3>
                <p class="text-slate-300 leading-relaxed max-w-sm mx-auto mb-8">
                    Mulai perjalanan bisnis Anda dengan sistem kasir yang modern, efisien, dan terpercaya.
                </p>
                
                <div class="grid grid-cols-2 gap-4 text-left">
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <i class="fas fa-bolt text-yellow-400 mb-2 text-xl"></i>
                        <h4 class="text-white font-medium text-sm">Cepat & Ringan</h4>
                    </div>
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <i class="fas fa-shield-alt text-emerald-400 mb-2 text-xl"></i>
                        <h4 class="text-white font-medium text-sm">Aman Terjamin</h4>
                    </div>
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <i class="fas fa-chart-line text-blue-400 mb-2 text-xl"></i>
                        <h4 class="text-white font-medium text-sm">Analisis Lengkap</h4>
                    </div>
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <i class="fas fa-mobile-alt text-purple-400 mb-2 text-xl"></i>
                        <h4 class="text-white font-medium text-sm">Mobile Friendly</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Left Side (Form) -->
        <div class="p-8 md:p-12 relative z-10 bg-slate-900/60 backdrop-blur-xl">
            <div class="mb-6 text-center md:text-left">
                <h2 class="text-2xl font-bold text-white mb-1">Buat Akun Baru</h2>
                <p class="text-slate-400 text-sm">Lengkapi data berikut untuk mendaftar.</p>
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

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-xs font-medium text-slate-300 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                    <input type="text" name="nama" class="glass-input w-full" placeholder="Nama Anda" value="{{ old('nama') }}" required>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5 uppercase tracking-wide">Username</label>
                        <input type="text" name="username" class="glass-input w-full" placeholder="Username" value="{{ old('username') }}" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5 uppercase tracking-wide">No. HP</label>
                        <input type="text" name="no_hp" class="glass-input w-full" placeholder="08..." value="{{ old('no_hp') }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-medium text-slate-300 mb-1.5 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" class="glass-input w-full" placeholder="user@kasiria.com" value="{{ old('email') }}" required>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5 uppercase tracking-wide">Password</label>
                        <input type="password" name="password" class="glass-input w-full" placeholder="8+ Karakter" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5 uppercase tracking-wide">Konfirmasi</label>
                        <input type="password" name="password_confirmation" class="glass-input w-full" placeholder="Ulangi" required>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-semibold shadow-lg shadow-emerald-500/30 transition-all transform hover:scale-[1.02]">
                    <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                </button>
            </form>

            <div class="mt-6 text-center pt-6 border-t border-white/10">
                <p class="text-slate-400 text-sm">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300 font-medium transition-colors">Masuk disini</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/e686fa0059.js" crossorigin="anonymous"></script>
</body>
</html>
