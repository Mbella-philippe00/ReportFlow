<?php

use App\Http\Controllers\Api\AdministrationController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->controller(AdministrationController::class)
    ->group(function () {
        Route::get('/overview', 'overview');
        Route::get('/audit', 'audit');
        Route::put('/company-settings', 'updateCompanySettings');
        Route::post('/departments', 'storeDepartment');
        Route::put('/departments/{department}', 'updateDepartment');
        Route::delete('/departments/{department}', 'destroyDepartment');
        Route::post('/teams', 'storeTeam');
        Route::put('/teams/{team}', 'updateTeam');
        Route::delete('/teams/{team}', 'destroyTeam');
        Route::post('/positions', 'storePosition');
        Route::put('/positions/{position}', 'updatePosition');
        Route::delete('/positions/{position}', 'destroyPosition');
        Route::post('/reporting-calendars', 'storeReportingCalendar');
        Route::put('/reporting-calendars/{calendar}', 'updateReportingCalendar');
        Route::delete('/reporting-calendars/{calendar}', 'destroyReportingCalendar');
        Route::post('/workflow-configurations', 'storeWorkflowConfiguration');
        Route::put('/workflow-configurations/{workflow}', 'updateWorkflowConfiguration');
        Route::put('/notification-settings', 'upsertNotificationSetting');
        Route::put('/ai-settings', 'upsertAiSetting');
        Route::put('/feature-flags', 'upsertFeatureFlag');
    });
