<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            // $table->integer('id')->autoIncrement()->startingValue(10001); // Old
            $table->id(); // New
            $table->decimal('price', 8, 2); // Use decimal for currency for precision
            $table->date('date');
            $table->unsignedTinyInteger('discount')->default(0); // Changed to tinyInt for 0-100, ensure it's unsigned
            // $table->integer('game_id'); // Old
            // $table->integer('platform_id'); // Old
            // $table->integer('store_id'); // Old
            $table->unsignedBigInteger('game_id'); // New
            $table->unsignedBigInteger('platform_id'); // New
            $table->unsignedBigInteger('store_id'); // New

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            // Timestamps might be useful for price records, but your 'date' column serves a similar purpose.
            // If 'date' is the creation date, $table->timestamps() might be redundant.
            // If you want separate created_at/updated_at, add $table->timestamps();
        });
    }

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
