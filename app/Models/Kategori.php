<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $primaryKey = 'kategori_id';
    public $timestamps = true;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    /**
     * Get the products for this category.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'kategori_id', 'kategori_id');
    }

    /**
     * Scope to get active categories.
     */
    public function scopeActive($query)
    {
        return $query;
    }

    /**
     * Get product count for this category.
     */
    public function getProductCountAttribute()
    {
        return $this->products()->count();
    }
}
