<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;


class PelangganController extends Controller
{
    /**
     * Display a listing of pelanggans.
     */
    public function index()
    {
        $pelanggans = Pelanggan::query()
            ->when(request('search'), function ($query) {
                $search = request('search');
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->when(request('status'), function ($query) {
                if (request('status') === 'active') {
                    $query->active();
                } elseif (request('status') === 'inactive') {
                    $query->inactive();
                }
            })
            ->when(request('level'), function ($query) {
                $query->byLevel(request('level'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pelanggans.index', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new pelanggan.
     */
    public function create()
    {
        return view('pelanggans.create');
    }

    /**
     * Store a newly created pelanggan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255|unique:pelanggans,email',
            'member_level' => 'nullable|string|max:100',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        Pelanggan::create($validated);

        return redirect()->route('pelanggans.index')
            ->with('success', 'Pelanggan berhasil ditambahkan');
    }

    /**
     * Display the specified pelanggan.
     */
    public function show(Pelanggan $pelanggan)
    {
        $transactions = $pelanggan->transactions()
            ->with('cashier', 'items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pelanggans.show', compact('pelanggan', 'transactions'));
    }

    /**
     * Show the form for editing the specified pelanggan.
     */
    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggans.edit', compact('pelanggan'));
    }

    /**
     * Update the specified pelanggan in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255|unique:pelanggans,email,' . $pelanggan->id,
            'member_level' => 'nullable|string|max:100',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        $pelanggan->update($validated);

        return redirect()->route('pelanggans.show', $pelanggan)
            ->with('success', 'Pelanggan berhasil diubah');
    }

    /**
     * Remove the specified pelanggan from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('pelanggans.index')
            ->with('success', 'Pelanggan berhasil dihapus');
    }

    /**
     * Toggle pelanggan status.
     */
    public function toggleStatus(Pelanggan $pelanggan)
    {
        $pelanggan->update(['status' => !$pelanggan->status]);

        return redirect()->route('pelanggans.index')
            ->with('success', 'Status pelanggan berhasil diubah');
    }

    /**
     * Reset poin for pelanggan.
     */
    public function resetPoin(Pelanggan $pelanggan)
    {
        $pelanggan->update(['poin' => 0]);

        return redirect()->route('pelanggans.show', $pelanggan)
            ->with('success', 'Poin pelanggan berhasil direset');
    }
}
