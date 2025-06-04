<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'game_images' table with image path, foreign key to games, timestamps, and soft deletes.
    public function up(): void
    {
        Schema::create('game_images', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->unsignedBigInteger('game_id');

            $table->foreign('game_id')
                  ->references('id')->on('games')
                  ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    // Reverse the database migrations.
    // Drops the foreign key constraint and then the 'game_images' table.
    public function down(): void
    {
        Schema::table('game_images', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
        });
        Schema::dropIfExists('game_images');
    }
};
