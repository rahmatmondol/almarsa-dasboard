<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();
            $table->string('building_name')->nullable();
            $table->string('apartment_number')->nullable();
            $table->string('house_number')->nullable();
            $table->string('floor')->nullable();
            $table->string('street')->nullable();
            $table->string('block')->nullable();
            $table->string('way')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_house')->nullable();
            $table->boolean('is_apartment')->nullable();
            $table->boolean('is_default')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    // apartment
    // address
    // building name
    // apartment number
    // street
    // block
    // way
    // number
    // default

    // house
    // house number


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
