<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']);
Route::get('/test', function () {
    return 'Test route is working!';
});
Route::get('/phpinfo', function () {
    phpinfo();
});

