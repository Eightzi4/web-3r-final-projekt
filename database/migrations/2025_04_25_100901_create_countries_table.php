<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            // $table->integer('id')->autoIncrement()->startingValue(401); // Old
            // $table->primary('id'); // Old - $table->id() handles this
            $table->id(); // New
            $table->string('name')->unique(); // Country names should likely be unique
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes(); // For soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
