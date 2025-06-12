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
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('movie_id'); // Primary Key
            $table->string('movie_title', 150);
            $table->string('movie_description', 250)->nullable();
            $table->date('movie_release_date');
            $table->integer('movie_duration'); // In minutes, for example
            $table->unsignedInteger('director_id'); // Foreign Key
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('director_id')
                  ->references('director_id')
                  ->on('directors')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};