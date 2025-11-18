<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('produks', function (Blueprint $table) {
    $table->id();
    $table->string('nama_produk');
    $table->string('kode_barcode')->unique();
    $table->bigInteger('kategori_id')->unsigned();
    $table->decimal('harga_beli', 15, 2);
    $table->decimal('harga_jual', 15, 2);
    $table->integer('stok')->default(0);
    $table->string('satuan', 50)->nullable();
    $table->text('deskripsi')->nullable();
    $table->string('gambar_url')->nullable();
    $table->boolean('status')->default(true);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
