<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;


Route::get('/users', [UserController::class, 'getUsers']);
Route::post('/register', [UserController::class, 'register']);
