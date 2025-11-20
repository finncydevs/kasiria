@extends('layouts.admin')

@section('title', 'Tambah Pelanggan')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pelanggans.index') }}">Data Pelanggan</a></li>
            <li class="breadcrumb-item active">Tambah Pelanggan</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-4">
        <h1 class="h3 text-dark fw-bold">
            <i class="fas fa-user-plus text-primary me-2"></i>Tambah Pelanggan Baru
        </h1>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('pelanggans.store') }}" method="POST">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-bold">
                                <i class="fas fa-user text-primary me-2"></i>Nama Pelanggan
                            </label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                id="nama" name="nama" placeholder="Masukkan nama pelanggan"
                                value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">
                                <i class="fas fa-envelope text-info me-2"></i>Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="contoh@email.com"
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No HP -->
                        <div class="mb-3">
                            <label for="no_hp" class="form-label fw-bold">
                                <i class="fas fa-phone text-success me-2"></i>No HP
                            </label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                id="no_hp" name="no_hp" placeholder="08123456789"
                                value="{{ old('no_hp') }}">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-bold">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>Alamat
                            </label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                id="alamat" name="alamat" rows="3"
                                placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Member Level -->
                        <div class="mb-3">
                            <label for="member_level" class="form-label fw-bold">
                                <i class="fas fa-medal text-warning me-2"></i>Member Level
                            </label>
                            <select class="form-select @error('member_level') is-invalid @enderror"
                                id="member_level" name="member_level">
                                <option value="">-- Pilih Level --</option>
                                <option value="Bronze" @if(old('member_level') === 'Bronze') selected @endif>Bronze</option>
                                <option value="Silver" @if(old('member_level') === 'Silver') selected @endif>Silver</option>
                                <option value="Gold" @if(old('member_level') === 'Gold') selected @endif>Gold</option>
                                <option value="Platinum" @if(old('member_level') === 'Platinum') selected @endif>Platinum</option>
                            </select>
                            @error('member_level')
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
                            <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">
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
                            <strong>Member Level:</strong><br>
                            <small class="text-muted">Bronze → Silver → Gold → Platinum</small>
                        </li>
                        <li class="mb-2">
                            <strong>Status Aktif:</strong><br>
                            <small class="text-muted">Pelanggan aktif dapat melakukan transaksi</small>
                        </li>
                        <li>
                            <strong>Email & No HP:</strong><br>
                            <small class="text-muted">Opsional, gunakan untuk kontak pelanggan</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
