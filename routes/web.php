<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketsController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'loginPost'])->name('login.post');


Route::middleware('auth')->group(function () {
    Route::get('/', [TicketsController::class, 'index'])->name('dashboard');
    Route::get('/ticket', [TicketsController::class, 'ticket'])->name('ticket');
    Route::get('/tickets/{id}', [TicketsController::class, 'show'])->name('tickets.show');
    Route::post('/ticket', [TicketsController::class, 'store'])->name('tickets.store');
    Route::patch('/tickets/{id}/status', [TicketsController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});