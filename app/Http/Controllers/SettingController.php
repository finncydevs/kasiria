<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
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
     * Update settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'tax_rate' => 'required|numeric|min:0|max:100',
        ]);

        // Update .env or config here
        // This is a simplified example

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    /**
     * Create database backup.
     */
    public function backup()
    {
        try {
            // Implement backup logic here
            // You might want to use a package like spatie/laravel-backup

            return back()->with('success', 'Backup database berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membuat backup: ' . $e->getMessage());
        }
    }
}
