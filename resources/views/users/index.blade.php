@extends('layouts.app')

@section('title', 'Daftar Pengguna - Kasiria')
@section('page_title', 'Manajemen Pengguna')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Pengguna
    </li>
@endsection

@section('content')
    <div class="glass-panel">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-xl font-semibold text-white">Daftar Pengguna</h2>
                <p class="text-slate-400 text-sm mt-1">Kelola data pengguna, peran, dan status akun.</p>
            </div>
            
            <a href="{{ route('users.create') }}" class="glass-btn flex items-center gap-2">
                <i class="fas fa-user-plus"></i> <span>Tambah Pengguna</span>
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-xl border border-white/10">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-xs text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Nama</th>
                        <th class="p-4">Username</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-blue-500/20">
                                        {{ substr($user->nama, 0, 1) }}
                                    </div>
                                    <a href="{{ route('users.show', $user) }}" class="font-medium text-white group-hover:text-blue-400 transition-colors">
                                        {{ $user->nama }}
                                    </a>
                                </div>
                            </td>
                            <td class="p-4 text-slate-300">{{ $user->username }}</td>
                            <td class="p-4 text-slate-300">{{ $user->email }}</td>
                            <td class="p-4">
                                @php
                                    $roleColor = match($user->role) {
                                        'admin' => 'text-purple-400 bg-purple-500/10 border-purple-500/20',
                                        'owner' => 'text-amber-400 bg-amber-500/10 border-amber-500/20',
                                        default => 'text-blue-400 bg-blue-500/10 border-blue-500/20'
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-medium border {{ $roleColor }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if($user->status)
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center gap-1 w-fit">
                                        <i class="fas fa-check-circle text-[10px]"></i> Aktif
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20 flex items-center gap-1 w-fit">
                                        <i class="fas fa-times-circle text-[10px]"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('users.edit', $user) }}" class="p-2 rounded-lg hover:bg-white/10 text-yellow-400 transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.toggle-status', $user) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button class="p-2 rounded-lg hover:bg-white/10 text-slate-300 transition-colors" title="Toggle Status">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirmSubmit(event, 'Hapus pengguna ini? Akses mereka akan dicabut segera.', 'Hapus Pengguna', 'delete')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 rounded-lg hover:bg-red-500/10 text-red-400 transition-colors" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-users text-4xl mb-3 opacity-20"></i>
                                    <p>Belum ada pengguna terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
@endsection
