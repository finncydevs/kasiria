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
    Schema::create('transaksis', function (Blueprint $table) {
    $table->id('transaksi_id');
    $table->dateTime('tanggal');
    $table->bigInteger('kasir_id')->unsigned();
    $table->bigInteger('pelanggan_id')->unsigned();
    $table->decimal('total', 15, 2);
    $table->decimal('diskon', 15, 2)->default(0);
    $table->decimal('pajak', 15, 2)->default(0);
    $table->string('metode_bayar')->nullable();
    $table->decimal('nominal_bayar', 15, 2)->default(0);
    $table->decimal('kembalian', 15, 2)->default(0);
    $table->string('status')->default('selesai');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
