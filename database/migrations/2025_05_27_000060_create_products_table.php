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
            $table->uuid('id_product')->primary();
            $table->uuid('description_id');
            $table->string('product_name');
            $table->decimal('product_price', 10, 2);
            $table->enum('product_status', ['aktif', 'nonaktif']);
            $table->timestamps();
            $table->foreign('description_id')->references('id_description')->on('product_descriptions')->onDelete('cascade');
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
