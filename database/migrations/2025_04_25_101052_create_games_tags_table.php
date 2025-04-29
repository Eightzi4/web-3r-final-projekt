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
            $table->integer('tags_id');
            $table->integer('games_id');
            $table->primary(['tags_id', 'games_id']);
            $table->foreign('tags_id')->references('id')->on('tags');
            $table->foreign('games_id')->references('id')->on('games');
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
