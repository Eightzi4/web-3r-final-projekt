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
        Schema::create('games', function (Blueprint $table) {
            // $table->integer('id')->autoIncrement()->startingValue(2001); // Old
            $table->id(); // New: This creates an UNSIGNED BIGINT 'id'
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('trailer_link')->nullable();
            $table->boolean('visible');

            // For developer_id, assuming developers.id is also UNSIGNED BIGINT (created with $table->id())
            $table->unsignedBigInteger('developer_id');
            $table->foreign('developer_id')->references('id')->on('developers')->onDelete('cascade'); // Added onDelete cascade

            $table->timestamps(); // It's good practice to add timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            if (Schema::hasColumn('games', 'developer_id')) { // Check before dropping if you might run down multiple times
                $table->dropForeign(['developer_id']);
            }
        });
        Schema::dropIfExists('games');
    }
};
