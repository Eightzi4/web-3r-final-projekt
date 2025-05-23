<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platforms', function (Blueprint $table) {
            // $table->integer('id')->autoIncrement()->startingValue(501); // Old
            $table->id(); // New
            $table->string('name')->unique();
            // No timestamps typically needed
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platforms');
    }
};
