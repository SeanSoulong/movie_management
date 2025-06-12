<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Director;

class DirectorController extends Controller
{
    /**
     * Display a listing of the directors.
     * GET /api/directors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $directors = Director::all();
        return response()->json($directors);
    }

    /**
     * Store a newly created director in storage.
     * POST /api/directors
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'director_full_name' => 'required|string|max:50',
                'director_first_name' => 'required|string|max:50',
                'director_last_name' => 'required|string|max:50',
                'director_gender' => 'required|string|max:2',
            ], [
                'director_full_name.required' => 'Full name is required.',
                'director_first_name.required' => 'First name is required.',
                'director_last_name.required' => 'Last name is required.',
                'director_gender.required' => 'Gender is required.',
            ]);

            $director = Director::create($validatedData);
            return response()->json($director, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified director.
     * GET /api/directors/{id}
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $director = Director::find($id);

        if (!$director) {
            return response()->json(['message' => 'Director not found'], 404);
        }

        return response()->json($director);
    }

    /**
     * Update the specified director in storage.
     * PUT /api/directors/{id}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $director = Director::find($id);

        if (!$director) {
            return response()->json(['message' => 'Director not found'], 404);
        }

        try {
            $validatedData = $request->validate([
                'director_full_name' => 'sometimes|required|string|max:50',
                'director_first_name' => 'sometimes|required|string|max:50',
                'director_last_name' => 'sometimes|required|string|max:50',
                'director_gender' => 'sometimes|required|string|max:2',
            ]);

            $director->update($validatedData);
            return response()->json($director);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified director from storage.
     * DELETE /api/directors/{id}
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $director = Director::find($id);

        if (!$director) {
            return response()->json(['message' => 'Director not found'], 404);
        }

        $director->delete();
        return response()->json(['message' => 'Director deleted successfully'], 200);
    }
}
