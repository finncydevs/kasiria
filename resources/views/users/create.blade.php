@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></li>
            <li class="breadcrumb-item active">Tambah Pengguna</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-4">
        <h1 class="h3 text-dark fw-bold">
            <i class="fas fa-user-plus text-primary me-2"></i>Tambah Pengguna Baru
        </h1>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-bold">
                                <i class="fas fa-user text-primary me-2"></i>Nama Lengkap
                            </label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                id="nama" name="nama" placeholder="Masukkan nama lengkap"
                                value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">
                                <i class="fas fa-at text-info me-2"></i>Username
                            </label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" placeholder="username123"
                                value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">
                                <i class="fas fa-envelope text-success me-2"></i>Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="user@example.com"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No HP -->
                        <div class="mb-3">
                            <label for="no_hp" class="form-label fw-bold">
                                <i class="fas fa-phone text-warning me-2"></i>No HP
                            </label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                id="no_hp" name="no_hp" placeholder="081234567890"
                                value="{{ old('no_hp') }}">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label fw-bold">
                                <i class="fas fa-shield-alt text-danger me-2"></i>Role
                            </label>
                            <select class="form-select @error('role') is-invalid @enderror"
                                id="role" name="role" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" @if(old('role') === 'admin') selected @endif>Admin</option>
                                <option value="kasir" @if(old('role') === 'kasir') selected @endif>Kasir</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">
                                <i class="fas fa-lock text-secondary me-2"></i>Password
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Masukkan password (minimal 8 karakter)"
                                required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">
                                <i class="fas fa-lock-open text-secondary me-2"></i>Konfirmasi Password
                            </label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation"
                                placeholder="Ketik ulang password" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status"
                                    value="1" @if(old('status', true)) checked @endif>
                                <label class="form-check-label fw-bold" for="status">
                                    <i class="fas fa-check-circle text-success me-2"></i>Aktif
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="col-lg-4">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-info-circle text-info me-2"></i>Informasi
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>Admin:</strong><br>
                            <small class="text-muted">Akses penuh ke sistem</small>
                        </li>
                        <li class="mb-2">
                            <strong>Kasir:</strong><br>
                            <small class="text-muted">Akses terbatas (transaksi saja)</small>
                        </li>
                        <li>
                            <strong>Password:</strong><br>
                            <small class="text-muted">Minimal 8 karakter, harus sama dengan konfirmasi</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
