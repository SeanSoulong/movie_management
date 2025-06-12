<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Director;
use App\Models\Genre;
use App\Models\Cast;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the 'movies' table and associates related data.
     */
    public function run(): void
    {
        // Change 'director_name' to 'director_full_name'
        $spielberg = Director::where('director_full_name', 'Steven Spielberg')->first();
        $bigelow = Director::where('director_full_name', 'Kathryn Bigelow')->first();
        $tarantino = Director::where('director_full_name', 'Quentin Tarantino')->first();

        // Retrieve existing genres and casts
        $actionGenre = Genre::where('genre_description', 'Action')->first();
        $sciFiGenre = Genre::where('genre_description', 'Sci-Fi')->first();
        $dramaGenre = Genre::where('genre_description', 'Drama')->first();
        $thrillerGenre = Genre::where('genre_description', 'Thriller')->first();

        $tomHanks = Cast::where('cast_last_name', 'Hanks')->first();
        $nataliePortman = Cast::where('cast_last_name', 'Portman')->first();
        $samuelJackson = Cast::where('cast_last_name', 'Jackson')->first();
        $scarlettJohansson = Cast::where('cast_last_name', 'Johansson')->first();

        // ... (rest of your movie creation logic, ensuring `castMembers()` is used) ...

        if ($spielberg && $actionGenre && $sciFiGenre && $tomHanks) {
            $movie1 = Movie::create([
                'movie_title' => 'Jurassic Park',
                'movie_description' => 'A pragmatic paleontologist touring an island theme park of genetically re-created dinosaurs.',
                'movie_release_date' => '1993-06-11',
                'movie_duration' => 127,
                'director_id' => $spielberg->director_id,
            ]);
            $movie1->genres()->attach([$actionGenre->genre_id, $sciFiGenre->genre_id]);
            $movie1->castMembers()->attach([$tomHanks->cast_id]);
        }

        if ($bigelow && $thrillerGenre && $nataliePortman) {
            $movie2 = Movie::create([
                'movie_title' => 'Zero Dark Thirty',
                'movie_description' => 'A chronicle of the decade-long hunt for al-Qaeda terrorist leader Osama bin Laden.',
                'movie_release_date' => '2012-12-19',
                'movie_duration' => 157,
                'director_id' => $bigelow->director_id,
            ]);
            $movie2->genres()->attach([$thrillerGenre->genre_id, $dramaGenre->genre_id]);
            $movie2->castMembers()->attach([$nataliePortman->cast_id]);
        }

        if ($tarantino && $dramaGenre && $samuelJackson && $scarlettJohansson) {
            $movie3 = Movie::create([
                'movie_title' => 'Pulp Fiction',
                'movie_description' => 'The lives of two mob hitmen, a boxer, a gangster\'s wife, and a pair of diner bandits intertwine in four tales of violence and redemption.',
                'movie_release_date' => '1994-10-14',
                'movie_duration' => 154,
                'director_id' => $tarantino->director_id,
            ]);
            $movie3->genres()->attach([$dramaGenre->genre_id, $actionGenre->genre_id]);
            $movie3->castMembers()->attach([$samuelJackson->cast_id, $scarlettJohansson->cast_id]);
        }
    }
}