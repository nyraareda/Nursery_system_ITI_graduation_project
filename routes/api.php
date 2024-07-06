<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChildrenController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\EnrollmentsController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClassesController;
use App\Http\Controllers\Api\SubjectsController;
use App\Http\Controllers\Api\ActivitiesController;
use App\Http\Controllers\Api\CurriculumController;
use App\Http\Controllers\Api\GradesController;
use App\Http\Controllers\SiblingController;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ChildCurriculumController;

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
    Route::post('/password/email', [AuthController::class, 'sendPasswordResetLink']);
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);
});

Route::group(['middleware' => ['api', 'auth:api', 'role:admin']], function () {

    Route::get('/children', [ChildrenController::class, 'index']);
    Route::get('/children/{id}', [ChildrenController::class, 'show']);
    Route::post('/children', [ChildrenController::class, 'store']);
    Route::put('/children/{id}', [ChildrenController::class, 'update']);
    Route::delete('/children/{id}', [ChildrenController::class, 'destroy']);
    Route::put('children/{id}/update-status', [ChildrenController::class, 'updateStatus']);
    Route::get('/parents/{parentId}/children', [ChildrenController::class, 'getChildrenByParentId']);


// Application routes
Route::get('/applications', [ApplicationController::class, 'index']);
Route::get('/applications/{id}', [ApplicationController::class, 'show']);
Route::post('/applications', [ApplicationController::class, 'store']);
Route::put('/applications/{id}', [ApplicationController::class, 'update']);
Route::delete('/applications/{id}', [ApplicationController::class, 'destroy']);

// Enrollment routes
Route::get('/enrollments', [EnrollmentsController::class, 'index']);
Route::get('/enrollments/{id}', [EnrollmentsController::class, 'show']);
Route::post('/enrollments', [EnrollmentsController::class, 'store']);
Route::put('/enrollments/{id}', [EnrollmentsController::class, 'update']);
Route::delete('/enrollments/{id}', [EnrollmentsController::class, 'destroy']);


// Subject routes
Route::get('subjects', [SubjectsController::class, 'index']);
Route::get('subjects/{id}', [SubjectsController::class, 'show']);
Route::post('subjects', [SubjectsController::class, 'store']);
Route::put('subjects/{id}', [SubjectsController::class, 'update']);
Route::delete('subjects/{id}', [SubjectsController::class, 'destroy']);
Route::get('subjects/level/{levelId}', [SubjectsController::class, 'getByLevel']);
Route::get('subjects/children-with-grades', [SubjectsController::class, 'getChildwithGrade']);
Route::get('subjects/curriculum/{curriculum_id}', [SubjectsController::class, 'getByLevel']);

// Activity routes
Route::get('activities', [ActivitiesController::class, 'index']);
Route::get('activities/{id}', [ActivitiesController::class, 'show']);
Route::post('activities', [ActivitiesController::class, 'store']);
Route::put('activities/{id}', [ActivitiesController::class, 'update']);
Route::delete('activities/{id}', [ActivitiesController::class, 'destroy']);
Route::post('activities/{id}/add-child', [ActivitiesController::class, 'addChildToActivity']);
Route::get('activities/child/{childId}', [ActivitiesController::class, 'getActivitiesForChild']);
Route::get('activities/{id}/details', [ActivitiesController::class, 'getActivityDetails']);
Route::put('activities/{id}/details', [ActivitiesController::class, 'updateActivityDetails']);
Route::delete('activities/delete-similar/{activityName}', [ActivitiesController::class, 'deleteSimilarActivities']);
Route::put('activities/update-similar/{activityName}', [ActivitiesController::class, 'updateSimilarActivities']);
Route::post('activities/simple', [ActivitiesController::class, 'storeActivityWithNameAndDescription']);

// Curriculum routes
Route::get('curriculums', [CurriculumController::class, 'index']);
Route::get('curriculums/{id}', [CurriculumController::class, 'show']);
Route::post('curriculums', [CurriculumController::class, 'store']);
Route::put('curriculums/{id}', [CurriculumController::class, 'update']);
Route::delete('curriculums/{id}', [CurriculumController::class, 'destroy']);
// Grade routes
Route::get('grades', [GradesController::class, 'index']);
Route::get('grades/{id}', [GradesController::class, 'show']);
Route::post('grades', [GradesController::class, 'store']);
Route::put('grades/{id}', [GradesController::class, 'update']);
Route::delete('grades/{id}', [GradesController::class, 'destroy']);
Route::get('grades/child/{child_id}', [GradesController::class, 'getGradesByChild']);
Route::put('grades/child/{child_id}', [GradesController::class, 'updateGradesByChild']);
// Parent routes
Route::get('parents', [ParentController::class, 'index']);
Route::get('parents/{id}', [ParentController::class, 'show']);
Route::post('parents', [ParentController::class, 'store']);
Route::put('parents/{id}', [ParentController::class, 'update']);
Route::delete('parents/{id}', [ParentController::class, 'destroy']);
Route::get('parent', [ParentController::class, 'getAllParents']);

// Notification routes
Route::get('notifications', [NotificationController::class, 'index']);
Route::get('notifications/{id}', [NotificationController::class, 'show']);
Route::post('notifications', [NotificationController::class, 'store']);
Route::put('notifications/{id}', [NotificationController::class, 'update']);
Route::delete('notifications/{id}', [NotificationController::class, 'destroy']);

Route::get('child-curriculums', [ChildCurriculumController::class, 'index']);
Route::get('child-curriculums/{id}', [ChildCurriculumController::class, 'show']);
Route::post('child-curriculums', [ChildCurriculumController::class, 'store']);
Route::put('child-curriculums/{id}', [ChildCurriculumController::class, 'update']);
Route::delete('child-curriculums/{id}', [ChildCurriculumController::class, 'destroy']);
Route::get('curriculums/{curriculum}/children', [ChildCurriculumController::class, 'getChildrenByCurriculum']);
Route::get('curriculums/{curriculum}/children/{child}', [ChildCurriculumController::class, 'getChildById']);
Route::get('curriculums/{curriculum}/children/{child}/subjects', [ChildCurriculumController::class, 'getSubjectsByCurriculumAndChild']);



});

// Route::group(['middleware' => ['api', 'auth:api', 'role:parent']], function () {

    Route::get('/children', [ChildrenController::class, 'index']);
    Route::get('/children/{id}', [ChildrenController::class, 'show']);
    Route::post('/children', [ChildrenController::class, 'store']);
    Route::put('/children/{id}', [ChildrenController::class, 'update']);
    Route::put('children/{id}/update-status', [ChildrenController::class, 'updateStatus']);
    Route::get('/parents/{parentId}/children', [ChildrenController::class, 'getChildrenByParentId']);

    Route::get('subjects', [SubjectsController::class, 'index']);
    Route::get('subjects/{id}', [SubjectsController::class, 'show']);
    Route::get('activities/child/{childId}', [ActivitiesController::class, 'getActivitiesForChild']);
    // Curriculum routes
Route::get('curriculums', [CurriculumController::class, 'index']);
Route::get('curriculums/{id}', [CurriculumController::class, 'show']);
Route::get('grades/child/{child_id}', [GradesController::class, 'getGradesByChild']);
// Parent routes
Route::get('parents', [ParentController::class, 'index']);
Route::get('parents/{id}', [ParentController::class, 'show']);
Route::post('parents', [ParentController::class, 'store']);
Route::put('parents/{id}', [ParentController::class, 'update']);

Route::get('parent', [ParentController::class, 'getAllParents']);

// });

Route::get('/packages', [PackageController::class, 'index']);
Route::get('/packages/{id}', [PackageController::class, 'show']);
Route::post('/packages', [PackageController::class, 'store']);
Route::put('/packages/{id}', [PackageController::class, 'update']);
Route::delete('/packages/{id}', [PackageController::class, 'destroy']);





// Sibling routes
Route::get('siblings', [SiblingController::class, 'index']);
Route::get('siblings/{id}', [SiblingController::class, 'show']);
Route::post('siblings', [SiblingController::class, 'store']);
Route::put('siblings/{id}', [SiblingController::class, 'update']);
Route::delete('siblings/{id}', [SiblingController::class, 'destroy']);












Route::get('child-curriculums', [ChildCurriculumController::class, 'index']);
Route::get('child-curriculums/{id}', [ChildCurriculumController::class, 'show']);
Route::post('child-curriculums', [ChildCurriculumController::class, 'store']);
Route::put('child-curriculums/{id}', [ChildCurriculumController::class, 'update']);
Route::delete('child-curriculums/{id}', [ChildCurriculumController::class, 'destroy']);
Route::get('curriculums/{curriculum}/children', [ChildCurriculumController::class, 'getChildrenByCurriculum']);
Route::get('curriculums/{curriculum}/children/{child}', [ChildCurriculumController::class, 'getChildById']);
Route::get('curriculums/{curriculum}/children/{child}/subjects', [ChildCurriculumController::class, 'getSubjectsByCurriculumAndChild']);

