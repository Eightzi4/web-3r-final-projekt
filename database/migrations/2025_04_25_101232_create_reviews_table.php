<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'reviews' table with review details, foreign keys, timestamps, and soft deletes.
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('comment')->nullable();
            $table->unsignedTinyInteger('rating');
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    // Reverse the database migrations.
    // Drops foreign key constraints and then the 'reviews' table.
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('reviews');
    }
};
