<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card - {{ $karyawan->nama }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f1f5f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .id-card {
            width: 320px;
            height: 480px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            height: 140px;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 60px;
            background: white;
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
            transform: scaleX(1.5);
        }

        .avatar {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            font-size: 40px;
            font-weight: bold;
            color: #3b82f6;
            z-index: 10;
        }

        .content {
            padding-top: 60px;
            padding-bottom: 20px;
        }

        .name {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            padding: 0 20px;
            line-height: 1.2;
        }

        .role {
            font-size: 16px;
            color: #64748b;
            margin-top: 5px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .qr-container {
            margin: 20px auto;
            padding: 10px;
            background: white;
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            width: 160px;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .code {
            font-family: monospace;
            font-size: 14px;
            color: #94a3b8;
            margin-top: 10px;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 15px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
        }

        .btn-print {
            margin-top: 30px;
            background: #3b82f6;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.5);
            transition: all 0.2s;
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.5);
        }

        @media print {
            body { background: white; -webkit-print-color-adjust: exact; }
            .btn-print { display: none; }
            .id-card { box-shadow: none; border: 1px solid #ccc; }
        }
    </style>
    <!-- QRCode.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>

    <div class="id-card">
        <div class="header">
            <div class="avatar">
                {{ strtoupper(substr($karyawan->nama, 0, 1)) }}
            </div>
        </div>
        
        <div class="content">
            <h1 class="name">{{ $karyawan->nama }}</h1>
            <div class="role">{{ $karyawan->jabatan }}</div>

            <div class="qr-container" id="qrcode"></div>
            
            <div class="code">{{ $karyawan->kode_karyawan }}</div>
        </div>

        <div class="footer">
            Kasiria Employee ID
        </div>
    </div>

    <button class="btn-print" onclick="window.print()">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2z"/>
        </svg>
        Print ID Card
    </button>

    <script type="text/javascript">
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ $karyawan->kode_karyawan }}",
            width: 140,
            height: 140,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    </script>

</body>
</html>
