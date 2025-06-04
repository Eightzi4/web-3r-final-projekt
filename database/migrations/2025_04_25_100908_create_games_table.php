<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'games' table with details, foreign key to developers, timestamps, and soft deletes.
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('trailer_link')->nullable();
            $table->boolean('visible');

            $table->unsignedBigInteger('developer_id');
            $table->foreign('developer_id')->references('id')->on('developers')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    // Reverse the database migrations.
    // Drops the foreign key constraint and then the 'games' table.
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            if (Schema::hasColumn('games', 'developer_id')) {
                $table->dropForeign(['developer_id']);
            }
        });
        Schema::dropIfExists('games');
    }
};
