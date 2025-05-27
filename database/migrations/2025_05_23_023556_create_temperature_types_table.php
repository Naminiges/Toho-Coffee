<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('temperature_types', function (Blueprint $table) {
            $table->uuid('id_temperature')->primary();
            $table->enum('temperature', ['hot', 'cold']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temperature_types');
    }
};
