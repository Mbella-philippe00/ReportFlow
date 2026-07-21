# ReportFlow

ReportFlow is an enterprise weekly reporting platform that turns employee updates into reviewed decisions, executive KPIs, searchable documents, and AI-assisted insights.

## Version

Current release: `1.0.0`

## Core Capabilities

- Authentication and Sanctum API access.
- Role and policy-based authorization.
- Weekly report workflow: Draft, Submitted, Under Review, Approved, Rejected.
- Manager queues, comments, timelines, read-only approved reports, notifications, and activity logs.
- Document management with attachments, version history, previews, metadata, threaded comments, and mentions.
- AI assistant with OpenAI/Gemini provider resolution and fallback behavior.
- Analytics, KPI center, executive dashboard, exports, comparisons, and smart alerts.
- Enterprise administration for company settings, departments, teams, positions, calendars, workflow configuration, notification settings, AI settings, feature flags, and audits.
- Premium responsive React UI with route-level lazy loading.

## Technology

- Laravel 13, PHP 8.3, Sanctum, Eloquent, Policies, Notifications, Spatie Activity Log.
- React 19, TypeScript, Vite, React Query, React Router, Tailwind CSS.
- MySQL, Redis-ready cache/session/queue configuration, local or object storage for documents.
- Production Docker image with Nginx, PHP-FPM, Supervisor, and opcache.

## Local Development

```bash
docker compose up -d
docker compose exec laravel.test composer install
docker compose exec laravel.test npm install
docker compose exec laravel.test cp .env.example .env
docker compose exec laravel.test php artisan key:generate
docker compose exec laravel.test php artisan migrate --seed
docker compose exec laravel.test npm run dev
```

Local app URL:

```text
http://localhost:8081
```

## Validation

```bash
docker compose exec laravel.test php artisan test
docker compose exec laravel.test npm run build
```

Production cache smoke check:

```bash
docker compose exec laravel.test php artisan config:cache
docker compose exec laravel.test php artisan route:cache
docker compose exec laravel.test php artisan view:cache
docker compose exec laravel.test php artisan event:cache
docker compose exec laravel.test php artisan optimize:clear
```

## Production Deployment

```bash
cp .env.production.example .env.production
docker compose -f docker-compose.prod.yml build
docker compose -f docker-compose.prod.yml up -d
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
```

Health endpoints:

- `/live`
- `/ready`
- `/health`
- `/version`

## Documentation

- `docs/Architecture.md`
- `docs/Installation.md`
- `docs/Deployment.md`
- `docs/API.md`
- `docs/AdministratorGuide.md`
- `docs/UserGuide.md`
- `docs/Backup.md`
- `docs/ReleaseNotes.md`
- `docs/Troubleshooting.md`
- `docs/ProductionReadinessReport.md`

## Security Notes

- Keep `APP_DEBUG=false` in production.
- Use HTTPS with `SESSION_SECURE_COOKIE=true`.
- Configure `REPORTFLOW_FORCE_HSTS=true` only behind TLS.
- Review `REPORTFLOW_UPLOAD_EXTENSIONS` and `REPORTFLOW_UPLOAD_MAX_KB` before launch.
- Configure both `OPENAI_API_KEY` and `GEMINI_API_KEY` when possible for AI fallback.

## License

ReportFlow is released under the MIT License. See `LICENSE`.
