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
        Schema::create('prices', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->startingValue(10001);
            $table->float('price');
            $table->date('date');
            $table->float('discount');
            $table->integer('game_id');
            $table->integer('platform_id');
            $table->integer('store_id');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('platform_id')->references('id')->on('platforms');
            $table->foreign('store_id')->references('id')->on('stores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
