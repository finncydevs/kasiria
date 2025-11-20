<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Pelanggan;
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
            'stok' => 100,
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
            'stok' => 150,
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
            'stok' => 50,
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
            'stok' => 200,
            'min_stock' => 30,
            'status' => true,
        ]);

        // Create sample customers
        Pelanggan::create([
            'nama' => 'Budi Santoso',
            'no_hp' => '081234567893',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            'email' => 'budi@email.com',
            'member_level' => 'Gold',
            'poin' => 150,
            'status' => true,
        ]);

        Pelanggan::create([
            'nama' => 'Rina Putri',
            'no_hp' => '081234567894',
            'alamat' => 'Jl. Sudirman No. 456, Jakarta',
            'email' => 'rina@email.com',
            'member_level' => 'Silver',
            'poin' => 75,
            'status' => true,
        ]);

        Pelanggan::create([
            'nama' => 'Hendra Gunawan',
            'no_hp' => '081234567895',
            'alamat' => 'Jl. Gatot Subroto No. 789, Jakarta',
            'email' => 'hendra@email.com',
            'member_level' => 'Platinum',
            'poin' => 300,
            'status' => true,
        ]);

        Pelanggan::create([
            'nama' => 'Dewi Lestari',
            'no_hp' => '081234567896',
            'alamat' => 'Jl. Ahmad Yani No. 321, Bandung',
            'email' => 'dewi@email.com',
            'member_level' => 'Bronze',
            'poin' => 25,
            'status' => true,
        ]);

        Pelanggan::create([
            'nama' => 'Agus Hermawan',
            'no_hp' => '081234567897',
            'alamat' => 'Jl. Diponegoro No. 654, Surabaya',
            'email' => 'agus@email.com',
            'member_level' => 'Gold',
            'poin' => 200,
            'status' => true,
        ]);
    }
}
