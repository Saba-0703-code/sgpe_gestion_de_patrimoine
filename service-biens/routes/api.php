<?php

use App\Http\Controllers\BienController;
use Illuminate\Support\Facades\Route;

Route::apiResource('biens', BienController::class);
