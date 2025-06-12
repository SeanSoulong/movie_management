<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
      public function run(): void
    {
        // Call individual seeders. Order matters for foreign key relationships.
        $this->call([
            DirectorSeeder::class,
            GenreSeeder::class,
            CastSeeder::class,
            MovieSeeder::class, // MovieSeeder depends on Director, Genre, and Cast data
        ]);
    }
}
