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
        Schema::create('users', function (Blueprint $table) {
            // $table->integer('id')->autoIncrement()->startingValue(1001); // Using standard bigIncrements is more common
            $table->id(); // This creates a bigIncrements 'id' column, primary key.
            $table->string('name');
            $table->string('email')->unique(); // Email should be unique for login
            $table->timestamp('email_verified_at')->nullable(); // For email verification
            $table->string('password'); // The password column
            $table->rememberToken(); // For "remember me" functionality
            $table->timestamps(); // Adds created_at and updated_at columns

            // Your custom 'is_admin' column can be added here directly
            // instead of a separate migration if this is the primary user table creation.
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_banned')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
