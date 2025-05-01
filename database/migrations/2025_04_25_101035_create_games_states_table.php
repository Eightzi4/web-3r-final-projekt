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
        Schema::create('games_states', function (Blueprint $table) {
            $table->integer('game_id');
            $table->integer('game_state_id');
            $table->primary(['game_id', 'game_state_id']);
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('game_state_id')->references('id')->on('game_states');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games_states');
    }
};
