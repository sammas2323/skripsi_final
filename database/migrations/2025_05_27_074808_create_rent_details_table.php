<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rent_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rent_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('bedrooms'); // kamar tidur
            $table->tinyInteger('bathrooms'); // kamar mandi
            $table->string('building_size'); // luas bangunan
            $table->string('electricity'); // contoh: "token"
            $table->string('water'); // contoh: "PDAM"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rent_details');
    }
};
