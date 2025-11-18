@extends('layouts.admin')

@section('title', $user->nama . ' - Pengguna')
@section('page_title', $user->nama)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></li>
    <li class="breadcrumb-item active">{{ $user->nama }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Detail Pengguna</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3>{{ $user->nama }}</h3>
                    <p><strong>Username:</strong> {{ $user->username }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>No. HP:</strong> {{ $user->no_hp ?? '-' }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                    <p><strong>Status:</strong> @if($user->status) <span class="badge bg-success">Aktif</span> @else <span class="badge bg-secondary">Nonaktif</span> @endif</p>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary w-100 mb-2"><i class="fas fa-edit"></i> Edit</a>
                    <form action="{{ route('users.reset-password', $user) }}" method="POST">
                        @csrf
                        <button class="btn btn-warning w-100">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
