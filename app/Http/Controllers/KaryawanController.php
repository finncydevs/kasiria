<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Support\Str;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = Karyawan::with('user')->get();
        return view('karyawans.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereDoesntHave('karyawan')->get(); // Users not yet linked to a karyawan
        return view('karyawans.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'user_id' => 'nullable|exists:users,id|unique:karyawans,user_id',
        ]);

        $kode_karyawan = 'KRY-' . strtoupper(Str::random(6));
        // Ensure uniqueness
        while (Karyawan::where('kode_karyawan', $kode_karyawan)->exists()) {
            $kode_karyawan = 'KRY-' . strtoupper(Str::random(6));
        }

        Karyawan::create([
            'nama' => $request->nama,
            'kode_karyawan' => $kode_karyawan,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('karyawans.index')->with('success', 'Karyawan berhasil ditambahkan. Kode: ' . $kode_karyawan);
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        return view('karyawans.show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $users = User::whereDoesntHave('karyawan')->orWhere('id', $karyawan->user_id)->get();
        return view('karyawans.edit', compact('karyawan', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'user_id' => 'nullable|exists:users,id|unique:karyawans,user_id,' . $karyawan->id,
        ]);

        $karyawan->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('karyawans.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawans.index')->with('success', 'Karyawan berhasil dihapus.');
    }

    public function printQr(Karyawan $karyawan)
    {
        return view('karyawans.print_qr', compact('karyawan'));
    }
}
