# Deployment

## Production Stack

ReportFlow ships with:

- `Dockerfile.prod` for multi-stage frontend and PHP-FPM builds.
- `docker-compose.prod.yml` for app, Nginx, queue/scheduler, MySQL, and Redis.
- `docker/nginx/reportflow.conf` for static asset caching and PHP forwarding.
- `docker/supervisor/reportflow.conf` for queue workers and scheduler.
- `docker/production/entrypoint.sh` for migrations and Laravel cache warming.

## Environment Preparation

```bash
cp .env.production.example .env.production
```

Set at minimum:

- `APP_KEY`
- `APP_URL`
- `DB_PASSWORD`
- `DB_ROOT_PASSWORD`
- `MAIL_*`
- `AI_PROVIDER`
- `OPENAI_API_KEY` and/or `GEMINI_API_KEY`

## Build and Run

```bash
docker compose -f docker-compose.prod.yml build
docker compose -f docker-compose.prod.yml up -d
```

Run migrations explicitly:

```bash
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
```

Or set `REPORTFLOW_RUN_MIGRATIONS=true` for controlled first boot only.

## Laravel Caches

Production cache commands:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

The Docker entrypoint runs these when `REPORTFLOW_OPTIMIZE=true`.

## Health Checks

- `/live` confirms the application process responds.
- `/ready` checks database, cache, and writable storage.
- `/health` returns aggregate health and version metadata.
- `/version` returns release metadata.

## Release Checklist

1. Confirm `.env.production` contains production secrets.
2. Run `php artisan migrate --force`.
3. Run `scripts/production-cache.sh`.
4. Confirm `/ready` returns HTTP 200.
5. Confirm queue workers are running.
6. Confirm logs write to `storage/logs`.
