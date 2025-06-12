<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cast;

class CastSeeder extends Seeder
{
    public function run(): void
    {
        Cast::create([
            'cast_full_name' => 'Tom Hanks',
            'cast_first_name' => 'Tom',
            'cast_last_name' => 'Hanks',
            'cast_gender' => 'M',
        ]);
        Cast::create([
            'cast_full_name' => 'Natalie Portman',
            'cast_first_name' => 'Natalie',
            'cast_last_name' => 'Portman',
            'cast_gender' => 'F',
        ]);
        Cast::create([
            'cast_full_name' => 'Samuel L. Jackson',
            'cast_first_name' => 'Samuel L.',
            'cast_last_name' => 'Jackson',
            'cast_gender' => 'M',
        ]);
        Cast::create([
            'cast_full_name' => 'Scarlett Johansson',
            'cast_first_name' => 'Scarlett',
            'cast_last_name' => 'Johansson',
            'cast_gender' => 'F',
        ]);
    }
}
