<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');




// User Routes

Route::apiResource('users', UserController::class);

// Transaction Routes
Route::apiResource('transactions', TransactionController::class);


Route::get('/test', function () {
    return 'Test Route';
});
