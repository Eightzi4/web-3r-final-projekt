<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            // $table->integer('id')->autoIncrement()->startingValue(401); // Old
            $table->id(); // New
            $table->string('name')->unique();
            $table->string('website_link')->nullable(); // Made nullable as not all might have one
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes(); // For soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
