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
        Schema::disableForeignKeyConstraints();
        Schema::create('shop_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->boolean('status');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete()->nullable();
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete()->nullable();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_items');
    }
};
