<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ReportWorkflowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected API
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [
        AuthController::class,
        'logout',
    ]);

    Route::get('/me', [
        AuthController::class,
        'me',
    ]);

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    Route::get('/user', fn (Request $request) => $request->user());

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'show',
    ]);

    Route::put('/profile', [
        ProfileController::class,
        'update',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    Route::prefix('notifications')
        ->controller(NotificationController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/unread-count', 'unreadCount');
            Route::patch('/read-all', 'markAllAsRead');
            Route::get('/{notification}', 'show');
            Route::patch('/{notification}/read', 'markAsRead');
            Route::patch('/{notification}/archive', 'archive');
            Route::patch('/{notification}/restore', 'restore');
            Route::delete('/{notification}', 'destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | Employees
    |--------------------------------------------------------------------------
    */

    Route::get('/employees/{employee}/reports', [
        EmployeeController::class,
        'reports',
    ]);

    Route::get('/employees/{employee}/activity', [
        EmployeeController::class,
        'activity',
    ]);

    Route::apiResource('employees', EmployeeController::class);

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::apiResource('reports', ReportController::class);

    Route::controller(ReportWorkflowController::class)
        ->prefix('reports/{report}')
        ->group(function () {

            Route::post('/submit', 'submit');

            Route::post('/approve', 'approve');

            Route::post('/final-approve', 'finalApprove');

            Route::post('/reject', 'reject');

        });
});
