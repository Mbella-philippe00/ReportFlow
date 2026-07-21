<?php

use App\Http\Controllers\Api\AdministrationController;
use App\Http\Controllers\Api\AiController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ReportDocumentController;
use App\Http\Controllers\Api\ReportWorkflowController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');

/*
|--------------------------------------------------------------------------
| Protected API
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
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

    Route::get('/user', [AuthController::class, 'user']);

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
    | Analytics
    |--------------------------------------------------------------------------
    */

    require __DIR__.'/admin.php';

    Route::prefix('analytics')
        ->controller(AnalyticsController::class)
        ->group(function () {
            Route::get('/overview', 'overview');
            Route::get('/executive-dashboard', 'executiveDashboard');
            Route::get('/kpi-center', 'kpiCenter');
            Route::get('/comparisons', 'comparisons');
            Route::get('/alerts', 'alerts');
            Route::get('/executive-report', 'executiveReport');
            Route::get('/export', 'export');
            Route::get('/trends', 'trends');
            Route::get('/reports', 'reports');
            Route::get('/employees', 'employees');
            Route::get('/departments', 'departments');
            Route::get('/workflow', 'workflow');
            Route::get('/activity', 'activity');
            Route::get('/export-options', 'exportOptions');
        });


    /*
    |--------------------------------------------------------------------------
    | AI Assistant
    |--------------------------------------------------------------------------
    */

    Route::prefix('ai')
        ->controller(AiController::class)
        ->group(function () {
            Route::get('/dashboard', 'dashboard');
            Route::get('/history', 'history');
            Route::get('/providers', 'providers');

            Route::post('/reports/{report}/assist', 'assist');
            Route::post('/reports/{report}/executive-summary', 'executiveSummary');
            Route::post('/reports/{report}/improve-writing', 'improveWriting');
            Route::post('/reports/{report}/writing-suggestions', 'writingSuggestions');
            Route::post('/reports/{report}/grammar-tone', 'grammarTone');
            Route::post('/reports/{report}/action-items', 'actionItems');
            Route::post('/reports/{report}/risk-analysis', 'riskAnalysis');
            Route::post('/reports/{report}/priority-detection', 'priorityDetection');
            Route::post('/reports/{report}/missing-information', 'missingInformation');
            Route::post('/reports/{report}/quality-score', 'qualityScore');
            Route::post('/reports/{report}/workflow-recommendation', 'workflowRecommendation');
            Route::post('/reports/{report}/powerpoint-summary', 'powerpointSummary');
        });

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

    Route::get('/reports/workflow/queue', [ReportWorkflowController::class, 'queue']);

    Route::apiResource('reports', ReportController::class);

    Route::controller(ReportDocumentController::class)
        ->prefix('reports/{report}/documents')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{document}', 'show');
            Route::match(['put', 'patch'], '/{document}', 'update');
            Route::delete('/{document}', 'destroy');
            Route::get('/{document}/download', 'download');
            Route::get('/{document}/preview', 'preview');
            Route::get('/{document}/versions', 'versions');
            Route::post('/{document}/versions', 'storeVersion');
            Route::get('/{document}/comments', 'comments');
            Route::post('/{document}/comments', 'storeComment');
            Route::patch('/{document}/comments/{comment}', 'updateComment');
            Route::delete('/{document}/comments/{comment}', 'destroyComment');
            Route::get('/{document}/activity', 'activity');
        });

    Route::controller(ReportWorkflowController::class)
        ->prefix('reports/{report}')
        ->group(function () {

            Route::get('/timeline', 'timeline');

            Route::post('/submit', 'submit');

            Route::post('/approve', 'approve');

            Route::post('/final-approve', 'finalApprove');

            Route::post('/reject', 'reject');

        });
});
