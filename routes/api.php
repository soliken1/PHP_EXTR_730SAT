<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;


Route::get('/users', [UserController::class, 'getUsers']);

Route::post('/register', [UserController::class, 'register']);

Route::get('/expenses', [ExpenseController::class, 'getExpenses']);

Route::post('/userExpenses', [ExpenseController::class, 'getUserExpenses']);

Route::get('/verify-email/{id}', [UserController::class, 'verifyEmail'])
    ->name('verification.verify')
    ->middleware('signed');