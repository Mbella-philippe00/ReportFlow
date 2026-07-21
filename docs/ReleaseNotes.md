# Release Notes

## Version 1.0.0

ReportFlow 1.0.0 is the production-readiness release for the completed enterprise reporting platform.

### Highlights

- Production monitoring endpoints for live, ready, health, and version checks.
- Production Dockerfile, Docker Compose stack, Nginx, Supervisor, and entrypoint.
- Security headers, upload MIME validation, configurable file-size limits, and rate limiting.
- Dedicated logging channels for security, workflow, AI, administration, and JSON logs.
- Dashboard aggregate caching and targeted production database indexes.
- Frontend route-level lazy loading and vendor chunk separation.
- Complete production, administration, user, backup, troubleshooting, and API documentation.

### Compatibility

- PHP 8.3+
- Node.js 22+
- MySQL 8.4+
- Redis 7+

### Upgrade Notes

Run:

```bash
php artisan migrate --force
scripts/production-cache.sh
```

Confirm `/ready` returns HTTP 200 after deployment.
