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
  Schema::create('detail_transaksis', function (Blueprint $table) {
    $table->id('detail_id');
    $table->bigInteger('transaksi_id')->unsigned();
    $table->bigInteger('produk_id')->unsigned();
    $table->integer('jumlah');
    $table->decimal('harga_satuan', 15, 2);
    $table->decimal('subtotal', 15, 2);
    $table->decimal('diskon_item', 15, 2)->default(0);
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
