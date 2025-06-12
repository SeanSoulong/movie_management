<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Director;

class DirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        Director::create([
            'director_full_name' => 'Steven Spielberg',
            'director_first_name' => 'Steven',
            'director_last_name' => 'Spielberg',
            'director_gender' => 'M',
        ]);

        Director::create([
            'director_full_name' => 'Kathryn Bigelow',
            'director_first_name' => 'Kathryn',
            'director_last_name' => 'Bigelow',
            'director_gender' => 'F',
        ]);

        Director::create([
            'director_full_name' => 'Quentin Tarantino',
            'director_first_name' => 'Quentin',
            'director_last_name' => 'Tarantino',
            'director_gender' => 'M',
        ]);
    }
}
