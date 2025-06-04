<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'developer_images' table with image path, foreign key to developers, timestamps, and soft deletes.
    public function up(): void
    {
        Schema::create('developer_images', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->unsignedBigInteger('developer_id');

            $table->foreign('developer_id')
                  ->references('id')->on('developers')
                  ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    // Reverse the database migrations.
    // Drops the foreign key constraint and then the 'developer_images' table.
    public function down(): void
    {
        Schema::table('developer_images', function (Blueprint $table) {
            $table->dropForeign(['developer_id']);
        });
        Schema::dropIfExists('developer_images');
    }
};
