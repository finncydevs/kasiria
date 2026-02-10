@extends('layouts.app')

@section('title', 'Pengaturan Sistem - Kasiria')
@section('page_title', 'Pengaturan Sistem')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Pengaturan
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1">
            <div class="glass-panel sticky top-24 p-2 space-y-1">
                <button onclick="switchTab('general')" class="w-full text-left px-4 py-3 rounded-xl transition-all flex items-center gap-3 tab-btn active-tab bg-blue-600/20 text-blue-400 border border-blue-500/30" id="btn-general">
                    <i class="fas fa-sliders-h"></i> Umum
                </button>
                <button onclick="switchTab('system')" class="w-full text-left px-4 py-3 rounded-xl transition-all flex items-center gap-3 tab-btn hover:bg-white/5 text-slate-400 border border-transparent" id="btn-system">
                    <i class="fas fa-server"></i> Sistem
                </button>
                <button onclick="switchTab('security')" class="w-full text-left px-4 py-3 rounded-xl transition-all flex items-center gap-3 tab-btn hover:bg-white/5 text-slate-400 border border-transparent" id="btn-security">
                    <i class="fas fa-shield-alt"></i> Keamanan
                </button>
                <button onclick="switchTab('backup')" class="w-full text-left px-4 py-3 rounded-xl transition-all flex items-center gap-3 tab-btn hover:bg-white/5 text-slate-400 border border-transparent" id="btn-backup">
                    <i class="fas fa-database"></i> Database
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="lg:col-span-3">
            @if(session('success'))
                <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- General Tab -->
            <div id="tab-general" class="tab-content transition-opacity duration-300">
                <div class="glass-panel">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                        <i class="fas fa-sliders-h text-blue-400"></i> Pengaturan Umum
                    </h2>
                    
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Nama Aplikasi</label>
                                <input type="text" name="app_name" value="{{ $settings['app_name'] ?? 'Kasiria' }}" class="glass-input w-full" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Deskripsi</label>
                                <textarea class="glass-input w-full bg-white/5 opacity-75 cursor-not-allowed" rows="3" readonly>{{ $settings['app_description'] ?? 'Sistem Manajemen Kasir Terintegrasi' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-400 mb-1">Mata Uang</label>
                                    <input type="text" value="{{ $settings['currency'] ?? 'IDR' }}" class="glass-input w-full bg-white/5 opacity-75" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-400 mb-1">Tarif Pajak (%)</label>
                                    <input type="number" name="tax_rate" step="0.01" value="{{ old('tax_rate', $settings['tax_rate'] ?? 0) }}" class="glass-input w-full" required>
                                </div>
                            </div>
                            
                            <div class="pt-4 border-t border-white/10">
                                <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white px-6 py-2.5 shadow-lg shadow-blue-500/20">
                                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- System Tab -->
            <div id="tab-system" class="tab-content hidden opacity-0 transition-opacity duration-300">
                <div class="glass-panel">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                        <i class="fas fa-server text-purple-400"></i> Informasi Sistem
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                            <h5 class="text-slate-200 font-medium mb-4 flex items-center gap-2">
                                <i class="fab fa-php text-indigo-400"></i> Lingkungan Server
                            </h5>
                            <ul class="space-y-3 text-sm">
                                <li class="flex justify-between border-b border-white/5 pb-2">
                                    <span class="text-slate-400">PHP Version</span>
                                    <span class="text-slate-200 font-mono">{{ phpversion() }}</span>
                                </li>
                                <li class="flex justify-between border-b border-white/5 pb-2">
                                    <span class="text-slate-400">Laravel Version</span>
                                    <span class="text-slate-200 font-mono">{{ app()->version() }}</span>
                                </li>
                                <li class="flex justify-between border-b border-white/5 pb-2">
                                    <span class="text-slate-400">Server Time</span>
                                    <span class="text-slate-200 font-mono">{{ date('H:i:s') }}</span>
                                </li>
                                <li class="flex justify-between pt-1">
                                    <span class="text-slate-400">Environment</span>
                                    @if(app()->environment('production'))
                                        <span class="px-2 py-0.5 rounded bg-red-500/20 text-red-400 text-xs border border-red-500/30">Production</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded bg-yellow-500/20 text-yellow-400 text-xs border border-yellow-500/30">{{ ucfirst(app()->environment()) }}</span>
                                    @endif
                                </li>
                            </ul>
                        </div>

                        <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                            <h5 class="text-slate-200 font-medium mb-4 flex items-center gap-2">
                                <i class="fas fa-database text-blue-400"></i> Database
                            </h5>
                            <ul class="space-y-3 text-sm">
                                <li class="flex justify-between border-b border-white/5 pb-2">
                                    <span class="text-slate-400">Connection</span>
                                    <span class="text-slate-200 font-mono">{{ config('database.default') }}</span>
                                </li>
                                <li class="flex justify-between border-b border-white/5 pb-2">
                                    <span class="text-slate-400">Host</span>
                                    <span class="text-slate-200 font-mono">{{ config('database.connections.mysql.host') }}</span>
                                </li>
                                <li class="flex justify-between border-b border-white/5 pb-2">
                                    <span class="text-slate-400">Database</span>
                                    <span class="text-slate-200 font-mono">{{ config('database.connections.mysql.database') }}</span>
                                </li>
                                <li class="flex justify-between pt-1">
                                    <span class="text-slate-400">Port</span>
                                    <span class="text-slate-200 font-mono">{{ config('database.connections.mysql.port') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Tab -->
            <div id="tab-security" class="tab-content hidden opacity-0 transition-opacity duration-300">
                <div class="glass-panel">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                        <i class="fas fa-shield-alt text-emerald-400"></i> Keamanan
                    </h2>
                    
                    <div class="bg-blue-500/10 border border-blue-500/20 text-blue-300 p-4 rounded-xl mb-6">
                        <div class="flex gap-3">
                            <i class="fas fa-info-circle mt-1"></i>
                            <div>
                                <p class="text-sm">Keamanan data adalah prioritas utama. Pastikan password Anda kuat dan rutin melakukan backup database.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                            <h5 class="text-white font-medium mb-4">Status Keamanan</h5>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 rounded-lg bg-white/5">
                                    <span class="text-slate-400">HTTPS / SSL</span>
                                    @if(request()->secure())
                                        <i class="fas fa-check-circle text-emerald-400"></i>
                                    @else
                                        <span class="text-red-400 text-xs"><i class="fas fa-exclamation-triangle"></i> Tidak Aktif</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between p-3 rounded-lg bg-white/5">
                                    <span class="text-slate-400">Debug Mode</span>
                                    @if(config('app.debug'))
                                        <span class="text-yellow-400 text-xs">Aktif (Tidak aman untuk production)</span>
                                    @else
                                        <i class="fas fa-check-circle text-emerald-400"></i>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                            <h5 class="text-white font-medium mb-4">Manajemen Akun</h5>
                            <p class="text-slate-400 text-sm mb-4">Ubah password atau perbarui profil administrator Anda.</p>
                            <a href="{{ route('profile.show') }}" class="glass-btn w-full block text-center bg-blue-600/20 text-blue-400 border-blue-500/30 hover:bg-blue-600/30">
                                <i class="fas fa-user-cog mr-2"></i> Ke Profil Saya
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Tab -->
            <div id="tab-backup" class="tab-content hidden opacity-0 transition-opacity duration-300">
                <div class="glass-panel">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                        <i class="fas fa-database text-amber-400"></i> Database Backup
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div>
                            <div class="p-6 rounded-2xl bg-gradient-to-br from-indigo-900/40 to-purple-900/40 border border-white/10 text-center">
                                <i class="fas fa-cloud-download-alt text-5xl text-indigo-400 mb-4 opacity-80"></i>
                                <h3 class="text-xl font-bold text-white mb-2">Backup Manual</h3>
                                <p class="text-slate-400 text-sm mb-6">Unduh salinan lengkap database SQL terbaru.</p>
                                
                                <form action="{{ route('settings.backup') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="glass-btn bg-emerald-600/80 hover:bg-emerald-600 text-white w-full shadow-lg shadow-emerald-500/20" onclick="return confirmAction(event, 'Buat backup database sekarang? Proses ini mungkin memakan waktu beberapa saat.', '{{ route('settings.backup') }}', 'Download Backup', 'info')">
                                        <i class="fas fa-download mr-2"></i> Download Backup
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                                <h6 class="text-white font-medium mb-1">Riwayat Backup</h6>
                                <p class="text-slate-500 text-xs italic">Belum ada riwayat backup tercatat.</p>
                            </div>
                            
                            <div class="bg-amber-500/10 rounded-xl p-4 border border-amber-500/20">
                                <h6 class="text-amber-400 font-medium mb-1"><i class="fas fa-lightbulb"></i> Tips</h6>
                                <p class="text-amber-200/70 text-xs">Simpan file backup di lokasi yang aman dan terpisah dari server aplikasi untuk mencegah kehilangan data.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function switchTab(tabName) {
            // Buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active-tab', 'bg-blue-600/20', 'text-blue-400', 'border-blue-500/30');
                btn.classList.add('text-slate-400', 'border-transparent');
            });
            
            const activeBtn = document.getElementById('btn-' + tabName);
            activeBtn.classList.add('active-tab', 'bg-blue-600/20', 'text-blue-400', 'border-blue-500/30');
            activeBtn.classList.remove('text-slate-400', 'border-transparent', 'hover:bg-white/5');

            // Content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden', 'opacity-0');
            });
            
            const activeContent = document.getElementById('tab-' + tabName);
            activeContent.classList.remove('hidden');
            setTimeout(() => {
                activeContent.classList.remove('opacity-0');
            }, 50);
        }
    </script>
    @endpush
@endsection
