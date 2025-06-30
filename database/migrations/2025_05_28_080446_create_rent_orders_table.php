<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('rent_orders', function (Blueprint $table) {
        $table->id();
        $table->string('midtrans_order_id')->unique();
        $table->foreignId('rent_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('email');
        $table->string('phone');
        $table->date('tanggal_mulai_sewa');
        $table->integer('jumlah_bulan');
        $table->integer('total_harga');
        $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
        $table->enum('status_payment', ['unpaid', 'paid', 'failed'])->default('unpaid');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_orders');
    }
};
