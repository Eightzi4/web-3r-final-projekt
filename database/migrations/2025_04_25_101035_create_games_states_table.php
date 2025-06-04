<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'games_states' pivot table with foreign keys to games and game_states.
    public function up(): void
    {
        Schema::create('games_states', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('game_state_id');

            $table->primary(['game_id', 'game_state_id']);

            $table->foreign('game_id')
                  ->references('id')->on('games')
                  ->onDelete('cascade');
            $table->foreign('game_state_id')
                  ->references('id')->on('game_states')
                  ->onDelete('cascade');
        });
    }

    // Reverse the database migrations.
    // Drops the foreign key constraints and then the 'games_states' pivot table.
    public function down(): void
    {
        Schema::table('games_states', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropForeign(['game_state_id']);
        });
        Schema::dropIfExists('games_states');
    }
};
