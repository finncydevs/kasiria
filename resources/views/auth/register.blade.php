<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Kasiria</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-blue: #1e40af;
            --light-blue: #3b82f6;
            --darker-blue: #1e3a8a;
            --white: #ffffff;
            --light-gray: #f8fafc;
            --border-gray: #e2e8f0;
            --text-dark: #1f2937;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--light-blue) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 500px;
        }

        .register-card {
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--light-blue) 100%);
            color: var(--white);
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .register-header .logo {
            width: 60px;
            height: 60px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 30px;
            margin: 0 auto 1rem;
        }

        .register-header h1 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }

        .register-header p {
            font-size: 0.85rem;
            opacity: 0.9;
            margin: 0;
        }

        .register-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.65rem 0.85rem;
            border: 2px solid var(--border-gray);
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            color: var(--text-dark);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--light-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group input::placeholder {
            color: #9ca3af;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .btn-register {
            width: 100%;
            padding: 0.8rem;
            background-color: var(--light-blue);
            border: none;
            color: var(--white);
            font-weight: 600;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-top: 0.5rem;
        }

        .btn-register:hover {
            background-color: var(--primary-blue);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        }

        .register-footer {
            text-align: center;
            padding-bottom: 0;
            margin-top: 1.25rem;
            border-top: 1px solid var(--border-gray);
            padding-top: 1.25rem;
        }

        .register-footer p {
            color: #6b7280;
            font-size: 0.85rem;
            margin: 0;
        }

        .register-footer a {
            color: var(--light-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .register-footer a:hover {
            color: var(--primary-blue);
        }

        .error-message {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }

        .error-message ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        .error-message li {
            margin-bottom: 0.25rem;
        }

        .success-message {
            background-color: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }

        @media (max-width: 480px) {
            .register-card {
                border-radius: 10px;
            }

            .register-header {
                padding: 1.75rem 1.5rem;
            }

            .register-header h1 {
                font-size: 1.3rem;
            }

            .register-body {
                padding: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="logo">K</div>
                <h1>Daftar Akun</h1>
                <p>Buat akun baru untuk Kasiria</p>
            </div>

            <div class="register-body">
                @if ($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            placeholder="Contoh: Ahmad Wijaya"
                            value="{{ old('nama') }}"
                            required
                        >
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                placeholder="Username unik"
                                value="{{ old('username') }}"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="Email Anda"
                                value="{{ old('email') }}"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="no_hp">No. HP</label>
                        <input
                            type="text"
                            id="no_hp"
                            name="no_hp"
                            placeholder="Nomor telepon (opsional)"
                            value="{{ old('no_hp') }}"
                        >
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Minimal 8 karakter"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi password"
                                required
                            >
                        </div>
                    </div>

                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus"></i> Daftar
                    </button>
                </form>

                <div class="register-footer">
                    <p>Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 1.5rem; color: var(--white); font-size: 0.85rem;">
            <p>&copy; 2025 Kasiria. All rights reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
