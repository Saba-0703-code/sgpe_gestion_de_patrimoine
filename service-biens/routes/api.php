<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BienController;

Route::apiResource('biens', BienController::class);
