<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kasir', 'owner', 'pelanggan') DEFAULT 'kasir'");

        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('cashier_id')->nullable()->change();
            
            $table->foreignId('customer_user_id')->nullable()->after('cashier_id')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['customer_user_id']);
            $table->dropColumn('customer_user_id');
             $table->unsignedBigInteger('cashier_id')->nullable(false)->change();
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kasir', 'owner') DEFAULT 'kasir'");
    }
};
