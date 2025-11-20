@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pengaturan</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-4">
        <h1 class="h3 text-dark fw-bold">
            <i class="fas fa-cog text-primary me-2"></i>Pengaturan Sistem
        </h1>
    </div>

    <!-- Alerts -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Kesalahan!</strong>
            <ul class="mb-0 ms-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Tabs Navigation -->
        <div class="col-lg-3 mb-3">
            <div class="list-group sticky-top" style="top: 20px;">
                <a href="#general" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                    <i class="fas fa-sliders-h me-2"></i>Umum
                </a>
                <a href="#system" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="fas fa-gears me-2"></i>Sistem
                </a>
                <a href="#security" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="fas fa-shield-alt me-2"></i>Keamanan
                </a>
                <a href="#backup" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="fas fa-database me-2"></i>Backup
                </a>
            </div>
        </div>

        <!-- Tabs Content -->
        <div class="col-lg-9">
            <div class="tab-content">
                <!-- General Settings -->
                <div class="tab-pane fade show active" id="general">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-sliders-h me-2"></i>Pengaturan Umum
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('settings.update') }}" method="POST">
                                @csrf

                                <!-- App Name -->
                                <div class="mb-3">
                                    <label for="app_name" class="form-label fw-bold">
                                        <i class="fas fa-building text-primary me-2"></i>Nama Aplikasi
                                    </label>
                                    <input type="text" class="form-control" id="app_name" name="app_name"
                                        value="{{ $settings['app_name'] ?? 'Kasiria' }}" required>
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="app_description" class="form-label fw-bold">
                                        <i class="fas fa-align-left text-info me-2"></i>Deskripsi
                                    </label>
                                    <textarea class="form-control" id="app_description" rows="3" readonly>{{ $settings['app_description'] ?? 'Sistem Manajemen Kasir Terintegrasi' }}</textarea>
                                </div>

                                <!-- Currency -->
                                <div class="mb-3">
                                    <label for="currency" class="form-label fw-bold">
                                        <i class="fas fa-dollar-sign text-success me-2"></i>Mata Uang
                                    </label>
                                    <input type="text" class="form-control" value="{{ $settings['currency'] ?? 'IDR' }}" readonly>
                                </div>

                                <!-- Tax Rate -->
                                <div class="mb-3">
                                    <label for="tax_rate" class="form-label fw-bold">
                                        <i class="fas fa-percent text-warning me-2"></i>Tarif Pajak (%)
                                    </label>
                                    <input type="number" step="0.01" class="form-control @error('tax_rate') is-invalid @enderror"
                                        id="tax_rate" name="tax_rate" value="{{ old('tax_rate', $settings['tax_rate'] ?? 0) }}" required>
                                    @error('tax_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- System Settings -->
                <div class="tab-pane fade" id="system">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-gears me-2"></i>Pengaturan Sistem
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Informasi Server</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="fw-bold">PHP Version:</td>
                                            <td>{{ phpversion() }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Laravel Version:</td>
                                            <td>{{ app()->version() }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Server Time:</td>
                                            <td>{{ date('d M Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">App Env:</td>
                                            <td>
                                                @if(app()->environment() === 'production')
                                                    <span class="badge bg-danger">Production</span>
                                                @else
                                                    <span class="badge bg-warning">{{ app()->environment() }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Database</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="fw-bold">Connection:</td>
                                            <td>{{ config('database.default') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Host:</td>
                                            <td>{{ config('database.connections.mysql.host') ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Database:</td>
                                            <td>{{ config('database.connections.mysql.database') ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Port:</td>
                                            <td>{{ config('database.connections.mysql.port') ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="tab-pane fade" id="security">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-shield-alt me-2"></i>Pengaturan Keamanan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Catatan Keamanan:</strong> Pastikan aplikasi selalu diperbarui dan backup database dilakukan secara berkala.
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-lock me-2"></i>Status Keamanan
                                    </h6>
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <span>HTTPS Status</span>
                                                @if(request()->secure())
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Aktif</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <span>Debug Mode</span>
                                                @if(config('app.debug'))
                                                    <span class="badge bg-warning">Aktif</span>
                                                @else
                                                    <span class="badge bg-success">Tidak Aktif</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <span>Authentication</span>
                                                <span class="badge bg-success">Aktif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-user-check me-2"></i>Akun Admin
                                    </h6>
                                    <div class="alert alert-warning">
                                        Untuk mengubah password, silakan pergi ke profil Anda.
                                    </div>
                                    <a href="{{ route('profile.show') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-user-cog me-2"></i>Ke Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Backup -->
                <div class="tab-pane fade" id="backup">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-database me-2"></i>Backup Database
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Rekomendasi:</strong> Lakukan backup database secara berkala untuk keamanan data Anda.
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-history me-2"></i>Backup Terakhir
                                    </h6>
                                    <div class="alert alert-secondary">
                                        Belum ada backup atau fitur backup tidak tersedia.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-download me-2"></i>Buat Backup
                                    </h6>
                                    <p class="text-muted small">Klik tombol di bawah untuk membuat backup database sekarang.</p>
                                    <form action="{{ route('settings.backup') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Buat backup database sekarang?')">
                                            <i class="fas fa-download me-2"></i>Buat Backup
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple tab switching
    document.querySelectorAll('[data-bs-toggle="list"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('[data-bs-toggle="list"]').forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            const tabId = this.getAttribute('href');
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
            document.querySelector(tabId).classList.add('show', 'active');
        });
    });
</script>
@endsection
