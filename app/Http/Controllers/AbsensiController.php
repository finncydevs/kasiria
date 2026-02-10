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

        $karyawan = Karyawan::where('kode_karyawan', $request->kode_karyawan)->firstOrFail();
        $today = Carbon::today()->toDateString();
        $now = Carbon::now()->toTimeString();

        // Check existing attendance for today
        $absensi = Absensi::where('karyawan_id', $karyawan->id)
                          ->where('tanggal', $today)
                          ->first();

        if (!$absensi) {
            // Check In
            Absensi::create([
                'karyawan_id' => $karyawan->id,
                'tanggal' => $today,
                'jam_masuk' => $now,
                'status' => 'hadir',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Check In Berhasil!',
                'karyawan' => $karyawan->nama,
                'time' => $now,
                'type' => 'in'
            ]);
        } elseif ($absensi->jam_keluar == null) {
            // Check Out
            $absensi->update([
                'jam_keluar' => $now,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Check Out Berhasil!',
                'karyawan' => $karyawan->nama,
                'time' => $now,
                'type' => 'out'
            ]);
        } else {
            // Already Checked Out
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah melakukan Check Out hari ini.',
                'karyawan' => $karyawan->nama
            ], 400);
        }
    }
}
