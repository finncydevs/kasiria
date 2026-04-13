<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        
        $absensis = Absensi::with('karyawan')
                    ->whereDate('tanggal', $date)
                    ->orderBy('jam_masuk', 'desc')
                    ->get();

        return view('absensis.index', compact('absensis', 'date'));
    }

    public function scan()
    {
        return view('absensis.scan');
    }

    public function storeScan(Request $request)
    {
        $request->validate([
            'kode_karyawan' => 'required|exists:karyawans,kode_karyawan',
        ]);

        // --- Load absensi schedule settings ---
        $settingsMap = \App\Models\Setting::whereIn('key', [
            'absensi_jam_masuk',
            'absensi_jam_pulang',
            'absensi_batas_terlambat',
            'absensi_hari_kerja',
        ])->pluck('value', 'key');

        $jamMasuk       = $settingsMap['absensi_jam_masuk']       ?? '08:00';
        $jamPulang      = $settingsMap['absensi_jam_pulang']      ?? '17:00';
        $batasTerlambat = (int) ($settingsMap['absensi_batas_terlambat'] ?? 15);
        $hariKerjaStr   = $settingsMap['absensi_hari_kerja']      ?? 'Senin,Selasa,Rabu,Kamis,Jumat';
        $hariKerjaArr   = array_filter(array_map('trim', explode(',', $hariKerjaStr)));

        // Map Carbon day names (in Indonesian) to check today
        $hariIniMap = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];
        $hariIni = $hariIniMap[Carbon::now()->dayOfWeek];

        // --- Reject if today is not a work day ---
        if (!empty($hariKerjaArr) && !in_array($hariIni, $hariKerjaArr)) {
            return response()->json([
                'status'  => 'error',
                'message' => "Hari ini ({$hariIni}) bukan hari kerja.",
            ], 400);
        }

        $karyawan = Karyawan::where('kode_karyawan', $request->kode_karyawan)->firstOrFail();
        $today    = Carbon::today()->toDateString();
        $now      = Carbon::now()->toTimeString();

        // Check existing attendance for today
        $absensi = Absensi::where('karyawan_id', $karyawan->id)
                          ->where('tanggal', $today)
                          ->first();

        if (!$absensi) {
            // --- Determine check-in status ---
            $batasJam = Carbon::createFromFormat('H:i', $jamMasuk)->addMinutes($batasTerlambat);
            $status   = Carbon::now()->greaterThan($batasJam) ? 'terlambat' : 'hadir';

            Absensi::create([
                'karyawan_id' => $karyawan->id,
                'tanggal'     => $today,
                'jam_masuk'   => $now,
                'status'      => $status,
            ]);

            $label = $status === 'terlambat' ? 'Check In (Terlambat)' : 'Check In';

            return response()->json([
                'status'   => 'success',
                'message'  => "{$label} Berhasil!",
                'karyawan' => $karyawan->nama,
                'time'     => $now,
                'type'     => 'in',
                'late'     => $status === 'terlambat',
            ]);
        } elseif ($absensi->jam_keluar == null) {
            // Check Out
            $absensi->update([
                'jam_keluar' => $now,
            ]);

            return response()->json([
                'status'   => 'success',
                'message'  => 'Check Out Berhasil!',
                'karyawan' => $karyawan->nama,
                'time'     => $now,
                'type'     => 'out'
            ]);
        } else {
            // Already Checked Out
            return response()->json([
                'status'   => 'error',
                'message'  => 'Anda sudah melakukan Check Out hari ini.',
                'karyawan' => $karyawan->nama
            ], 400);
        }
    }
}
