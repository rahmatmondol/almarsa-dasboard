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

        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('banner_background');
            $table->string('banner_title');
            $table->string('banner_image');
            $table->string('email', 255);
            $table->string('phone');
            $table->string('address');
            $table->text('about');
            $table->string('title');
            $table->string('sub_title');
            $table->json('icons');
            $table->json('image_cards');
            $table->text('content');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
