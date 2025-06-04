<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'users' table with standard user fields, admin/banned flags, timestamps, and soft deletes.
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->boolean('is_admin')->default(false);
            $table->boolean('is_banned')->default(false);
        });
    }

    // Reverse the database migrations.
    // Drops the 'users' table if it exists.
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
