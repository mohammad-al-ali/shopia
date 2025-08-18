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
        Schema::table('products', function (Blueprint $table) {
            // Drop the existing warehouse_price column if it exists with wrong name
            if (Schema::hasColumn('products', 'warehouse_price ')) {
                $table->dropColumn('warehouse_price ');
            }

            // Add the correct warehouse_price column
            if (!Schema::hasColumn('products', 'warehouse_price')) {
                $table->decimal('warehouse_price', 8, 2)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('warehouse_price');
        });
    }
};
