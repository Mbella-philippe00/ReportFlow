# Changelog

## [1.0.0] - 2026-07-21

### Added

- Production health endpoints: `/live`, `/ready`, `/health`, and `/version`.
- Production Dockerfile, Docker Compose stack, Nginx config, Supervisor config, and entrypoint.
- Security headers middleware, upload MIME validation, configurable upload limits, and API/login rate limits.
- Structured logging channels for security, workflow, AI, administration, and JSON application logs.
- Dashboard aggregate caching and production database indexes.
- Frontend route-level lazy loading and Vite manual chunks.
- Production installation, deployment, API, user, admin, backup, troubleshooting, release, and architecture documentation.
- GitHub Actions workflow for backend tests, backend lint, frontend build, and Docker image build.

### Changed

- Replaced route-action closures with controller actions to support Laravel route caching.
- Updated environment examples with production-ready cache, Redis, session, security, upload, and release metadata settings.

### Security

- Added authentication audit logs for login success, login failure, and logout.
- Updated Guzzle packages to patched versions with no Composer advisories remaining.
- Added CSP, HSTS support, frame protection, MIME sniffing protection, referrer policy, and permissions policy headers.
