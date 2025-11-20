<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produks';
    public $timestamps = true;

    protected $fillable = [
        'nama_produk',
        'kode_barcode',
        'kategori_id',
        'harga_beli',
        'harga_jual',
        'stok',
        'satuan',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'status' => 'boolean',
    ];

    /**
     * Get the category for this product.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    /**
     * Get the transactions for this product.
     */
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'product_id', 'id');
    }

    /**
     * Check if stock is low.
     */
    public function isLowStock()
    {
        return $this->stok <= 10; // Default minimum
    }

    /**
     * Calculate profit margin.
     */
    public function getProfitMargin()
    {
        if ($this->harga_beli == 0) return 0;
        return (($this->harga_jual - $this->harga_beli) / $this->harga_beli) * 100;
    }

    /**
     * Scope active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope by category.
     */
    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }
}
