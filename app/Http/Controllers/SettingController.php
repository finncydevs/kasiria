<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SettingController extends Controller
{
    public function __construct()
    {
        // OTORISASI: Hanya izinkan role 'admin' atau 'owner' mengakses controller ini
        // Method 'middleware' seharusnya tersedia dari warisan class Controller
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            // Menggunakan array untuk pengecekan role yang lebih aman dan eksplisit
            if (!in_array($user->role, ['admin', 'owner'])) {
                // Jika tidak memiliki role yang diizinkan, kembalikan ke dashboard dengan pesan error
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke Pengaturan.');
            }
            return $next($request);
        });
    }

    /**
     * Display settings page.
     */
    public function index()
    {
        // Data dummy untuk view
        $settings = [
            'app_name' => config('app.name', 'Kasiria'),
            'app_description' => 'Sistem Manajemen Kasir Terintegrasi',
            'currency' => 'IDR',
            'decimal_places' => 2,
            'tax_rate' => 0,
        ];

        return view('settings.index', compact('settings'));
    }

    /**
     * Update application settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'tax_rate' => 'required|numeric|min:0|max:100',
        ]);

        // Logika untuk update konfigurasi aplikasi

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    /**
     * Create database backup.
     */
    public function backup()
    {
        try {
            // Logika backup
            return back()->with('success', 'Backup database berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membuat backup: ' . $e->getMessage());
        }
    }
}
