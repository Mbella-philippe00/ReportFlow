# Installation

## Prerequisites

- Docker and Docker Compose for the recommended local workflow.
- PHP 8.3+, Composer 2, Node.js 22+, and MySQL/SQLite if running without Docker.

## Local Docker Setup

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

## Manual Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

## Required Environment Values

- `APP_KEY` must be generated before production use.
- `DB_*` must point to a persistent production database.
- `CACHE_STORE`, `QUEUE_CONNECTION`, and `SESSION_DRIVER` should use Redis in production.
- `AI_PROVIDER` must be `openai` or `gemini`.
- Configure `OPENAI_API_KEY` and/or `GEMINI_API_KEY` before using AI endpoints.

## Verification

```bash
php artisan migrate:fresh --seed
php artisan test
npm run build
```
