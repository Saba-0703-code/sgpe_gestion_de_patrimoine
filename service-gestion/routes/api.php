<?php

use App\Http\Controllers\AffectationController;
use Illuminate\Support\Facades\Route;

Route::apiResource('affectations', AffectationController::class);
