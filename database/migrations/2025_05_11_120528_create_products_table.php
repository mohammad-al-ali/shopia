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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('slug')->unique(); // إضافة معرف فريد
            $table->decimal('regular_price', 8, 2); // إضافة السعر العادي
            $table->decimal('sale_price', 8, 2)->nullable(); // السعر المخفض
            $table->decimal('warehouse_price',8,2);
            $table->boolean('featured')->default(false); // تحديد المنتج كمميز
            $table->integer('quantity');
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->text('images')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable(); // ✅ يجب أن يكون nullable()
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->unsignedBigInteger('category_id')->nullable(); // ✅ يجب أن يكون nullable()
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

