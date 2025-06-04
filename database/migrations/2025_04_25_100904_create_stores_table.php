<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'stores' table with id, name, website link, timestamps, and soft deletes.
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('website_link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    // Reverse the database migrations.
    // Drops the 'stores' table if it exists.
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
