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
            $table->integer('games_id');
            $table->integer('game_states_id');
            $table->primary(['games_id', 'game_states_id']);
            $table->foreign('games_id')->references('id')->on('games');
            $table->foreign('game_states_id')->references('id')->on('game_states');
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
