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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // $table->foreign('color_id')->references('id')->on('color_product');
            // $table->foreign('product_id')->references('id')->on('products');
            // $table->integer('quantity');
            // $table->bigInteger('size_id');
            // $table->enum('status', ['قيد الانتظار', 'تم الموافقة', 'تم التوصيل'])->default('قيد الانتظار');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
