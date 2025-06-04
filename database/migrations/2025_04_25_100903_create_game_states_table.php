<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'game_states' table with id, name, timestamps, and soft deletes.
    public function up(): void
    {
        Schema::create('game_states', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    // Reverse the database migrations.
    // Drops the 'game_states' table if it exists.
    public function down(): void
    {
        Schema::dropIfExists('game_states');
    }
};
