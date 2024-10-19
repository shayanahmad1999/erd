<?php

use App\Http\Controllers\ERDController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ERDController::class, 'showForm']);
Route::post('/generate-erd', [ERDController::class, 'generateERD']);