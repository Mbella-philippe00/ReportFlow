# ReportFlow

ReportFlow is an enterprise SaaS application for weekly reporting workflows, approvals, AI-assisted summaries, PowerPoint generation, activity logs, and role-based access control.

The backend is Laravel/Sanctum and the frontend is a React + TypeScript SPA served by Laravel through Vite.

## Official Local Development URL

Use this URL for all local development, browser verification, screenshots, and manual QA:

```text
http://localhost:8081
```

Do not use `http://localhost` as the ReportFlow application URL. Port `80` may be used by another local project or container on the developer machine.

## Local Environment

The local Docker/Sail mapping is configured through `APP_PORT`:

```env
APP_URL=http://localhost:8081
APP_PORT=8081
VITE_APP_NAME=ReportFlow
VITE_API_BASE_URL=/api
VITE_ROUTER_BASENAME=/
```

The React SPA is mounted by Laravel from `resources/views/welcome.blade.php` and loaded through `resources/js/main.tsx`.

## Development Commands

Start the local stack:

```bash
docker compose up -d
```

Run Vite inside the Laravel/Sail container:

```bash
docker compose exec laravel.test npm run dev
```

Run frontend checks:

```bash
docker compose exec laravel.test npm run typecheck
docker compose exec laravel.test npm run build
```

Clear Laravel caches after environment or route changes:

```bash
docker compose exec laravel.test php artisan optimize:clear
```

## Verification URLs

Use these URLs when verifying the app:

```text
http://localhost:8081
http://localhost:8081/dashboard
http://localhost:8081/login
http://localhost:8081/api/dashboard
```

Expected API behavior:

- `GET http://localhost:8081/api/dashboard` returns `401` without a Sanctum Bearer token.
- Authenticated Dashboard requests are made against same-origin `/api` endpoints.
- BrowserRouter routes such as `/dashboard` must be opened through `http://localhost:8081/dashboard`.

## Screenshot Rule

All desktop, tablet, mobile, dark mode, and light mode screenshots must use:

```text
http://localhost:8081
```

Do not capture ReportFlow screenshots from `http://localhost` unless `APP_PORT=80` has been explicitly approved for that session.