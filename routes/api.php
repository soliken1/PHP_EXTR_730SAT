<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BudgetController;

//Routes for Credentials
//All Users (No Conditional Parameters)
Route::get('/users', [UserController::class, 'getUsers']);
//Login Users (Refer to User Model For Body Parameters) 
Route::post('/login', [UserController::class, 'login']);
//Register Users (Refer to User Model For Body Parameters)
Route::post('/register', [UserController::class, 'register']);

//Password Reset Routes
Route::post('/password/forgot', [UserController::class, 'forgotPassword']);
Route::post('/password/reset/{token}', [UserController::class, 'resetPassword']);

//Email Verification Route For Users
Route::get('/verify-email/{id}', [UserController::class, 'verifyEmail'])
    ->name('verification.verify')
    ->middleware('signed');

//Routes for Expenses
//All Expenses (No Conditional Parameters)
Route::get('/expenses', [ExpenseController::class, 'getExpenses']);
//Get User's Expense (1 Parameter of userId)
Route::post('/userExpenses', [ExpenseController::class, 'getUserExpenses']);
//Add User Expense (Refer to Expense Model for Body Parameters)
Route::post('/addExpense', [ExpenseController::class, 'addUserExpense']);
//Update User's Expenses (Relies on UserId and ExpenseName)
Route::patch('/updateExpense/{expenseName}', [ExpenseController::class, 'updateUserExpense']);
//Delete User's Expenses (Relies on UserId and Expense Name)
Route::delete('deleteExpense/{expenseName}', [ExpenseController::class, 'deleteUserExpense']);

//Routes for Category
 //All Categories (No Conditional Parameters)
Route::get('/categories', [CategoryController::class, 'getCategories']);
//Get User's Categories (1 Parameter of userId)
Route::post('/userCategories', [CategoryController::class, 'getUserCategories']);
//Add User Category (Refer to Category Model for Body Parameters)
Route::post('/addCategory', [CategoryController::class, 'addUserCategory']);
//Update User's Category (Relies on UserId and CategoryName)
Route::patch('/updateCategory/{categoryTitle}', [CategoryController::class, 'updateUserCategory']);
//Delete User's Expenses (Relies on UserId and CategoryName)
Route::delete('deleteCategory/{categoryTitle}', [CategoryController::class, 'deleteUserCategory']);

//Routes for Budget
//All Budget (No Conditional Parameters)
Route::get('/budget', [BudgetController::class, 'getBudget']);
//Get User's Budget (1 Parameter of userId)
Route::post('/userBudgets', [BudgetController::class, 'getUserBudget']);
//Add User Budget (Refer to Budget Model for Body Parameters)
Route::post('/addBudget', [BudgetController::class, 'addBudget']);
//Update User's Budget (Relies on UserId and CategoryName)
Route::patch('/updateBudget/{categoryTitle}', [BudgetController::class, 'updateUserBudget']);
//Delete User's Expenses (Relies on UserId and CategoryName)
Route::delete('deleteBudget/{categoryTitle}', [BudgetController::class, 'deleteUserBudget']);

