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
        Schema::table('transaction_items', function (Blueprint $table) {
            // Drop the foreign key to the 'products' table
            // We use the array syntax to let Laravel guess the index name if generic, 
            // but providing the exact string name is safer if we know it.
            // Based on error: transaction_items_product_id_foreign
            $table->dropForeign('transaction_items_product_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            // We cannot easily reverse this without knowing if 'products' table exists 
            // and has the right data, so we leave it empty or try to re-add.
            // For now, leaving empty as this is a fix for a mismatch.
        });
    }
};
