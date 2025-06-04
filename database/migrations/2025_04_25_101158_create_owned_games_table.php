<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'owned_games' pivot table with foreign keys to users and games.
    public function up(): void
    {
        Schema::create('owned_games', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('game_id');

            $table->primary(['user_id', 'game_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    // Reverse the database migrations.
    // Drops the foreign key constraints and then the 'owned_games' pivot table.
    public function down(): void
    {
        Schema::table('owned_games', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['game_id']);
        });
        Schema::dropIfExists('owned_games');
    }
};
