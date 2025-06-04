<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the database migrations.
    // Creates the 'developers' table with details, foreign key to countries, timestamps, and soft deletes.
    public function up(): void
    {
        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('founded_date')->nullable();
            $table->text('description')->nullable();

            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('website_link')->nullable();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    // Reverse the database migrations.
    // Drops the foreign key constraint and then the 'developers' table.
    public function down(): void
    {
        Schema::table('developers', function (Blueprint $table) {
            if (Schema::hasColumn('developers', 'country_id')) {
                $table->dropForeign(['country_id']);
            }
        });
        Schema::dropIfExists('developers');
    }
};
