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
        /* Dot indicators */
        .carousel-dots {
            position: absolute;
            bottom: 24px;
            left: 0; right: 0;
            display: flex;
            justify-content: center;
            gap: 8px;
            z-index: 3;
        }
        .carousel-dot {
            width: 8px; height: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,0.35);
            border: none;
            cursor: pointer;
            padding: 0;
            transition: background 0.3s, width 0.3s;
            outline: none;
        }
        .carousel-dot.active {
            background: #ffffff;
            width: 24px;
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
                        <input type="text" name="username" class="glass-input w-full pl-10" placeholder="user@gmail.com" value="{{ old('username') }}" required autofocus>
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

        <!-- Right Side (Horizontal Carousel) -->
        <div class="hidden md:block relative overflow-hidden" style="min-height: 500px;">
            <div class="carousel-wrapper" id="carousel">

                <!-- Track -->
                <div class="carousel-track" id="carouselTrack">

                    <!-- Slide 1 -->
                    <div class="carousel-slide">
                        <img src="{{ asset('assets/img/login-slides/image.png') }}" alt="Kasir modern">
                        <div class="carousel-caption">
                            <div class="carousel-caption-inner">
                                <i class="fas fa-cash-register text-blue-400 text-xl mb-2" style="display:block"></i>
                                <p class="text-white font-semibold text-sm">Transaksi Cepat &amp; Mudah</p>
                                <p class="text-slate-300 text-xs mt-1">Proses pembayaran dalam hitungan detik</p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-slide">
                        <img src="{{ asset('assets/img/login-slides/image1.png') }}" alt="Laporan bisnis">
                        <div class="carousel-caption">
                            <div class="carousel-caption-inner">
                                <i class="fas fa-chart-line text-purple-400 text-xl mb-2" style="display:block"></i>
                                <p class="text-white font-semibold text-sm">Laporan Real-Time</p>
                                <p class="text-slate-300 text-xs mt-1">Pantau performa bisnis kapan saja</p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-slide">
                        <img src="{{ asset('assets/img/login-slides/image2.png') }}" alt="Manajemen produk">
                        <div class="carousel-caption">
                            <div class="carousel-caption-inner">
                                <i class="fas fa-boxes text-emerald-400 text-xl mb-2" style="display:block"></i>
                                <p class="text-white font-semibold text-sm">Kelola Stok Produk</p>
                                <p class="text-slate-300 text-xs mt-1">Inventaris selalu terkontrol</p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="carousel-slide">
                        <img src="{{ asset('assets/img/login-slides/image3.png') }}" alt="Tim kerja">
                        <div class="carousel-caption">
                            <div class="carousel-caption-inner">
                                <i class="fas fa-users text-amber-400 text-xl mb-2" style="display:block"></i>
                                <p class="text-white font-semibold text-sm">Manajemen Karyawan</p>
                                <p class="text-slate-300 text-xs mt-1">Kelola tim Anda dengan mudah</p>
                            </div>
                        </div>
                    </div>

                </div><!-- /track -->

                <!-- Dot indicators -->
                <div class="carousel-dots" id="carouselDots">
                    <button class="carousel-dot active" data-index="0" aria-label="Slide 1"></button>
                    <button class="carousel-dot" data-index="1" aria-label="Slide 2"></button>
                    <button class="carousel-dot" data-index="2" aria-label="Slide 3"></button>
                    <button class="carousel-dot" data-index="3" aria-label="Slide 4"></button>
                </div>

                <!-- Brand pill -->
                <div class="carousel-brand">
                    <div class="carousel-brand-inner">
                        <div style="width:20px;height:20px;border-radius:5px;background:linear-gradient(135deg,#3b82f6,#7c3aed);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:11px;flex-shrink:0">K</div>
                        <span class="text-white text-xs font-medium">Kasiria — Sistem Kasir Modern</span>
                    </div>
                </div>

            </div><!-- /carousel-wrapper -->
        </div>
    </div>

    <script src="https://kit.fontawesome.com/e686fa0059.js" crossorigin="anonymous"></script>

    <script>
        (function () {
            const track  = document.getElementById('carouselTrack');
            const dots   = document.querySelectorAll('.carousel-dot');
            const total  = dots.length;
            let current  = 0;
            let timer    = null;

            function goTo(index) {
                current = (index + total) % total;
                track.style.transform = `translateX(-${current * 100}%)`;
                dots.forEach((d, i) => d.classList.toggle('active', i === current));
            }

            function startAuto() {
                clearInterval(timer);
                timer = setInterval(() => goTo(current + 1), 4000);
            }

            // Dot clicks
            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    goTo(Number(dot.dataset.index));
                    // pause for 6 s then restart
                    clearInterval(timer);
                    setTimeout(startAuto, 6000);
                });
            });

            startAuto();
        })();
    </script>
</body>
</html>

