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
        // 1. Modify users table role enum
        // Since Doctrine DBAL enum support is tricky, we use raw SQL for SQLite/MySQL compatibility if possible,
        // or just recreate the column. For simplicity in Laravel migrations with SQLite (common in dev often),
        // we might not be using SQLite here. This looks like MySQL based on previous context (file paths usually imply linux dev env).
        
        // We will try a safe approach: change the column definition if possible, or use raw SQL.
        // Assuming MySQL/MariaDB for "enum" type.
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kasir', 'owner', 'pelanggan') DEFAULT 'kasir'");

        // 2. Modify transactions table
        Schema::table('transactions', function (Blueprint $table) {
            // Make cashier_id nullable because self-service orders won't have a cashier initially
            $table->unsignedBigInteger('cashier_id')->nullable()->change();
            
            // Add customer_user_id to track which registered user made the order
            // We use a different name than 'pelanggan_id' to differentiate from the 'pelanggans' table (CRM contacts)
            // But wait, if we want to link to 'users' table, we should use 'user_id' or 'customer_user_id'.
            // Let's use 'customer_user_id' to be explicit it links to users table.
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

        // Reverting enum is risky if data exists, but for down:
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kasir', 'owner') DEFAULT 'kasir'");
    }
};
