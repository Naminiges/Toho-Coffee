<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->char(36)->primary();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('temperature_type_id')->constrained('temperature_types')->onDelete('cascade');
            $table->decimal('product_price', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
