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
        Schema::create('games_tags', function (Blueprint $table) {
            $table->integer('tag_id');
            $table->integer('game_id');
            $table->primary(['tag_id', 'game_id']);
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('game_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games_tags');
    }
};
