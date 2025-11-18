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
   Schema::create('stok_logs', function (Blueprint $table) {
    $table->id('stok_id');
    $table->bigInteger('produk_id')->unsigned();
    $table->dateTime('tanggal');
    $table->enum('tipe', ['masuk', 'keluar']);
    $table->integer('jumlah');
    $table->string('sumber')->nullable();
    $table->string('keterangan')->nullable();
    $table->bigInteger('user_id')->unsigned();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_logs');
    }
};
