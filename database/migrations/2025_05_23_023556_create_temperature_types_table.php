<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('temperature_types', function (Blueprint $table) {
            $table->char(36)->primary();
            $table->enum('temperature', ['cold', 'hot'])->default('cold');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temperature_types');
    }
};
