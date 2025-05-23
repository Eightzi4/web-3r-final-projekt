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
        Schema::create('developers', function (Blueprint $table) {
            // $table->integer('id')->autoIncrement()->startingValue(501); // Old
            $table->id(); // New: This creates an UNSIGNED BIGINT 'id'
            $table->string('name');
            $table->date('founded_date')->nullable();
            $table->text('description')->nullable();

            // For country_id, assuming countries.id is also UNSIGNED BIGINT (created with $table->id())
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('website_link')->nullable();

            // Add onDelete('set null') or onDelete('cascade') if appropriate
            // Using 'set null' because country_id is nullable. If a country is deleted,
            // the developer's country_id will become NULL.
            // If you want to delete the developer if their country is deleted, use 'cascade'.
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');

            $table->timestamps(); // Good practice to add timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
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
