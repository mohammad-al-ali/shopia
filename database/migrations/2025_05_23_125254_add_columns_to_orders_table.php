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
            $table->decimal('subtotal'); // المبلغ الإجمالي قبل الخصومات والضرائب
            $table->decimal('discount')->default(0); // قيمة الخصم إن وجدت، والقيمة الافتراضية 0
            $table->decimal('tax'); // مقدار الضريبة المطبقة على الطلب
            $table->string('name'); // اسم صاحب الطلب
            $table->string('phone'); // رقم هاتف صاحب الطلب
            $table->string('locality'); // الموقع المحلي لعنوان التوصيل
            $table->text('address'); // عنوان التوصيل التفصيلي
            $table->string('city'); // المدينة الخاصة بعنوان التوصيل
            $table->string('landmark')->nullable(); // علامة مميزة بالقرب من عنوان التوصيل (اختياري)
            $table->date('delivered_date')->nullable(); // تاريخ التوصيل، يمكن أن يكون فارغًا
            $table->date('canceled_date')->nullable(); // تاريخ الإلغاء، يمكن أن يكون فارغًا

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
