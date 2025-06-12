<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Validation\ValidationException;

class GenreController extends Controller
{
    /**
     * Display a listing of the genres.
     * GET /api/genres
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $genres = Genre::all();
        return response()->json($genres);
    }

    /**
     * Store a newly created genre in storage.
     * POST /api/genres
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'genre_description' => 'required|string|max:50|unique:genres,genre_description',
            ], [
                'genre_description.required' => 'Genre description is required.',
                'genre_description.string' => 'Genre description must be a string.',
                'genre_description.max' => 'Genre description cannot exceed 50 characters.',
                'genre_description.unique' => 'This genre already exists.',
            ]);

            $genre = Genre::create($validatedData);
            return response()->json($genre, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified genre.
     * GET /api/genres/{id}
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        return response()->json($genre);
    }

    /**
     * Update the specified genre in storage.
     * PUT/PATCH /api/genres/{id}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        try {
            $validatedData = $request->validate([
                'genre_description' => 'sometimes|required|string|max:50|unique:genres,genre_description,' . $id . ',genre_id',
            ], [
                'genre_description.required' => 'Genre description is required.',
                'genre_description.string' => 'Genre description must be a string.',
                'genre_description.max' => 'Genre description cannot exceed 50 characters.',
                'genre_description.unique' => 'This genre already exists.',
            ]);

            $genre->update($validatedData);
            return response()->json($genre);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified genre from storage.
     * DELETE /api/genres/{id}
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        $genre->delete();
        return response()->json(['message' => 'Genre deleted successfully'], 200);
    }
}
