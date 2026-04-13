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
        // Ambil semua setting dari database
        $settingsCollection = \App\Models\Setting::all();
        $settings = [];
        
        // Map ke array assosiatif untuk kemudahan akses di view
        foreach($settingsCollection as $setting) {
            $settings[$setting->key] = $setting->value;
        }

        // Default values jika belum ada di database
        $defaults = [
            'app_name'                => config('app.name', 'Kasiria'),
            'app_description'         => 'Sistem Manajemen Kasir Terintegrasi',
            'currency'                => 'IDR',
            'decimal_places'          => 2,
            'tax_rate'                => 0,
            // Absensi defaults
            'absensi_jam_masuk'       => '08:00',
            'absensi_jam_pulang'      => '17:00',
            'absensi_batas_terlambat' => 15,
            'absensi_hari_kerja'      => 'Senin,Selasa,Rabu,Kamis,Jumat',
        ];

        $settings = array_merge($defaults, $settings);

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

        // Simpan ke database
        \App\Models\Setting::updateOrCreate(
            ['key' => 'app_name'],
            ['value' => $validated['app_name']]
        );

        \App\Models\Setting::updateOrCreate(
            ['key' => 'tax_rate'],
            ['value' => $validated['tax_rate']]
        );

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    /**
     * Update attendance (absensi) schedule settings.
     */
    public function updateAbsensi(Request $request)
    {
        $validated = $request->validate([
            'absensi_jam_masuk'       => 'required|date_format:H:i',
            'absensi_jam_pulang'      => 'required|date_format:H:i|after:absensi_jam_masuk',
            'absensi_batas_terlambat' => 'required|integer|min:0|max:120',
            'absensi_hari_kerja'      => 'nullable|array',
            'absensi_hari_kerja.*'    => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        ]);

        $hariKerja = isset($validated['absensi_hari_kerja'])
            ? implode(',', $validated['absensi_hari_kerja'])
            : '';

        \App\Models\Setting::updateOrCreate(
            ['key' => 'absensi_jam_masuk'],
            ['value' => $validated['absensi_jam_masuk']]
        );
        \App\Models\Setting::updateOrCreate(
            ['key' => 'absensi_jam_pulang'],
            ['value' => $validated['absensi_jam_pulang']]
        );
        \App\Models\Setting::updateOrCreate(
            ['key' => 'absensi_batas_terlambat'],
            ['value' => $validated['absensi_batas_terlambat']]
        );
        \App\Models\Setting::updateOrCreate(
            ['key' => 'absensi_hari_kerja'],
            ['value' => $hariKerja]
        );

        return back()->with('success', 'Pengaturan absensi berhasil disimpan.')
                     ->with('active_tab', 'absensi');
    }

    /**
     * Create database backup.
     */
    public function backup()
    {
        try {
            $filename = 'backup-kasiria-' . date('Y-m-d_H-i-s') . '.sql';
            $path = storage_path('app/backups/' . $filename);
            
            // Ensure backup directory exists
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            // Database configuration
            $dbName = config('database.connections.mysql.database');
            $dbUser = config('database.connections.mysql.username');
            $dbPass = config('database.connections.mysql.password');
            $dbHost = config('database.connections.mysql.host');

            // Build mysqldump command
            // Note: Using --no-tablespaces to avoid privilege errors on some restrictive hosts
            $command = "mysqldump --user=" . escapeshellarg($dbUser) . 
                       " --password=" . escapeshellarg($dbPass) . 
                       " --host=" . escapeshellarg($dbHost) . 
                       " " . escapeshellarg($dbName) . " > " . escapeshellarg($path);

            $returnVar = null;
            $output = null;

            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                throw new \Exception("mysqldump failed with exit code $returnVar");
            }

            return response()->download($path)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membuat backup: ' . $e->getMessage());
        }
    }
}
