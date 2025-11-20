<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of kategoris.
     */
    public function index()
    {
        $kategoris = Kategori::query()
            ->when(request('search'), function ($query) {
                $search = request('search');
                $query->where('nama_kategori', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('kategoris.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new kategori.
     */
    public function create()
    {
        return view('kategoris.create');
    }

    /**
     * Store a newly created kategori in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        Kategori::create($validated);

        return redirect()->route('kategoris.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified kategori.
     */
    public function show(Kategori $kategori)
    {
        $products = $kategori->products()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('kategoris.show', compact('kategori', 'products'));
    }

    /**
     * Show the form for editing the specified kategori.
     */
    public function edit(Kategori $kategori)
    {
        return view('kategoris.edit', compact('kategori'));
    }

    /**
     * Update the specified kategori in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->kategori_id . ',kategori_id',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategoris.show', $kategori)
            ->with('success', 'Kategori berhasil diubah');
    }

    /**
     * Remove the specified kategori from storage.
     */
    public function destroy(Kategori $kategori)
    {
        // Check if category has products
        if ($kategori->products()->count() > 0) {
            return redirect()->route('kategoris.index')
                ->with('error', 'Tidak dapat menghapus kategori yang masih memiliki produk');
        }

        $kategori->delete();

        return redirect()->route('kategoris.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
