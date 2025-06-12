<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\DirectorController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\CastController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware([EnsureTokenIsValid::class])->group(function () {
    
    Route::get('/', fn() => response()->json(['message' => 'Welcome to the Movie API']));
    Route::prefix('movies')->group(function () {
        Route::get('/', [MovieController::class, 'index']);
        Route::post('/', [MovieController::class, 'store']);
        Route::get('/{id}', [MovieController::class, 'show']);
        Route::put('/{id}', [MovieController::class, 'update']);
        Route::delete('/{id}', [MovieController::class, 'destroy']);
    });

    Route::prefix('directors')->group(function () {
        Route::get('/', [DirectorController::class, 'index']);
        Route::post('/', [DirectorController::class, 'store']);
        Route::get('/{id}', [DirectorController::class, 'show']);
        Route::put('/{id}', [DirectorController::class, 'update']);
        Route::delete('/{id}', [DirectorController::class, 'destroy']);
    });

    Route::prefix('genres')->group(function () {
        Route::get('/', [GenreController::class, 'index']);
        Route::post('/', [GenreController::class, 'store']);
        Route::get('/{id}', [GenreController::class, 'show']);
        Route::put('/{id}', [GenreController::class, 'update']);
        Route::delete('/{id}', [GenreController::class, 'destroy']);
    });

    Route::prefix('casts')->group(function () {
        Route::get('/', [CastController::class, 'index']);
        Route::post('/', [CastController::class, 'store']);
        Route::get('/{id}', [CastController::class, 'show']);
        Route::put('/{id}', [CastController::class, 'update']);
        Route::delete('/{id}', [CastController::class, 'destroy']);
    });
});
