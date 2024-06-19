<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChildrenController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\FeesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/children', [ChildrenController::class, 'index']);
Route::get('/children/{id}', [ChildrenController::class, 'show']);
Route::post('/children', [ChildrenController::class, 'store']);
Route::put('/children/{id}', [ChildrenController::class, 'update']);
Route::delete('/children/{id}', [ChildrenController::class, 'destroy']);

Route::get('/applications', [ApplicationController::class, 'index']);
Route::get('/applications/{id}', [ApplicationController::class, 'show']);
Route::post('/applications', [ApplicationController::class, 'store']);
Route::put('/applications/{id}', [ApplicationController::class, 'update']);
Route::delete('/applications/{id}', [ApplicationController::class, 'destroy']);

Route::get('/fees', [FeesController::class, 'index']);
Route::get('/fees/{id}', [FeesController::class, 'show']);
Route::post('/fees', [FeesController::class, 'store']);
Route::put('/fees/{id}', [FeesController::class, 'update']);
Route::delete('/fees/{id}', [FeesController::class, 'destroy']);



