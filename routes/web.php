<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/register/verify', [RegisterController::class, 'verifyCode']);  
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);  

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth.session'])->group(function () {
    Route::get('/boards', function () {
        return view('boards');
    })->name('boards');
});
