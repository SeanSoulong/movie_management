<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cast;
use Illuminate\Validation\ValidationException;

class CastController extends Controller
{
    /**
     * Display a listing of the cast members.
     * GET /api/casts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $casts = Cast::all();
        return response()->json($casts);
    }

    /**
     * Store a newly created cast member in storage.
     * POST /api/casts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'cast_full_name' => 'required|string|max:50',
                'cast_first_name' => 'required|string|max:50',
                'cast_last_name' => 'required|string|max:50',
                'cast_gender' => 'required|string|max:2',
            ], [
                'cast_full_name.required' => 'Full name is required.',
                'cast_first_name.required' => 'First name is required.',
                'cast_last_name.required' => 'Last name is required.',
                'cast_gender.required' => 'Gender is required.',
            ]);

            $cast = Cast::create($validatedData);
            return response()->json($cast, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified cast member.
     * GET /api/casts/{id}
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $cast = Cast::find($id);

        if (!$cast) {
            return response()->json(['message' => 'Cast not found'], 404);
        }

        return response()->json($cast);
    }

    /**
     * Update the specified cast member in storage.
     * PUT/PATCH /api/casts/{id}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $cast = Cast::find($id);

        if (!$cast) {
            return response()->json(['message' => 'Cast not found'], 404);
        }

        try {
            $validatedData = $request->validate([
                'cast_full_name' => 'sometimes|required|string|max:50',
                'cast_first_name' => 'sometimes|required|string|max:50',
                'cast_last_name' => 'sometimes|required|string|max:50',
                'cast_gender' => 'sometimes|required|string|max:2',
            ]);

            $cast->update($validatedData);
            return response()->json($cast);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified cast member from storage.
     * DELETE /api/casts/{id}
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $cast = Cast::find($id);

        if (!$cast) {
            return response()->json(['message' => 'Cast not found'], 404);
        }

        $cast->delete();
        return response()->json(['message' => 'Cast deleted successfully'], 200);
    }
}
