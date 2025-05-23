<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_images', function (Blueprint $table) {
            // $table->integer('id')->autoIncrement()->startingValue(51); // Old
            $table->id(); // New
            $table->string('image');
            // $table->integer('game_id'); // Old
            $table->unsignedBigInteger('game_id'); // New

            $table->foreign('game_id')
                  ->references('id')->on('games')
                  ->onDelete('cascade'); // If game is deleted, its images are deleted
            // No timestamps typically needed
        });
    }

    public function down(): void
    {
        Schema::table('game_images', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
        });
        Schema::dropIfExists('game_images');
    }
};
