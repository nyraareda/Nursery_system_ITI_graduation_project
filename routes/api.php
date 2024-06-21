<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChildrenController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\EnrollmentsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClassesController;
use App\Http\Controllers\Api\SubjectsController;
use App\Http\Controllers\Api\ActivitiesController;
use App\Http\Controllers\Api\BusEnrollmentsController;
use App\Http\Controllers\Api\GradesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SiblingController;
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

Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify');
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


Route::get('/enrollments', [EnrollmentsController::class, 'index']);
Route::get('/enrollments/{id}', [EnrollmentsController::class, 'show']);
Route::post('/enrollments', [EnrollmentsController::class, 'store']);
Route::put('/enrollments/{id}', [EnrollmentsController::class, 'update']);
Route::delete('/enrollments/{id}', [EnrollmentsController::class, 'destroy']);

// Sibling routes
Route::get('siblings', [SiblingController::class, 'index']);
Route::get('siblings/{id}', [SiblingController::class, 'show']);
Route::post('siblings', [SiblingController::class, 'store']);
Route::put('siblings/{id}', [SiblingController::class, 'update']);
Route::delete('siblings/{id}', [SiblingController::class, 'destroy']);

// Notification routes
Route::get('notifications', [NotificationController::class, 'index']);
Route::get('notifications/{id}', [NotificationController::class, 'show']);
Route::post('notifications', [NotificationController::class, 'store']);
Route::put('notifications/{id}', [NotificationController::class, 'update']);
Route::delete('notifications/{id}', [NotificationController::class, 'destroy']);


Route::get('classes', [ClassesController::class, 'index']);
Route::get('classes/{id}', [ClassesController::class, 'show']);
Route::post('classes', [ClassesController::class, 'store']);
Route::put('classes/{id}', [ClassesController::class, 'update']);
Route::delete('classes/{id}', [ClassesController::class, 'destroy']);

Route::get('subjects', [SubjectsController::class, 'index']);
Route::get('subjects/{id}', [SubjectsController::class, 'show']);
Route::post('subjects', [SubjectsController::class, 'store']);
Route::put('subjects/{id}', [SubjectsController::class, 'update']);
Route::delete('subjects/{id}', [SubjectsController::class, 'destroy']);

Route::get('activities', [ActivitiesController::class, 'index']);
Route::get('activities/{id}', [ActivitiesController::class, 'show']);
Route::post('activities', [ActivitiesController::class, 'store']);
Route::put('activities/{id}', [ActivitiesController::class, 'update']);
Route::delete('activities/{id}', [ActivitiesController::class, 'destroy']);


Route::get('bus-enrollments', [BusEnrollmentsController::class, 'index']);
Route::get('bus-enrollments/{id}', [BusEnrollmentsController::class, 'show']);
Route::post('bus-enrollments', [BusEnrollmentsController::class, 'store']);
Route::put('bus-enrollments/{id}', [BusEnrollmentsController::class, 'update']);
Route::delete('bus-enrollments/{id}', [BusEnrollmentsController::class, 'destroy']);


Route::get('grades', [GradesController::class, 'index']);
Route::get('grades/{id}', [GradesController::class, 'show']);
Route::post('grades', [GradesController::class, 'store']);
Route::put('grades/{id}', [GradesController::class, 'update']);
Route::delete('grades/{id}', [GradesController::class, 'destroy']);
