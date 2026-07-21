<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

Route::get('/health', [HealthController::class, 'health']);
Route::get('/ready', [HealthController::class, 'ready']);
Route::get('/live', [HealthController::class, 'live']);
Route::get('/version', [HealthController::class, 'version']);

Route::get('/{any?}', FrontendController::class)
    ->where('any', '^(?!api|health|ready|live|version).*$');
