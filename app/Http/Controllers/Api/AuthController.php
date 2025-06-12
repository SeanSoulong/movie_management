<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    public function register(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'The user name is required.',
            'email.required' => 'The email address is required.',
            'email.unique' => 'The email address has already been taken.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'email.email' => 'The email address must be a valid email format.',
            'name.string' => 'The user name must be a string.',
            'name.max' => 'The user name may not be greater than 100 characters.'
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed.',
            'errors' => $e->errors()
        ], 422);
    }

    $user = new User();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->password = bcrypt($validated['password']);
    $user->save();

    return response()->json([
        'status' => true,
        'message' => 'User registered successfully',
        'data' => $user
    ], 201);
}
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $payload = [
                'sub' => $user->id,
                'email' => $user->email,
                'iat' => time(),
                'exp' => time() + 3600, // 1 hour expiration
            ];

            $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

            return response()->json([
                'message' => 'JWT token generated successfully',
                'token' => $jwt
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
    }
}
