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
        Schema::create('games', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->startingValue(2001);
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('trailer_link')->nullable();
            $table->boolean('visible');
            $table->integer('developers_id');
            $table->foreign('developers_id')->references('id')->on('developers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
