<?php

use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UtilisateurController::class, 'login'])->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/moi', [UtilisateurController::class, 'me']);
    Route::post('/logout', [UtilisateurController::class, 'logout']);

    Route::get('/utilisateurs', [UtilisateurController::class, 'index']);
    Route::get('/utilisateurs/{id}', [UtilisateurController::class, 'show']);
    Route::match(['put', 'patch'], '/utilisateurs/{id}', [UtilisateurController::class, 'update']);

    Route::middleware('admin')->group(function () {
        Route::post('/utilisateurs', [UtilisateurController::class, 'store']);
        Route::delete('/utilisateurs/{id}', [UtilisateurController::class, 'destroy']);
    });
});
