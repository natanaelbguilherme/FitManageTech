<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentWorkoutPdfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoutController;
use App\Http\Middleware\ValidateLimitToUser;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    // rotas privadas

    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::post('exercises', [ExerciseController::class, 'store']);
    Route::get('exercises', [ExerciseController::class, 'index']);
    Route::delete('exercises/{id}', [ExerciseController::class, 'destroy']);

    Route::get('students/export', [StudentWorkoutPdfController::class, 'export']);

    Route::post('students', [StudentController::class, 'store'])->middleware(ValidateLimitToUser::class);
    Route::get('students', [StudentController::class, 'index']);
    Route::get('students/{id}', [StudentController::class, 'listOneStudent']);
    Route::delete('students/{id}', [StudentController::class, 'destroy']);
    Route::put('students/{id}', [StudentController::class, 'update']);



    Route::post('workouts', [WorkoutController::class, 'store']);

    Route::get('{id}/workouts', [WorkoutController::class, 'index']);
});

// rota pública

Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthController::class, 'store']);
