@extends('layouts.app')

@section('title', 'Profil Saya - Kasiria')
@section('page_title', 'Profil Saya')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Profil
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="glass-panel text-center">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-4xl shadow-xl shadow-blue-500/20 mx-auto mb-4">
                    {{ substr($user->nama, 0, 1) }}
                </div>
                <h3 class="text-xl font-bold text-white mb-1">{{ $user->nama }}</h3>
                <p class="text-slate-400 text-sm mb-4">{{ ucfirst($user->role) }}</p>
                
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-xs font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 mr-2 animate-pulse"></span>
                    Aktif
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="glass-panel">
                <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                    <i class="fas fa-user-edit text-blue-400"></i> Edit Profil
                </h2>

                @if(session('success'))
                    <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl">
                        <ul class="mb-0 list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Nama Lengkap</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-user"></i></span>
                                <input type="text" name="nama" class="glass-input w-full pl-10" value="{{ old('nama', $user->nama) }}" required maxlength="50">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="glass-input w-full pl-10" value="{{ old('email', $user->email) }}" required maxlength="100">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">No. HP</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500"><i class="fas fa-phone"></i></span>
                                <input type="text" name="no_hp" class="glass-input w-full pl-10" value="{{ old('no_hp', $user->no_hp) }}" maxlength="20">
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-white/10 flex gap-3">
                            <button type="submit" class="glass-btn bg-blue-600/80 hover:bg-blue-600 text-white px-6 py-2.5 shadow-lg shadow-blue-500/20">
                                <i class="fas fa-save mr-2"></i> Simpan
                            </button>
                            <a href="{{ route('dashboard') }}" class="glass-btn bg-white/5 hover:bg-white/10 text-slate-300 px-6 py-2.5">
                                <i class="fas fa-times mr-2"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
