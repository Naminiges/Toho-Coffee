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
        Schema::create('orders_details', function (Blueprint $table) {
            $table->uuid('id_order_detail')->primary();
            $table->uuid('order_id');
            $table->string('pickup_telephone', 14);
            $table->string('pickup_email');
            $table->string('pickup_place');
            $table->timestamp('pickup_time');
            $table->string('pickup_method');
            $table->string('payment_method');
            $table->string('payment_status');
            $table->string('bank_number');
            $table->uuid('product_id');
            $table->decimal('product_price', 10, 2);
            $table->integer('product_quantity');
            $table->foreign('order_id')->references('id_orders')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id_product')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_details');
    }
};
