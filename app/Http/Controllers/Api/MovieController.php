<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with(['director', 'genres', 'castMembers'])->get();
        return response()->json($movies);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'movie_title' => 'required|string|max:150',
                'movie_description' => 'nullable|string|max:250',
                'movie_release_date' => 'required|date',
                'movie_duration' => 'required|integer',
                'director_id' => 'required|exists:directors,director_id',
                'genre_ids' => 'array',
                'genre_ids.*' => 'exists:genres,genre_id',
                'cast_ids' => 'array',
                'cast_ids.*' => 'exists:casts,cast_id',
            ], [
                'movie_title.required' => 'Movie title is required.',
                'movie_title.string' => 'Movie title must be a string.',
                'movie_title.max' => 'Movie title may not be greater than 150 characters.',
                'movie_description.string' => 'Description must be a string.',
                'movie_description.max' => 'Description may not exceed 250 characters.',
                'movie_release_date.required' => 'Release date is required.',
                'movie_release_date.date' => 'Release date must be a valid date.',
                'movie_duration.required' => 'Duration is required.',
                'movie_duration.integer' => 'Duration must be an integer.',
                'director_id.required' => 'Director is required.',
                'director_id.exists' => 'Selected director does not exist.',
                'genre_ids.array' => 'Genres must be in an array format.',
                'genre_ids.*.exists' => 'One or more selected genres do not exist.',
                'cast_ids.array' => 'Casts must be in an array format.',
                'cast_ids.*.exists' => 'One or more selected cast members do not exist.',
            ]);

            $movie = Movie::create([
                'movie_title' => $validatedData['movie_title'],
                'movie_description' => $validatedData['movie_description'] ?? null,
                'movie_release_date' => $validatedData['movie_release_date'],
                'movie_duration' => $validatedData['movie_duration'],
                'director_id' => $validatedData['director_id'],
            ]);

            if (!empty($validatedData['genre_ids'])) {
                $movie->genres()->sync($validatedData['genre_ids']);
            }

            if (!empty($validatedData['cast_ids'])) {
                $movie->castMembers()->sync($validatedData['cast_ids']);
            }

            return response()->json($movie->load(['director', 'genres', 'castMembers']), 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function show(string $id)
    {
        $movie = Movie::with(['director', 'genres', 'castMembers'])->find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        return response()->json($movie);
    }

    public function update(Request $request, string $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        try {
            $validatedData = $request->validate([
                'movie_title' => 'sometimes|required|string|max:150',
                'movie_description' => 'nullable|string|max:250',
                'movie_release_date' => 'sometimes|required|date',
                'movie_duration' => 'sometimes|required|integer',
                'director_id' => 'sometimes|required|exists:directors,director_id',
                'genre_ids' => 'array',
                'genre_ids.*' => 'exists:genres,genre_id',
                'cast_ids' => 'array',
                'cast_ids.*' => 'exists:casts,cast_id',
            ], [
                'movie_title.required' => 'Movie title is required.',
                'movie_title.string' => 'Movie title must be a string.',
                'movie_title.max' => 'Movie title may not be greater than 150 characters.',
                'movie_description.string' => 'Description must be a string.',
                'movie_description.max' => 'Description may not exceed 250 characters.',
                'movie_release_date.date' => 'Release date must be a valid date.',
                'movie_duration.integer' => 'Duration must be an integer.',
                'director_id.exists' => 'Selected director does not exist.',
                'genre_ids.array' => 'Genres must be in an array format.',
                'genre_ids.*.exists' => 'One or more selected genres do not exist.',
                'cast_ids.array' => 'Casts must be in an array format.',
                'cast_ids.*.exists' => 'One or more selected cast members do not exist.',
            ]);

            $movie->update([
                'movie_title' => $validatedData['movie_title'] ?? $movie->movie_title,
                'movie_description' => $validatedData['movie_description'] ?? $movie->movie_description,
                'movie_release_date' => $validatedData['movie_release_date'] ?? $movie->movie_release_date,
                'movie_duration' => $validatedData['movie_duration'] ?? $movie->movie_duration,
                'director_id' => $validatedData['director_id'] ?? $movie->director_id,
            ]);

            if (array_key_exists('genre_ids', $validatedData)) {
                $movie->genres()->sync($validatedData['genre_ids'] ?? []);
            }

            if (array_key_exists('cast_ids', $validatedData)) {
                $movie->castMembers()->sync($validatedData['cast_ids'] ?? []);
            }

            return response()->json($movie->load(['director', 'genres', 'castMembers']));

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy(string $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully'], 200);
    }
}
