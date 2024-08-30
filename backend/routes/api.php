<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;

use App\Models\Document;
use App\Models\Transaction;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Document routes
//transactions routes
Route::get('/transactions', [TransactionController::class, 'index']);

//documents routes
Route::get('/documents', [DocumentController::class, 'index']);

//users routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {

    //transactions routes
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::put('/transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

    //documents routes
    Route::post('/documents', [DocumentController::class, 'store']);
    Route::put('/documents/{id}', [DocumentController::class, 'update']);
    Route::delete('/documents/{id}', [DocumentController::class, 'destroy']);

    //users routes
    Route::post('/logout', [AuthController::class, 'logout']);
    
    
});
//this help you to grap all routes, get all route based on deafut api method created in controllers by default
//to check those route type > php artisan route:list
// Route::resource('documents', DocumentController::class);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
