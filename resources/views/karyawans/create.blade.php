@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('page_title', 'Tambah Karyawan')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium hover:text-white transition-colors">
            <i class="fas fa-home mr-2"></i>
            Dashboard
        </a>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-xs mx-2"></i>
            <a href="{{ route('karyawans.index') }}" class="text-sm font-medium hover:text-white transition-colors">Data Karyawan</a>
        </div>
    </li>
    <li>
        <div class="flex items-center">
            <i class="fas fa-chevron-right text-xs mx-2"></i>
            <span class="text-sm font-medium text-white">Tambah Baru</span>
        </div>
    </li>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass-panel p-8">
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center">
                <i class="fas fa-user-plus text-blue-400"></i>
            </div>
            Form Karyawan Baru
        </h2>

        <form action="{{ route('karyawans.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama -->
            <div class="space-y-2">
                <label for="nama" class="text-sm font-medium text-slate-300">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" name="nama" id="nama" class="glass-input pl-10 w-full @error('nama') border-red-500 @enderror" value="{{ old('nama') }}" required placeholder="Contoh: Budi Santoso">
                </div>
                @error('nama')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jabatan -->
            <div class="space-y-2">
                <label for="jabatan" class="text-sm font-medium text-slate-300">Jabatan</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-briefcase"></i>
                    </span>
                    <select name="jabatan" id="jabatan" class="glass-input pl-10 w-full appearance-none @error('jabatan') border-red-500 @enderror" required>
                        <option value="" disabled selected class="text-slate-800">Pilih Jabatan</option>
                        <option value="Staff" class="text-slate-800">Staff</option>
                        <option value="Kasir" class="text-slate-800">Kasir</option>
                        <option value="Manager" class="text-slate-800">Manager</option>
                        <option value="Supervisor" class="text-slate-800">Supervisor</option>
                        <option value="Admin" class="text-slate-800">Admin</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
                @error('jabatan')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- No HP -->
            <div class="space-y-2">
                <label for="no_hp" class="text-sm font-medium text-slate-300">Nomor HP / WhatsApp</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-phone"></i>
                    </span>
                    <input type="text" name="no_hp" id="no_hp" class="glass-input pl-10 w-full @error('no_hp') border-red-500 @enderror" value="{{ old('no_hp') }}" placeholder="0812...">
                </div>
                @error('no_hp')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- User Account -->
            <div class="space-y-2 pt-4 border-t border-white/10">
                <label for="user_id" class="text-sm font-medium text-slate-300">Akun Pengguna (Opsional)</label>
                <p class="text-xs text-slate-500 mb-2">Hubungkan karyawan ini dengan akun login yang sudah ada.</p>
                <div class="relative">
                     <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-link"></i>
                    </span>
                    <select name="user_id" id="user_id" class="glass-input pl-10 w-full appearance-none @error('user_id') border-red-500 @enderror">
                        <option value="" class="text-slate-800">-- Tidak Ada Akun --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" class="text-slate-800" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->nama }} ({{ $user->username }})
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
                @error('user_id')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6">
                <a href="{{ route('karyawans.index') }}" class="px-4 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 transition-colors">Batal</a>
                <button type="submit" class="glass-btn">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
