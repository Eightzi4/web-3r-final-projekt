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
        Schema::create('owned_games', function (Blueprint $table) {
            $table->integer('user2_id');
            $table->integer('game_id');
            $table->primary(['user2_id', 'game_id']);
            $table->foreign('user2_id')->references('id')->on('users2');
            $table->foreign('game_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owned_games');
    }
};
