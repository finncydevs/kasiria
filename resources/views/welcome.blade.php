<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Kasiria</title>

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

        .welcome-container {
            text-align: center;
            color: var(--white);
            padding: 2rem;
            max-width: 600px;
        }

        .welcome-logo {
            width: 120px;
            height: 120px;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 60px;
            margin: 0 auto 2rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .welcome-container h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .welcome-container p {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
            line-height: 1.6;
        }

        .welcome-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-welcome {
            padding: 0.9rem 2.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-login-welcome {
            background-color: var(--white);
            color: var(--primary-blue);
        }

        .btn-login-welcome:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            color: var(--primary-blue);
            text-decoration: none;
        }

        .btn-register-welcome {
            background-color: transparent;
            color: var(--white);
            border: 2px solid var(--white);
        }

        .btn-register-welcome:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            color: var(--white);
            text-decoration: none;
        }

        .features {
            margin-top: 4rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            opacity: 0.9;
        }

        .feature-item {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .feature-item i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .feature-item h3 {
            font-size: 0.95rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .welcome-container h1 {
                font-size: 2rem;
            }

            .welcome-container p {
                font-size: 1rem;
            }

            .welcome-buttons {
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn-welcome {
                width: 100%;
                justify-content: center;
            }

            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-logo">
            <i class="fas fa-cash-register"></i>
        </div>

        <h1>Kasiria</h1>
        <p>Sistem Manajemen Kasir Terintegrasi untuk Bisnis Anda</p>

        <div class="welcome-buttons">
            <a href="{{ route('login') }}" class="btn-welcome btn-login-welcome">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </a>
            <a href="{{ route('register') }}" class="btn-welcome btn-register-welcome">
                <i class="fas fa-user-plus"></i> Daftar
            </a>
        </div>

        <div class="features">
            <div class="feature-item">
                <i class="fas fa-shopping-cart"></i>
                <h3>Transaksi</h3>
            </div>
            <div class="feature-item">
                <i class="fas fa-box"></i>
                <h3>Inventori</h3>
            </div>
            <div class="feature-item">
                <i class="fas fa-chart-bar"></i>
                <h3>Laporan</h3>
            </div>
            <div class="feature-item">
                <i class="fas fa-users"></i>
                <h3>Manajemen</h3>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
