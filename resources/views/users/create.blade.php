@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page_title', 'Tambah Pengguna')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('users.index') }}" class="hover:text-blue-400 transition-colors">Pengguna</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Tambah
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2 glass-panel">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                <i class="fas fa-user-plus text-blue-400"></i> Tambah Pengguna Baru
            </h2>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-user"></i></span>
                            <input type="text" name="nama" class="glass-input w-full pl-10 @error('nama') border-red-500/50 @enderror" placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required>
                        </div>
                        @error('nama')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-at"></i></span>
                            <input type="text" name="username" class="glass-input w-full pl-10 @error('username') border-red-500/50 @enderror" placeholder="username123" value="{{ old('username') }}" required>
                        </div>
                        @error('username')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="glass-input w-full pl-10 @error('email') border-red-500/50 @enderror" placeholder="user@example.com" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">No HP</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-phone"></i></span>
                            <input type="text" name="no_hp" class="glass-input w-full pl-10 @error('no_hp') border-red-500/50 @enderror" placeholder="081234567890" value="{{ old('no_hp') }}">
                        </div>
                        @error('no_hp')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Role</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-shield-alt"></i></span>
                            <select name="role" class="glass-input w-full pl-10 @error('role') border-red-500/50 @enderror" required>
                                <option value="" class="text-slate-800">-- Pilih Role --</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }} class="text-slate-800">Admin</option>
                                <option value="kasir" {{ old('role') === 'kasir' ? 'selected' : '' }} class="text-slate-800">Kasir</option>
                                <option value="owner" {{ old('role') === 'owner' ? 'selected' : '' }} class="text-slate-800">Owner</option>
                            </select>
                        </div>
                        @error('role')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="glass-input w-full pl-10 @error('password') border-red-500/50 @enderror" placeholder="Minimal 8 karakter" required>
                            </div>
                            @error('password')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Konfirmasi Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-lock-open"></i></span>
                                <input type="password" name="password_confirmation" class="glass-input w-full pl-10" placeholder="Ketik ulang password" required>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center cursor-pointer gap-3">
                            <div class="relative inline-block w-10 h-6 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="status" id="status" value="1" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer peer checked:right-0 checked:border-emerald-500 transition-all duration-300 right-4 border-slate-300" {{ old('status', true) ? 'checked' : '' }} />
                                <div class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-700 cursor-pointer peer-checked:bg-emerald-500/50 transition-colors duration-300"></div>
                            </div>
                            <span class="text-slate-200 font-medium">Akun Aktif</span>
                        </label>
                    </div>

                    <div class="flex gap-3 mt-6 pt-4 border-t border-white/10">
                        <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white px-6 py-2.5 shadow-lg shadow-blue-500/20">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                        <a href="{{ route('users.index') }}" class="glass-btn bg-white/5 hover:bg-white/10 text-slate-300 px-6 py-2.5">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Info Section -->
        <div class="glass-panel bg-white/5 h-fit">
            <h5 class="font-medium text-white mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-400"></i> Informasi Role
            </h5>
            <div class="space-y-4 text-sm text-slate-300">
                <div class="p-3 rounded-lg bg-white/5 border border-white/5">
                    <strong class="text-purple-400 block mb-1">Admin</strong>
                    <p class="text-slate-400">Memiliki akses penuh ke seluruh fitur sistem, termasuk manajemen pengguna dan pengaturan.</p>
                </div>
                <div class="p-3 rounded-lg bg-white/5 border border-white/5">
                    <strong class="text-blue-400 block mb-1">Kasir</strong>
                    <p class="text-slate-400">Akses terbatas untuk melakukan transaksi penjualan dan melihat riwayat transaksi sendiri.</p>
                </div>
                <div class="p-3 rounded-lg bg-white/5 border border-white/5">
                    <strong class="text-amber-400 block mb-1">Owner</strong>
                    <p class="text-slate-400">Akses untuk melihat laporan dan dashboard analitik, tanpa akses operasional kasir.</p>
                </div>
                
                <div class="mt-4 pt-4 border-t border-white/10">
                    <p class="text-xs text-slate-500">
                        <i class="fas fa-lock mr-1"></i> Password harus memiliki minimal 8 karakter.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
