<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            // $table->integer('id')->autoIncrement()->startingValue(1001); // Old
            $table->id(); // New
            $table->string('title')->nullable(); // Added title, make it nullable or required
            // $table->text('content')->nullable(); // 'content' is fine, or 'comment'
            $table->text('comment')->nullable(); // Renamed to comment for consistency with model example
            $table->unsignedTinyInteger('rating'); // For 1-5 or 1-10 scale
            // $table->integer('game_id'); // Old
            // $table->integer('user_id'); // Old
            $table->unsignedBigInteger('game_id'); // New
            $table->unsignedBigInteger('user_id'); // New

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps(); // Reviews definitely benefit from timestamps
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('reviews');
    }
};
