<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;

// Route ini BEBAS diakses siapa saja
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Route ini DIGEMBOK (Wajib pakai token JWT)
Route::middleware('auth:api')->group(function () {
    Route::apiResource('students', StudentController::class);
});
