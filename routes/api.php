<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CaseController;

// Api's
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/forget-password', [AuthController::class, 'forgetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/details', [AuthController::class, 'details']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'role:super-admin'])->group(function () {
    Route::get('/all/users', [UserController::class, 'AllUsers']);
    Route::get('/user/detail/{user_id}', [UserController::class, 'UserDetails']);
    Route::post('/user/create', [UserController::class, 'CreateUser']);
    Route::post('/user/update/{user_id}', [UserController::class, 'UpdateUser']);
});

Route::middleware(['auth:sanctum', 'role:banl-admin,super-admin'])->group(function () {
    Route::post('/create/case', [CaseController::class, 'store']);
});
