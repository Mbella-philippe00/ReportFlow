# Troubleshooting

## Application Will Not Boot

- Confirm `APP_KEY` is set.
- Confirm `.env.production` exists and is loaded.
- Run `php artisan config:clear` if cached config references old values.
- Check `storage/logs/laravel*.log`.

## `/ready` Returns 503

- Check database connectivity and credentials.
- Confirm Redis is reachable when using Redis cache/session/queue.
- Confirm `storage/app` and `bootstrap/cache` are writable.

## Login Fails or Gets Throttled

- Confirm credentials are valid.
- Review `storage/logs/security*.log`.
- Check `REPORTFLOW_LOGIN_RATE_LIMIT`.

## Uploads Fail

- Confirm file extension is listed in `REPORTFLOW_UPLOAD_EXTENSIONS`.
- Confirm file size is below `REPORTFLOW_UPLOAD_MAX_KB`.
- Confirm storage is writable.
- Confirm Nginx `client_max_body_size` is high enough.

## AI Provider Errors

- Confirm `AI_PROVIDER` is `openai` or `gemini`.
- Confirm provider API keys are present.
- If Gemini quota is exhausted, configure `OPENAI_API_KEY` to allow fallback.
- Review `storage/logs/ai*.log`.

## Queue Jobs Do Not Run

- Confirm `QUEUE_CONNECTION=redis` or another configured queue driver.
- Confirm Supervisor is running in the queue container.
- Run `php artisan queue:failed` to inspect failed jobs.

## Stale Routes or Config

Clear and rebuild caches:

```bash
php artisan optimize:clear
scripts/production-cache.sh
```

## Frontend Build Fails

- Run `npm ci`.
- Run `npm run typecheck`.
- Run `npm run build`.
- Check dynamic imports in `resources/js/routes/index.tsx`.
