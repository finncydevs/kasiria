<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksis'; // Adjust to your migration table name

    // Usually details don't need a custom primary key, but if they do, add it here.

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaction::class, 'transaksi_id', 'transaksi_id');
    }

    public function produk()
    {
        // Assuming Product model uses standard 'id'
        return $this->belongsTo(Product::class, 'produk_id');
    }
}
