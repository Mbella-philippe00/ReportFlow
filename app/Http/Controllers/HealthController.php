<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class HealthController extends Controller
{
    public function live(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'service' => config('app.name'),
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public function ready(): JsonResponse
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'storage' => $this->checkStorage(),
        ];

        $ready = collect($checks)->every(fn (array $check): bool => $check['ok']);

        return response()->json([
            'status' => $ready ? 'ready' : 'degraded',
            'checks' => $checks,
            'timestamp' => now()->toIso8601String(),
        ], $ready ? 200 : 503);
    }

    public function health(): JsonResponse
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'storage' => $this->checkStorage(),
        ];

        $healthy = collect($checks)->every(fn (array $check): bool => $check['ok']);

        return response()->json([
            'status' => $healthy ? 'healthy' : 'degraded',
            'service' => config('app.name'),
            'version' => config('reportflow.version'),
            'release' => config('reportflow.release'),
            'checks' => $checks,
            'timestamp' => now()->toIso8601String(),
        ], $healthy ? 200 : 503);
    }

    public function version(): JsonResponse
    {
        return response()->json([
            'name' => config('app.name'),
            'version' => config('reportflow.version'),
            'release' => config('reportflow.release'),
            'commit' => config('reportflow.commit'),
            'environment' => app()->environment(),
        ]);
    }

    private function checkDatabase(): array
    {
        try {
            DB::select('select 1');

            return ['ok' => true];
        } catch (Throwable $exception) {
            report($exception);

            return ['ok' => false, 'message' => 'Database connection failed.'];
        }
    }

    private function checkCache(): array
    {
        try {
            $key = 'reportflow:readiness:'.config('reportflow.version');
            Cache::put($key, true, now()->addSeconds((int) config('reportflow.cache.readiness_ttl', 15)));

            return ['ok' => Cache::get($key) === true];
        } catch (Throwable $exception) {
            report($exception);

            return ['ok' => false, 'message' => 'Cache store is unavailable.'];
        }
    }

    private function checkStorage(): array
    {
        try {
            Storage::disk(config('filesystems.default'))->exists('.');

            return ['ok' => is_writable(storage_path('app'))];
        } catch (Throwable $exception) {
            report($exception);

            return ['ok' => false, 'message' => 'Storage is unavailable.'];
        }
    }
}
