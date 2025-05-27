<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->char(36)->primary();
            $table->foreignId('description_id')->constrained('product_description')->onDelete('cascade');
            $table->string('product_name');
            $table->enum('status', ['aktif', 'nonaktif']);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
