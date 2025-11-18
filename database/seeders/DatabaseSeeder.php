<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'nama' => 'Admin Kasiria',
            'username' => 'admin',
            'email' => 'admin@kasiria.local',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'no_hp' => '081234567890',
            'status' => true,
        ]);

        // Create test cashier users
        User::create([
            'nama' => 'Ahmad Wijaya',
            'username' => 'ahmad_wijaya',
            'email' => 'ahmad@kasiria.local',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
            'no_hp' => '081234567891',
            'status' => true,
        ]);

        User::create([
            'nama' => 'Siti Nurhaliza',
            'username' => 'siti_nurhaliza',
            'email' => 'siti@kasiria.local',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
            'no_hp' => '081234567892',
            'status' => true,
        ]);

        // Create sample products
        Product::create([
            'name' => 'Kopi Arabika',
            'sku' => 'PROD001',
            'description' => 'Kopi Arabika premium dari Indonesia',
            'category' => 'Minuman',
            'price' => 25000,
            'cost' => 15000,
            'stock' => 100,
            'min_stock' => 10,
            'status' => true,
        ]);

        Product::create([
            'name' => 'Teh Hijau',
            'sku' => 'PROD002',
            'description' => 'Teh hijau segar',
            'category' => 'Minuman',
            'price' => 15000,
            'cost' => 8000,
            'stock' => 150,
            'min_stock' => 20,
            'status' => true,
        ]);

        Product::create([
            'name' => 'Roti Tawar',
            'sku' => 'PROD003',
            'description' => 'Roti tawar putih lembut',
            'category' => 'Makanan',
            'price' => 20000,
            'cost' => 12000,
            'stock' => 50,
            'min_stock' => 5,
            'status' => true,
        ]);

        Product::create([
            'name' => 'Donat Coklat',
            'sku' => 'PROD004',
            'description' => 'Donat dengan topping coklat',
            'category' => 'Makanan',
            'price' => 8000,
            'cost' => 4000,
            'stock' => 200,
            'min_stock' => 30,
            'status' => true,
        ]);
    }
}
