<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games_states', function (Blueprint $table) { // Assuming this is the correct pivot table name
            // $table->integer('game_id'); // Old
            // $table->integer('game_state_id'); // Old
            $table->unsignedBigInteger('game_id'); // New
            $table->unsignedBigInteger('game_state_id'); // New

            $table->primary(['game_id', 'game_state_id']);

            $table->foreign('game_id')
                  ->references('id')->on('games')
                  ->onDelete('cascade');
            $table->foreign('game_state_id')
                  ->references('id')->on('game_states') // Corrected table name
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('games_states', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropForeign(['game_state_id']);
        });
        Schema::dropIfExists('games_states');
    }
};
