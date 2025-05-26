<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\RemindersController;
use App\Http\Controllers\BoardController;

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/register/verify', [RegisterController::class, 'verifyCode']);  
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/agenda/save', [AgendaController::class, 'save'])->name('agenda.save'); //agenda
Route::post('/register/reset', [RegisterController::class, 'reset'])->name('register.reset'); //tijdelijk
Route::post('/agenda/update/{id}', [AgendaController::class, 'update'])->name('agenda.update'); //
Route::delete('/agenda/delete/{id}', [AgendaController::class, 'delete'])->name('agenda.delete'); // Verwijderen
Route::get('/reminder/send', [RemindersController::class, 'sendReminders']);


Route::get('boards/agenda', [AgendaController::class, 'index'])->name('agenda');

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);  

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/planner', function () {
    return view('planner');   //planner
})->name('planner');

Route::middleware(['auth.session'])->group(function () {
    Route::get('/boards', [BoardController::class, 'index'])->name('boards.index');
    Route::get('/boards/create', [BoardController::class, 'create'])->name('boards.create');
    Route::post('/boards', [BoardController::class, 'store'])->name('boards.store');
    Route::get('/boards/{slug}', [BoardController::class, 'show'])->name('boards.show'); // Gebruik Slug

    Route::post('/boards/{slug}/lists', [BoardController::class, 'addList'])->name('boards.addList');
    Route::delete('/boards/{slug}/lists/{listId}', [BoardController::class, 'deleteList'])->name('boards.deleteList');
    Route::post('/boards/{slug}/lists/{listId}/tasks', [BoardController::class, 'addTask'])->name('boards.addTask');
    Route::delete('/boards/{slug}/tasks/{taskId}', [BoardController::class, 'deleteTask'])->name('boards.deleteTask');
    Route::put('/boards/{slug}/tasks/{taskId}', [BoardController::class, 'updateTaskDescription']);
    Route::get('/boards/{slug}/tasks/{taskId}', [BoardController::class, 'getTaskDetails']);
    Route::delete('/boards/{slug}', [BoardController::class, 'delete'])->name('boards.delete');

    Route::get('/boards/{slug}', [BoardController::class, 'show'])->name('boards.show');

});




















