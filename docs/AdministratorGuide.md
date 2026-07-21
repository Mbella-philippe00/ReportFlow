# Administrator Guide

## Administration Center

Administrators manage enterprise configuration from the Administration Center:

- Company settings
- Departments
- Teams
- Positions
- Reporting calendars
- Workflow configuration
- Notification settings
- AI provider settings
- Feature flags
- Administration audit center

## Roles and Permissions

ReportFlow uses Laravel Policies and role-based permissions. Assign roles according to operational responsibility:

- **Super Admin:** Full platform access and enterprise configuration.
- **Manager:** Workflow review, approval queue, comments, team visibility, analytics access as allowed.
- **Employee:** Report creation, document collaboration, and personal report history.

## Workflow Operations

Approved reports are read-only. Rejected reports keep rejection context. Manager comments and workflow timestamps are recorded in the report timeline.

## Document Governance

Administrators should review upload limits in `.env.production`:

- `REPORTFLOW_UPLOAD_MAX_KB`
- `REPORTFLOW_UPLOAD_EXTENSIONS`

Uploaded files are validated by Laravel file rules, MIME/type checks, policies, and size limits.

## Security Operations

- Keep `APP_DEBUG=false` in production.
- Use HTTPS with `SESSION_SECURE_COOKIE=true`.
- Keep `REPORTFLOW_FORCE_HSTS=true` behind TLS.
- Review `storage/logs/security*.log` for login failures and logout activity.
- Review activity logs for workflow, document, and administration changes.

## AI Operations

Set `AI_PROVIDER` to `openai` or `gemini`. Configure both API keys when possible to enable fallback behavior.

## Monitoring

Add probes:

- Liveness: `/live`
- Readiness: `/ready`
- Aggregate health: `/health`
- Version: `/version`
