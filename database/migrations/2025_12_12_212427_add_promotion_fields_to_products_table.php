<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('original_price', 10, 2)->nullable()->after('price');
            $table->integer('discount_percent')->nullable()->after('original_price');
            $table->timestamp('promotion_starts')->nullable();
            $table->timestamp('promotion_ends')->nullable();
            $table->string('promotion_label')->nullable();
            $table->boolean('is_new')->default(false);
            $table->string('sku')->nullable()->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'original_price', 'discount_percent', 'promotion_starts', 
                'promotion_ends', 'promotion_label', 'is_new', 'sku'
            ]);
        });
    }
};
