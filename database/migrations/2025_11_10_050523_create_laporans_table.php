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
     Schema::create('laporans', function (Blueprint $table) {
    $table->id('laporan_id');
    $table->string('periode');
    $table->integer('total_transaksi')->default(0);
    $table->decimal('total_penjualan', 15, 2)->default(0);
    $table->integer('total_produk_terjual')->default(0);
    $table->decimal('laba_bersih', 15, 2)->default(0);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
