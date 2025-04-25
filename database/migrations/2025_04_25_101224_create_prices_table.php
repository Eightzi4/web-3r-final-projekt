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
            $table->integer('games_id');
            $table->integer('platforms_id');
            $table->integer('stores_id');
            $table->foreign('games_id')->references('id')->on('games');
            $table->foreign('platforms_id')->references('id')->on('platforms');
            $table->foreign('stores_id')->references('id')->on('stores');
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
