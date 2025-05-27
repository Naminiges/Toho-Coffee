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
            $table->uuid('id_orders')->primary();
            $table->string('orders_code', 20)->unique();
            $table->string('staff_name', 100)->nullable();
            $table->uuid('member_id')->nullable();
            $table->string('member_name', 100)->nullable();
            $table->longText('member_notes')->nullable();
            $table->string('member_bank', 100)->nullable();
            $table->binary('proof_payment')->nullable();
            $table->enum('order_status', ['menunggu', 'diproses', 'siap', 'selesai', 'dibatalkan']);
            $table->decimal('total_price', 10, 2);
            $table->timestamp('order_date');
            $table->timestamp('order_complete')->nullable();
            $table->foreign('member_id')->references('id_member')->on('members')->onDelete('set null');
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
