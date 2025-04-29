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
        Schema::create('reviews', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->startingValue(1001);
            $table->text('content')->nullable();
            $table->integer('rating');
            $table->integer('games_id');
            $table->integer('user_id');
            $table->foreign('games_id')->references('id')->on('games');
            $table->foreign('user_id')->references('id')->on('users2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
