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
        Schema::create('cast_members', function (Blueprint $table) {
            $table->unsignedInteger('movie_id');
            $table->unsignedInteger('cast_id');
            $table->timestamps();

            // Composite Primary Key
            $table->primary(['movie_id', 'cast_id']);

            // Foreign Key Constraints
            $table->foreign('movie_id')
                  ->references('movie_id')
                  ->on('movies')
                  ->onDelete('cascade');

            $table->foreign('cast_id')
                  ->references('cast_id')
                  ->on('casts')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cast_members');
    }
};