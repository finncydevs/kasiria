<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Product;
use App\Models\Pelanggan; // Import model Pelanggan
use App\Models\User;     // Import model User
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Import Hash untuk password

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Hapus data lama (opsional, untuk memastikan seeding bersih saat run berulang)
        // Kategori::truncate();
        // Product::truncate();
        // Pelanggan::truncate();
        // User::truncate();
        // DB::table('users')->delete();
        // DB::table('kategoris')->delete();
        // Dll. (Gunakan ini jika Anda ingin menjalankan seeder secara berulang tanpa fresh migrate)


        // ===========================================
        // 1. LOGIKA KATEGORI SEEDER
        // ===========================================
        
        Kategori::create(['nama_kategori' => 'Minuman']);
        Kategori::create(['nama_kategori' => 'Makanan']);
        Kategori::create(['nama_kategori' => 'Snack']);
        Kategori::create(['nama_kategori' => 'Peralatan']);


        // ===========================================
        // 2. LOGIKA PRODUK SEEDER
        // ===========================================

        // Ambil ID kategori yang baru saja dibuat.
        $kategoriMinuman = Kategori::where('nama_kategori', 'Minuman')->firstOrFail();
        $kategoriMakanan = Kategori::where('nama_kategori', 'Makanan')->firstOrFail();

        // 1. Kopi Arabika
        Product::create([
            'nama_produk' => 'Kopi Arabika',
            'kode_barcode' => 'PROD001',
            'kategori_id' => $kategoriMinuman->kategori_id,
            'deskripsi' => 'Kopi Arabika premium dari Indonesia',
            'harga_beli' => 15000,
            'harga_jual' => 25000,
            'stok' => 100,
            'satuan' => 'bungkus',
            'status' => true,
        ]);

        // 2. Teh Hijau
        Product::create([
            'nama_produk' => 'Teh Hijau',
            'kode_barcode' => 'PROD002',
            'kategori_id' => $kategoriMinuman->kategori_id,
            'deskripsi' => 'Teh hijau segar',
            'harga_beli' => 8000,
            'harga_jual' => 15000,
            'stok' => 150,
            'satuan' => 'kotak',
            'status' => true,
        ]);

        // 3. Roti Tawar
        Product::create([
            'nama_produk' => 'Roti Tawar',
            'kode_barcode' => 'PROD003',
            'kategori_id' => $kategoriMakanan->kategori_id,
            'deskripsi' => 'Roti tawar putih lembut',
            'harga_beli' => 12000,
            'harga_jual' => 20000,
            'stok' => 50,
            'satuan' => 'pcs',
            'status' => true,
        ]);

        // 4. Donat Coklat
        Product::create([
            'nama_produk' => 'Donat Coklat',
            'kode_barcode' => 'PROD004',
            'kategori_id' => $kategoriMakanan->kategori_id,
            'deskripsi' => 'Donat dengan topping coklat',
            'harga_beli' => 4000,
            'harga_jual' => 8000,
            'stok' => 200,
            'satuan' => 'pcs',
            'status' => true,
        ]);


        // ===========================================
        // 3. LOGIKA PELANGGAN SEEDER
        // ===========================================

        Pelanggan::create([
            'nama' => 'Budi Santoso',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'email' => 'budi@example.com',
            'member_level' => 'Gold',
            'poin' => 500,
        ]);

        Pelanggan::create([
            'nama' => 'Siti Aminah',
            'no_hp' => '087654321098',
            'alamat' => 'Perumahan Indah Blok C5, Bandung',
            'email' => 'siti@example.com',
            'member_level' => 'Silver',
            'poin' => 150,
        ]);

        Pelanggan::create([
            'nama' => 'Joko Susilo',
            'no_hp' => '085000111222',
            'alamat' => 'Kp. Durian Runtuh, Surabaya',
            'email' => 'joko@example.com',
            'member_level' => 'Bronze',
            'poin' => 50,
        ]);

        // 1. User Admin (Akses Penuh)
        User::create([
            'nama' => 'Super Admin',
            'username' => 'admin',
            'email' => 'admin@kasiria.com',
            'password' => Hash::make('password'), // Password: password
            'role' => 'admin',
            'no_hp' => '081122334455',
            'status' => true,
        ]);

        // 2. User Owner (Akses Penuh, untuk Laporan & Bisnis)
        User::create([
            'nama' => 'Pemilik Toko',
            'username' => 'owner',
            'email' => 'owner@kasiria.com',
            'password' => Hash::make('password'), // Password: password
            'role' => 'owner',
            'no_hp' => '081199887766',
            'status' => true,
        ]);

        // 3. User Kasir (Akses Terbatas ke Transaksi)
        User::create([
            'nama' => 'Kasir Utama',
            'username' => 'kasir',
            'email' => 'kasir@kasiria.com',
            'password' => Hash::make('password'), // Password: password
            'role' => 'kasir',
            'no_hp' => '085544332211',
            'status' => true,
        ]);
    }
}
