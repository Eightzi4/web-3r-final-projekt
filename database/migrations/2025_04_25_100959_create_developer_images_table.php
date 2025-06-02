<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('developer_images', function (Blueprint $table) {
            // $table->integer('id')->autoIncrement()->startingValue(51); // Old
            $table->id(); // New
            $table->string('image');
            // $table->integer('developer_id'); // Old
            $table->unsignedBigInteger('developer_id'); // New

            $table->foreign('developer_id')
                  ->references('id')->on('developers')
                  ->onDelete('cascade'); // If developer is deleted, their images are deleted
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes(); // For soft deletes
        });
    }

    public function down(): void
    {
        Schema::table('developer_images', function (Blueprint $table) {
            $table->dropForeign(['developer_id']);
        });
        Schema::dropIfExists('developer_images');
    }
};
