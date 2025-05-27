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
        Schema::create('product_descriptions', function (Blueprint $table) {
            $table->uuid('id_description')->primary();
            $table->uuid('category_id');
            $table->uuid('temperature_id');
            $table->binary('product_photo');
            $table->longText('product_description');
            $table->foreign('category_id')->references('id_category')->on('categories')->onDelete('cascade');
            $table->foreign('temperature_id')->references('id_temperature')->on('temperature_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_descriptions');
    }
};
