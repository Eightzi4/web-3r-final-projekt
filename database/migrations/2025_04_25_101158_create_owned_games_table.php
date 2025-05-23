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
            // $table->integer('user_id'); // Old
            // $table->integer('game_id'); // Old

            $table->unsignedBigInteger('user_id'); // Correct: Matches users.id (if it's bigIncrements)
            $table->unsignedBigInteger('game_id'); // Correct: Matches games.id (if it's bigIncrements)

            $table->primary(['user_id', 'game_id']);

            // Define foreign keys
            // onDelete('cascade') means if a user or game is deleted,
            // the corresponding entries in owned_games will also be deleted.
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('owned_games', function (Blueprint $table) {
            // It's good practice to drop foreign keys before dropping the table,
            // or if you want to modify them.
            $table->dropForeign(['user_id']);
            $table->dropForeign(['game_id']);
        });
        Schema::dropIfExists('owned_games');
    }
};
