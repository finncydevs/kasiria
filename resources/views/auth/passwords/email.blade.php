<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Kasiria</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e686fa0059.js" crossorigin="anonymous"></script>
    
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

        /* ── Horizontal Carousel ── */
        .carousel-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .carousel-track {
            display: flex;
            height: 100%;
            transition: transform 0.7s cubic-bezier(0.77, 0, 0.18, 1);
        }
        .carousel-slide {
            position: relative;
            flex: 0 0 100%;
            width: 100%;
            height: 100%;
        }
        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        /* Bottom dark gradient */
        .carousel-slide::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(15,23,42,0.10) 40%,
                rgba(15,23,42,0.85) 100%
            );
        }
        /* Caption inside each slide */
        .carousel-caption {
            position: absolute;
            bottom: 72px;
            left: 0; right: 0;
            z-index: 2;
            padding: 0 1.5rem;
            text-align: center;
        }
        .carousel-caption-inner {
            display: inline-block;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.13);
            border-radius: 1rem;
            padding: 0.875rem 1.25rem;
            max-width: 280px;
        }
        /* Brand pill */
        .carousel-brand {
            position: absolute;
            top: 16px;
            left: 0; right: 0;
            display: flex;
            justify-content: center;
            z-index: 3;
        }
        .carousel-brand-inner {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 999px;
            padding: 6px 16px;
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
        <div class="p-8 md:p-12 relative z-10 bg-slate-900/60 backdrop-blur-xl flex flex-col justify-center">
            <div class="mb-8 text-center md:text-left">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-500/30 mb-4 mx-auto md:mx-0">
                    <i class="fas fa-key"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Lupa Password?</h2>
                <p class="text-slate-400 text-sm">Masukkan alamat email Anda untuk menerima tautan reset password.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-300 mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="glass-input w-full pl-10 @error('email') border-red-500 @enderror" placeholder="user@gmail.com" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold shadow-lg shadow-blue-500/30 transition-all transform hover:scale-[1.02]">
                    Kirim Link Reset
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-slate-400 text-sm">
                    Kirim link ke email berhasil? <a href="{{ route('login') }}" class="text-white hover:text-blue-400 font-medium transition-colors">Kembali ke Login</a>
                </p>
            </div>
        </div>

        <!-- Right Side (Carousel) -->
        <div class="hidden md:block relative overflow-hidden" style="min-height: 500px;">
            <div class="carousel-wrapper">
                <div class="carousel-track">
                    <div class="carousel-slide">
                        <img src="{{ asset('assets/img/login-slides/image.png') }}" alt="Kasir modern">
                        <div class="carousel-caption">
                            <div class="carousel-caption-inner">
                                <i class="fas fa-shield-alt text-blue-400 text-xl mb-2" style="display:block"></i>
                                <p class="text-white font-semibold text-sm">Keamanan Terjamin</p>
                                <p class="text-slate-300 text-xs mt-1">Data Anda aman bersama kami</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-brand">
                    <div class="carousel-brand-inner">
                        <div style="width:20px;height:20px;border-radius:5px;background:linear-gradient(135deg,#3b82f6,#7c3aed);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:11px;flex-shrink:0">K</div>
                        <span class="text-white text-xs font-medium">Kasiria — Sistem Kasir Modern</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
