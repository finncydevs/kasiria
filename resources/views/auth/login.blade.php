<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kasiria</title>

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
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--light-blue) 100%);
            color: var(--white);
            padding: 3rem 2rem;
            text-align: center;
        }

        .login-header .logo {
            width: 70px;
            height: 70px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 35px;
            margin: 0 auto 1rem;
        }

        .login-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }

        .login-header p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0;
        }

        .login-body {
            padding: 2.5rem 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-gray);
            border-radius: 8px;
            font-size: 0.95rem;
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

        .form-check {
            margin-bottom: 1.5rem;
        }

        .form-check input {
            width: auto;
            margin-right: 0.5rem;
        }

        .form-check label {
            margin-bottom: 0;
            font-weight: normal;
        }

        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background-color: var(--light-blue);
            border: none;
            color: var(--white);
            font-weight: 600;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 1rem;
        }

        .btn-login:hover {
            background-color: var(--primary-blue);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            padding-bottom: 0;
            margin-top: 1.5rem;
            border-top: 1px solid var(--border-gray);
            padding-top: 1.5rem;
        }

        .login-footer p {
            color: #6b7280;
            font-size: 0.9rem;
            margin: 0;
        }

        .login-footer a {
            color: var(--light-blue);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: var(--primary-blue);
        }

        .error-message {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
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
            font-size: 0.9rem;
        }

        @media (max-width: 480px) {
            .login-card {
                border-radius: 10px;
            }

            .login-header {
                padding: 2rem 1.5rem;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }

            .login-body {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">K</div>
                <h1>Kasiria</h1>
                <p>Sistem Manajemen Kasir Terintegrasi</p>
            </div>

            <div class="login-body">
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

                <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label for="username">Username atau Email</label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Masukkan username atau email Anda"
                            value="{{ old('username') }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password Anda"
                            required
                        >
                    </div>

                    <div class="form-check">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            value="1"
                        >
                        <label for="remember" class="form-check-label">
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                </form>

                <div class="login-footer">
                    <p>Belum memiliki akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem; color: var(--white); font-size: 0.9rem;">
            <p>&copy; 2025 Kasiria. All rights reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
