<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EnsureTokenIsValid
{
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        $token = $matches[1];

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            $user = User::find($decoded->sub);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 401);
            }

            $request->merge(['auth_user' => $user]);

            return $next($request);

        } catch (ExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (SignatureInvalidException $e) {
            return response()->json(['error' => 'Invalid token signature'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token error: ' . $e->getMessage()], 401);
        }
    }
}
