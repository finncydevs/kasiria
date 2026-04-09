<!DOCTYPE html>
<html>
<head>
    <title>Sistem Error Alert</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <h2 style="color: #d9534f;">Terjadi Error pada Aplikasi</h2>
    <p>Halo,</p>
    <p>Berikut adalah detail error yang baru saja terjadi:</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <th style="text-align: left; padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9; width: 120px;">Kode Error</th>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $exception->getCode() }}</td>
        </tr>
        <tr>
            <th style="text-align: left; padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;">Pesan Error</th>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>{{ $exception->getMessage() }}</strong></td>
        </tr>
        <tr>
            <th style="text-align: left; padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;">File</th>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $exception->getFile() }}</td>
        </tr>
        <tr>
            <th style="text-align: left; padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;">Baris</th>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $exception->getLine() }}</td>
        </tr>
        <tr>
            <th style="text-align: left; padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;">URL</th>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ request()->fullUrl() }}</td>
        </tr>
        <tr>
            <th style="text-align: left; padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;">Waktu</th>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ now()->format('Y-m-d H:i:s') }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 20px;">Stack Trace (Summary):</h3>
    <div style="background-color: #f4f4f4; padding: 10px; border: 1px solid #ccc; overflow-x: auto;">
        <pre style="font-size: 13px; margin: 0;">{{ \Illuminate\Support\Str::limit($exception->getTraceAsString(), 1500) }}</pre>
    </div>
</body>
</html>
