<?php

use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UtilisateurController::class, 'login']);
Route::apiResource('utilisateurs', UtilisateurController::class);
