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
        Schema::table('transactions', function (Blueprint $table) {
            // Add pelanggan_id after cashier_id (for organization)
            // We make it nullable because walk-in customers might not be registered
            // constrained('pelanggans') assumes your customers table is named 'pelanggans'
            $table->foreignId('pelanggan_id')
                  ->nullable()
                  ->after('cashier_id')
                  ->constrained('pelanggans')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop foreign key first, then the column
            $table->dropForeign(['pelanggan_id']);
            $table->dropColumn('pelanggan_id');
        });
    }
};
