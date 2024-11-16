<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;

//Routes for Credentials
//All Users (No Conditional Parameters)
Route::get('/users', [UserController::class, 'getUsers']);
//Register Users (Refer to User Model For Body Parameters)
Route::post('/register', [UserController::class, 'register']);
//Email Verification Route For Users
Route::get('/verify-email/{id}', [UserController::class, 'verifyEmail'])
    ->name('verification.verify')
    ->middleware('signed');

//Routes for Expenses
//All Expenses (No Conditional Parameters)
Route::get('/expenses', [ExpenseController::class, 'getExpenses']);
//Get User's Expense (1 Parameter of userId)
Route::post('/userExpenses', [ExpenseController::class, 'getUserExpenses']);

//Routes for Category
 //All Categories (No Conditional Parameters)
Route::get('/categories', [CategoryController::class, 'getCategories']);
//Get User's Expenses (1 Parameter of userId)
Route::post('/userCategories', [CategoryController::class, 'getUserCategories']);
