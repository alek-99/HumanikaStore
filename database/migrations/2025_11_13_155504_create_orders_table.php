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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status', ['pending', 'process', 'confirmed', 'canceled'])->default('pending')->nullable();
            $table->string('alamat_pengiriman')->nullable();
            $table->string('no_hp')->nullable();
            $table->enum('payment_method', ['e-wallet','cash_on_delivery'])->nullable();
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
