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
        Schema::create('developer_images', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->startingValue(51);
            $table->string('image');
            $table->integer('developer_id');
            $table->foreign('developer_id')->references('id')->on('developers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developer_images');
    }
};
