# Contributing to ReportFlow

## Development Principles

- Preserve existing workflow, analytics, AI, document, and administration behavior unless a task explicitly changes it.
- Keep authorization policy-driven.
- Add tests for new behavior.
- Prefer services for business logic and controllers for HTTP orchestration.
- Keep React feature modules lazy-loadable where practical.

## Local Validation

Run before opening a pull request:

```bash
php artisan test
npm run build
```

For PHP style:

```bash
./vendor/bin/pint --test
```

## Branches and Commits

- Use focused branches.
- Keep commits small and descriptive.
- Include migration notes when schema changes are introduced.

## Security

- Do not commit secrets.
- Keep `APP_DEBUG=false` in production examples.
- Validate uploads with size and MIME/type restrictions.
- Use policies for protected resources.

## Pull Request Checklist

- Tests pass.
- Frontend builds.
- Documentation is updated when behavior or operations change.
- New endpoints are policy-protected where required.
- Production config or deployment changes are noted in `docs/Deployment.md`.
