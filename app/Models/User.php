<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'password',
        'role', // admin, kasir, owner, pelanggan
        'no_hp',
        'status',
        'points',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
            'points' => 'integer',
        ];
    }

    /**
     * Get transactions for this user (cashier).
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'cashier_id');
    }

    /**
     * Get point transactions for this user.
     */
    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    /**
     * Add points to user.
     */
    public function addPoints(int $amount, string $description = null)
    {
        $this->increment('points', $amount);
        
        $this->pointTransactions()->create([
            'amount' => $amount,
            'type' => 'earn',
            'description' => $description,
        ]);
    }

    /**
     * Redeem points from user.
     */
    public function redeemPoints(int $amount, string $description = null)
    {
        if ($this->points < $amount) {
            throw new \Exception('Insufficient points');
        }

        $this->decrement('points', $amount);
        
        $this->pointTransactions()->create([
            'amount' => -$amount,
            'type' => 'redeem',
            'description' => $description,
        ]);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is cashier.
     */
    public function isCashier()
    {
        return $this->role === 'kasir';
    }

    /**
     * Check if user is pelanggan.
     */
    public function isPelanggan()
    {
        return $this->role === 'pelanggan';
    }

    /**
     * Get orders made by this user (pelanggan).
     */
    public function orders()
    {
        return $this->hasMany(Transaction::class, 'customer_user_id');
    }

    /**
     * Scope active users.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope by role.
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }
}
