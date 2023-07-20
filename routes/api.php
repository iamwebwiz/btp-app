<?php

use App\Http\Controllers\Api\FieldsController;
use App\Http\Controllers\Api\SubscribersController;
use Illuminate\Support\Facades\Route;

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

Route::get('/subscribers', [SubscribersController::class, 'index']);
Route::post('/subscribers', [SubscribersController::class, 'store']);
Route::get('/subscribers/{id}', [SubscribersController::class, 'show']);
Route::patch('/subscribers/{id}', [SubscribersController::class, 'update']);
Route::post('/subscribers/{id}/fields', [SubscribersController::class, 'upsertFields']);
Route::delete('/subscribers/{id}', [SubscribersController::class, 'destroy']);

Route::get('/fields', [FieldsController::class, 'index']);
Route::post('/fields', [FieldsController::class, 'store']);
Route::get('/fields/{id}', [FieldsController::class, 'show']);
Route::patch('/fields/{id}', [FieldsController::class, 'update']);
Route::delete('/fields/{id}', [FieldsController::class, 'destroy']);
