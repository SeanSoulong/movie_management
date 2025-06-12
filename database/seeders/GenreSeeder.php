<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        Genre::create(['genre_description' => 'Action']);
        Genre::create(['genre_description' => 'Sci-Fi']);
        Genre::create(['genre_description' => 'Drama']);
        Genre::create(['genre_description' => 'Comedy']);
        Genre::create(['genre_description' => 'Thriller']);
        Genre::create(['genre_description' => 'Fantasy']);
    }
}
