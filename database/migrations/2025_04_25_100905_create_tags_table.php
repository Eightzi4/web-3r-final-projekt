<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            // $table->integer('id')->autoIncrement()->startingValue(401); // Old
            $table->id(); // New
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('color')->nullable(); // Changed color to string (e.g., hex code '#FF0000') and made nullable
            // No timestamps typically needed for tags
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
