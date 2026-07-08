# Local Development

## Canonical Local URL

The official ReportFlow local development URL is:

```text
http://localhost:8081
```

All future commands, browser checks, screenshots, manual QA, and frontend verification must use `http://localhost:8081` as the application origin.

Do not assume `http://localhost` points to ReportFlow. Port `80` can be occupied by another local Docker stack or unrelated Laravel application.

## Environment Variables

Use the following local defaults:

```env
APP_NAME=ReportFlow
APP_URL=http://localhost:8081
APP_PORT=8081
VITE_APP_NAME=ReportFlow
VITE_API_BASE_URL=/api
VITE_ROUTER_BASENAME=/
```

`VITE_API_BASE_URL=/api` keeps React API calls same-origin through Laravel at `http://localhost:8081/api`.

## Docker/Sail

Start ReportFlow without changing other Docker containers:

```bash
docker compose up -d
```

Run commands inside the Laravel/Sail container:

```bash
docker compose exec laravel.test php artisan optimize:clear
docker compose exec laravel.test npm run dev
docker compose exec laravel.test npm run typecheck
docker compose exec laravel.test npm run build
```

Do not stop unrelated Docker containers to claim port `80`. ReportFlow is intentionally documented on `8081` for local development.

## Runtime Verification

Verify the Laravel shell:

```bash
curl -I http://localhost:8081
curl -I http://localhost:8081/dashboard
```

Verify protected API behavior:

```bash
curl -H "Accept: application/json" http://localhost:8081/api/dashboard
```

Expected unauthenticated response: `401`.

## BrowserRouter Verification

Open frontend routes directly through the canonical origin:

```text
http://localhost:8081/dashboard
http://localhost:8081/reports
http://localhost:8081/workflow
```

Laravel must return the SPA shell for those frontend routes while keeping `/api/*` under Laravel API routing.

## Screenshot Verification

Use `http://localhost:8081` for every screenshot target:

- Desktop: `http://localhost:8081/dashboard`
- Tablet: `http://localhost:8081/dashboard`
- Mobile: `http://localhost:8081/dashboard`
- Dark mode: `http://localhost:8081/dashboard`
- Light mode: `http://localhost:8081/dashboard`