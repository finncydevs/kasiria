<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
        'email',
        'member_level',
        'poin',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'poin' => 'integer',
    ];

    /**
     * Get the transactions for this pelanggan (by customer name).
     * Note: Transactions use customer_name string, not customer_id foreign key
     */
    public function transactions()
    {
        return Transaction::where('customer_name', $this->nama)->orderBy('created_at', 'desc');
    }

    /**
     * Scope to filter by status.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    /**
     * Scope to filter by member level.
     */
    public function scopeByLevel($query, $level)
    {
        return $query->where('member_level', $level);
    }

    /**
     * Get total transactions for this customer.
     */
    public function getTotalTransactionsAttribute()
    {
        return Transaction::where('customer_name', $this->nama)
            ->where('deleted_at', null)
            ->count();
    }

    /**
     * Get total spending for this customer.
     */
    public function getTotalSpendingAttribute()
    {
        return Transaction::where('customer_name', $this->nama)
            ->where('deleted_at', null)
            ->sum('total');
    }

    /**
     * Check if customer is active.
     */
    public function isActive()
    {
        return $this->status;
    }

    /**
     * Add poin to customer.
     */
    public function addPoin($amount)
    {
        $this->increment('poin', $amount);
    }

    /**
     * Deduct poin from customer.
     */
    public function usePoin($amount)
    {
        if ($this->poin >= $amount) {
            $this->decrement('poin', $amount);
            return true;
        }
        return false;
    }
}
