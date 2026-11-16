<?php

use App\Http\Controllers\AffectationController;
use Illuminate\Support\Facades\Route;

Route::middleware('verify.token')->apiResource('affectations', AffectationController::class);
