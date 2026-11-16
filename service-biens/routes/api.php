<?php

use App\Http\Controllers\BienController;
use Illuminate\Support\Facades\Route;

Route::middleware('verify.token')->apiResource('biens', BienController::class);
