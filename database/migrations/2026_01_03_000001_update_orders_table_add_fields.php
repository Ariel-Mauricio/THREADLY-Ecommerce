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
        Schema::table('orders', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('orders', 'address_reference')) {
                $table->string('address_reference')->nullable()->after('shipping_address');
            }
            
            if (!Schema::hasColumn('orders', 'ip_address')) {
                $table->string('ip_address', 45)->nullable()->after('notes');
            }
            
            if (!Schema::hasColumn('orders', 'user_agent')) {
                $table->string('user_agent')->nullable()->after('ip_address');
            }
            
            if (!Schema::hasColumn('orders', 'shipped_at')) {
                $table->timestamp('shipped_at')->nullable()->after('user_agent');
            }
            
            if (!Schema::hasColumn('orders', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            }
            
            if (!Schema::hasColumn('orders', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('delivered_at');
            }
        });
        
        // Update payment_method enum to include new values
        // Note: This is a workaround for MySQL enum modification
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method', 50)->default('card')->change();
        });
        
        // Update status enum to include new values  
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status', 50)->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'address_reference',
                'ip_address', 
                'user_agent',
                'shipped_at',
                'delivered_at',
                'paid_at'
            ]);
        });
    }
};
