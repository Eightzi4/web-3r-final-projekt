<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'platforms' table with id, name, timestamps, and soft deletes.
    public function up(): void
    {
        Schema::create('platforms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    // Reverse the database migrations.
    // Drops the 'platforms' table if it exists.
    public function down(): void
    {
        Schema::dropIfExists('platforms');
    }
};
