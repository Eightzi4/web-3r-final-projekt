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
        Schema::create('game_images', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->startingValue(51);
            $table->string('image');
            $table->integer('games_id');
            $table->foreign('games_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_images');
    }
};
