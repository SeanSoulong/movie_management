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
        Schema::create('movie_genre', function (Blueprint $table) {
            $table->unsignedInteger('movie_id');
            $table->unsignedInteger('genre_id');
            $table->timestamps();

            // Composite Primary Key
            $table->primary(['movie_id', 'genre_id']);

            // Foreign Key Constraints
            $table->foreign('movie_id')
                  ->references('movie_id')
                  ->on('movies')
                  ->onDelete('cascade');

            $table->foreign('genre_id')
                  ->references('genre_id')
                  ->on('genres')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_genre');
    }
};