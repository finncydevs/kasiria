<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::with('kategori')
            ->when(request('search'), function ($query) {
                $search = request('search');
                $query->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('kode_barcode', 'like', "%{$search}%");
            })
            ->paginate(20);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $kategoris = Kategori::active()->orderBy('nama_kategori')->get();
        return view('products.create', compact('kategoris'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kode_barcode' => 'required|string|max:255|unique:produks',
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'satuan' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load('kategori');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $kategoris = Kategori::active()->orderBy('nama_kategori')->get();
        $product->load('kategori');
        return view('products.edit', compact('product', 'kategoris'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kode_barcode' => 'required|string|max:255|unique:produks,kode_barcode,' . $product->id,
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'satuan' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        $product->update($validated);

        return redirect()->route('products.show', $product)->with('success', 'Produk berhasil diubah.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Toggle product status (active/inactive).
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['status' => !$product->status]);
        return back()->with('success', 'Status produk berhasil diubah.');
    }

    /**
     * View stock history for a product.
     */
    public function stockHistory(Product $product)
    {
        $history = $product->transactionItems()->with('transaction')->paginate(20);
        return view('products.stock-history', compact('product', 'history'));
    }
}
