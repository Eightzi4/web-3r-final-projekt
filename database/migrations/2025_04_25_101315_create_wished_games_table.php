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
        Schema::create('wished_games', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('games_id');
            $table->primary(['user_id', 'games_id']);
            $table->foreign('user_id')->references('id')->on('users2');
            $table->foreign('games_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wished_games');
    }
};
