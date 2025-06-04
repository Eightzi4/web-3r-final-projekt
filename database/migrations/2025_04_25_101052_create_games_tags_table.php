<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'games_tags' pivot table with foreign keys to tags and games.
    public function up(): void
    {
        Schema::create('games_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('game_id');

            $table->primary(['tag_id', 'game_id']);

            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    // Reverse the database migrations.
    // Drops the foreign key constraints and then the 'games_tags' pivot table.
    public function down(): void
    {
        Schema::table('games_tags', function (Blueprint $table) {
            $table->dropForeign(['tag_id']);
            $table->dropForeign(['game_id']);
        });
        Schema::dropIfExists('games_tags');
    }
};
