<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_states', function (Blueprint $table) {
            // $table->integer('id')->autoIncrement()->startingValue(201); // Old
            $table->id(); // New
            $table->string('name')->unique(); // Game state names should be unique
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes(); // For soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_states');
    }
};
