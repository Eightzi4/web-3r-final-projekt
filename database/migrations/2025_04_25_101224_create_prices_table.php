<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'prices' table with price details, foreign keys, timestamps, and soft deletes.
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 8, 2);
            $table->date('date');
            $table->unsignedTinyInteger('discount')->default(0);
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('platform_id');
            $table->unsignedBigInteger('store_id');

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    // Reverse the database migrations.
    // Drops foreign key constraints and then the 'prices' table.
    public function down(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropForeign(['platform_id']);
            $table->dropForeign(['store_id']);
        });
        Schema::dropIfExists('prices');
    }
};
