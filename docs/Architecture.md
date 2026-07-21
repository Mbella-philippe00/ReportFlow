# ReportFlow Architecture

ReportFlow is a Laravel API with a React/TypeScript SPA. Laravel owns authentication, authorization, workflow, documents, notifications, AI orchestration, analytics, logging, and production health endpoints. React consumes same-origin `/api` endpoints and is served by Laravel/Nginx.

## Runtime Components

- **Frontend:** React, TypeScript, Vite, React Router, React Query, Tailwind CSS.
- **Backend:** Laravel, Sanctum, Eloquent, Policies, Notifications, Spatie Activity Log.
- **Storage:** MySQL for relational data, Redis-ready cache/queue/session configuration, local or object storage for documents.
- **AI:** Dynamic provider resolver for OpenAI and Gemini with fallback behavior.
- **Workers:** Laravel queue workers and scheduler managed by Supervisor in production.
- **Web Server:** Nginx serves static assets and forwards PHP requests to PHP-FPM.

## Module Boundaries

- **Authentication:** Token-based API auth through Sanctum.
- **Authorization:** Laravel Policies protect reports, documents, analytics, AI, notifications, and administration.
- **Weekly Reports:** Core report CRUD plus workflow state machine and immutable approved/read-only handling.
- **Workflow:** Draft, Submitted, Under Review, Approved, and Rejected transitions with timeline, manager comments, notifications, and activity log entries.
- **Documents:** Attachment upload, versioning, previews, metadata, comments, mentions, notifications, and timeline activity.
- **Analytics:** Dashboard, KPI center, executive comparisons, exports, alerts, and workflow metrics.
- **Administration:** Company settings, departments, teams, positions, calendars, workflow configuration, notification settings, AI settings, feature flags, and audit center.

## Production Readiness Additions

- Health endpoints: `/live`, `/ready`, `/health`, `/version`.
- Route-cache compatibility by removing route-action closures.
- Central `config/reportflow.php` for version, cache TTLs, upload limits, security headers, and rate limits.
- Security headers middleware for CSP, frame protection, MIME sniffing protection, referrer policy, permissions policy, and HSTS.
- Dedicated log channels for security, workflow, AI, administration, and structured JSON logs.
- Production Docker image, Nginx config, Supervisor config, and production Compose stack.
- Dashboard aggregate caching and database indexes for workflow, documents, notifications, and activity timelines.

## Data Flow

1. Users authenticate through `/api/login` and receive a Sanctum bearer token.
2. React Query sends authenticated API requests to `/api/*`.
3. Controllers validate requests, authorize through policies, and delegate to services.
4. Services preserve business rules, write activity logs, dispatch notifications, and return resources.
5. Workers process queued jobs and scheduled tasks.
6. Monitoring probes `/live`, `/ready`, `/health`, and `/version`.
