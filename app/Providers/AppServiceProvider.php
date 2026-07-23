<?php

namespace App\Providers;

use App\Models\DocumentComment;
use App\Models\ReportDocument;
use App\Models\WeeklyReport;
use App\Policies\AiPolicy;
use App\Policies\AnalyticsPolicy;
use App\Policies\AdministrationPolicy;
use App\Policies\DatabaseNotificationPolicy;
use App\Policies\DocumentCommentPolicy;
use App\Policies\ReportDocumentPolicy;
use App\Policies\WeeklyReportPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
        URL::forceScheme('https');
    }
        Gate::policy(DatabaseNotification::class, DatabaseNotificationPolicy::class);
        Gate::policy(DocumentComment::class, DocumentCommentPolicy::class);
        Gate::policy(ReportDocument::class, ReportDocumentPolicy::class);
        Gate::policy(WeeklyReport::class, WeeklyReportPolicy::class);
        Gate::define('viewAdministration', [AdministrationPolicy::class, 'view']);
        Gate::define('manageAdministration', [AdministrationPolicy::class, 'manage']);
        Gate::define('viewAdministrationAudit', [AdministrationPolicy::class, 'viewAudit']);
        Gate::define('viewAnalytics', [AnalyticsPolicy::class, 'view']);
        Gate::define('viewAiDashboard', [AiPolicy::class, 'viewDashboard']);
        Gate::define('viewAiHistory', [AiPolicy::class, 'viewHistory']);
        Gate::define('viewAiProviders', [AiPolicy::class, 'viewProviders']);
        Gate::define('useAiForReport', [AiPolicy::class, 'useForReport']);
        Gate::define('recommendAiWorkflow', [AiPolicy::class, 'recommendWorkflow']);

        RateLimiter::for('api', function (Request $request): Limit {
            return Limit::perMinute((int) config('reportflow.rate_limits.api_per_minute', 120))
                ->by((string) ($request->user()?->id ?? $request->ip()));
        });

        RateLimiter::for('login', function (Request $request): Limit {
            $email = Str::lower((string) $request->input('email'));

            return Limit::perMinute((int) config('reportflow.rate_limits.login_per_minute', 5))
                ->by($email.'|'.$request->ip());
        });
    }
}
