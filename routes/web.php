<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Common\AuthController;
use App\Http\Controllers\AdminController;


Route::get('/reset-password', [App\Http\Controllers\Api\AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\Api\AuthController::class, 'resetPassword'])->name('password.update');


Route::get('/greet', function () {
    return greet_user('Manish');
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
