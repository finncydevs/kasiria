@extends('layouts.app')

@section('title', 'Edit Pengguna - ' . $user->nama)
@section('page_title', 'Edit Pengguna')

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
        Edit
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2 glass-panel">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                <i class="fas fa-user-edit text-yellow-400"></i> Edit Pengguna
            </h2>

            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-user"></i></span>
                            <input type="text" name="nama" class="glass-input w-full pl-10" value="{{ old('nama', $user->nama) }}" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-at"></i></span>
                            <input type="text" name="username" class="glass-input w-full pl-10" value="{{ old('username', $user->username) }}" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="glass-input w-full pl-10" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">No HP</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-phone"></i></span>
                            <input type="text" name="no_hp" class="glass-input w-full pl-10" value="{{ old('no_hp', $user->no_hp) }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Role</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-shield-alt"></i></span>
                            <select name="role" class="glass-input w-full pl-10" required>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }} class="text-slate-800">Admin</option>
                                <option value="kasir" {{ old('role', $user->role) === 'kasir' ? 'selected' : '' }} class="text-slate-800">Kasir</option>
                                <option value="owner" {{ old('role', $user->role) === 'owner' ? 'selected' : '' }} class="text-slate-800">Owner</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center cursor-pointer gap-3">
                            <div class="relative inline-block w-10 h-6 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="status" id="status" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer peer checked:right-0 checked:border-emerald-500 transition-all duration-300 right-4 border-slate-300" {{ old('status', $user->status) ? 'checked' : '' }} />
                                <div class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-700 cursor-pointer peer-checked:bg-emerald-500/50 transition-colors duration-300"></div>
                            </div>
                            <span class="text-slate-200 font-medium">Akun Aktif</span>
                        </label>
                    </div>

                    <div class="flex gap-3 mt-6 pt-4 border-t border-white/10">
                        <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white px-6 py-2.5 shadow-lg shadow-blue-500/20">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('users.index') }}" class="glass-btn bg-white/5 hover:bg-white/10 text-slate-300 px-6 py-2.5">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Actions Card -->
        <div class="lg:col-span-1 space-y-6">
             <div class="glass-panel bg-white/5 border-l-4 border-l-yellow-500">
                <h5 class="font-medium text-white mb-2">Perhatian</h5>
                <p class="text-sm text-slate-400">
                    Pastikan data yang diubah sudah benar. Mengubah role pengguna dapat mempengaruhi hak akses mereka ke dalam sistem.
                </p>
             </div>
        </div>
    </div>
@endsection
