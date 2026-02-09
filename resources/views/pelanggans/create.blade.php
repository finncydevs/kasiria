@extends('layouts.app')

@section('title', 'Tambah Pelanggan - Kasiria')
@section('page_title', 'Tambah Pelanggan')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('pelanggans.index') }}" class="hover:text-blue-400 transition-colors">Pelanggan</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Tambah
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 glass-panel">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                <i class="fas fa-user-plus text-blue-400"></i> Tambah Pelanggan Baru
            </h2>
            
            <form action="{{ route('pelanggans.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Nama Pelanggan</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-user"></i></span>
                            <input type="text" name="nama" class="glass-input w-full pl-10" placeholder="Nama Lengkap" value="{{ old('nama') }}" required>
                        </div>
                        @error('nama')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="glass-input w-full pl-10" placeholder="nama@email.com" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">No. HP</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-phone"></i></span>
                                <input type="text" name="no_hp" class="glass-input w-full pl-10" placeholder="08..." value="{{ old('no_hp') }}">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Alamat</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-map-marker-alt"></i></span>
                            <textarea name="alamat" rows="3" class="glass-input w-full pl-10" placeholder="Alamat lengkap...">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Member Level</label>
                            <select name="member_level" class="glass-input w-full">
                                <option value="">-- Pilih Level --</option>
                                <option value="Bronze" {{ old('member_level') == 'Bronze' ? 'selected' : '' }}>Bronze</option>
                                <option value="Silver" {{ old('member_level') == 'Silver' ? 'selected' : '' }}>Silver</option>
                                <option value="Gold" {{ old('member_level') == 'Gold' ? 'selected' : '' }}>Gold</option>
                                <option value="Platinum" {{ old('member_level') == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                            </select>
                        </div>
                        
                        <div class="flex items-end mb-2">
                             <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', true) ? 'checked' : '' }}>
                                <div class="relative w-11 h-6 bg-slate-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-800 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-slate-300">Status Aktif</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white/10 flex gap-3">
                        <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white px-6 py-2.5 shadow-lg shadow-blue-500/20">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                        <a href="{{ route('pelanggans.index') }}" class="glass-btn bg-white/5 hover:bg-white/10 text-slate-300 px-6 py-2.5">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="glass-panel h-fit bg-gradient-to-br from-blue-900/20 to-purple-900/20 border-blue-500/10">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <i class="fas fa-award text-yellow-400"></i> Informasi Member
            </h3>
            <div class="space-y-4 text-sm text-slate-300">
                <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                    <p class="font-medium text-white mb-1"><i class="fas fa-info-circle mr-2 text-blue-400"></i>Keuntungan Member</p>
                    <ul class="list-disc list-inside text-xs text-slate-400 pl-1 space-y-1">
                        <li>Pengumpulan Poin (1 Poin tiap Rp 1.000)</li>
                        <li>Diskon khusus member (Level Gold & Platinum)</li>
                        <li>Riwayat belanja tersimpan</li>
                    </ul>
                </div>
                
                <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                    <p class="font-medium text-white mb-1"><i class="fas fa-layer-group mr-2 text-purple-400"></i>Level Member</p>
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        <span class="text-xs px-2 py-1 rounded bg-orange-700/30 text-orange-400 border border-orange-700/50 text-center">Bronze</span>
                        <span class="text-xs px-2 py-1 rounded bg-slate-400/30 text-slate-300 border border-slate-400/50 text-center">Silver</span>
                        <span class="text-xs px-2 py-1 rounded bg-yellow-500/30 text-yellow-400 border border-yellow-500/50 text-center">Gold</span>
                        <span class="text-xs px-2 py-1 rounded bg-slate-200/30 text-white border border-slate-200/50 text-center">Platinum</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
