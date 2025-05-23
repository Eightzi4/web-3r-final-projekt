<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wished_games', function (Blueprint $table) {
            // $table->integer('user_id'); // Old
            // $table->integer('game_id'); // Old
            $table->unsignedBigInteger('user_id'); // New
            $table->unsignedBigInteger('game_id'); // New

            $table->primary(['user_id', 'game_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('wished_games', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['game_id']);
        });
        Schema::dropIfExists('wished_games');
    }
};
