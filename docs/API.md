# API Reference

All protected endpoints require a Sanctum bearer token:

```http
Authorization: Bearer <token>
Accept: application/json
```

## Authentication

- `POST /api/login` authenticates a user and returns a bearer token.
- `POST /api/logout` revokes the current token.
- `GET /api/me` returns the authenticated user, roles, and employee profile.
- `GET /api/user` returns the authenticated user for Sanctum compatibility.

## Dashboard

- `GET /api/dashboard` returns summary statistics, workflow KPIs, recent reports, pending reports, and charts.

## Reports

- `GET /api/reports`
- `POST /api/reports`
- `GET /api/reports/{report}`
- `PUT/PATCH /api/reports/{report}`
- `DELETE /api/reports/{report}`

Workflow:

- `GET /api/reports/workflow/queue`
- `GET /api/reports/{report}/timeline`
- `POST /api/reports/{report}/submit`
- `POST /api/reports/{report}/approve`
- `POST /api/reports/{report}/final-approve`
- `POST /api/reports/{report}/reject`

## Documents

- `GET /api/reports/{report}/documents`
- `POST /api/reports/{report}/documents`
- `GET /api/reports/{report}/documents/{document}`
- `PUT/PATCH /api/reports/{report}/documents/{document}`
- `DELETE /api/reports/{report}/documents/{document}`
- `GET /api/reports/{report}/documents/{document}/download`
- `GET /api/reports/{report}/documents/{document}/preview`
- `GET /api/reports/{report}/documents/{document}/versions`
- `POST /api/reports/{report}/documents/{document}/versions`
- `GET /api/reports/{report}/documents/{document}/comments`
- `POST /api/reports/{report}/documents/{document}/comments`
- `PATCH /api/reports/{report}/documents/{document}/comments/{comment}`
- `DELETE /api/reports/{report}/documents/{document}/comments/{comment}`
- `GET /api/reports/{report}/documents/{document}/activity`

## Analytics

- `GET /api/analytics/overview`
- `GET /api/analytics/executive-dashboard`
- `GET /api/analytics/kpi-center`
- `GET /api/analytics/comparisons`
- `GET /api/analytics/alerts`
- `GET /api/analytics/executive-report`
- `GET /api/analytics/export`
- `GET /api/analytics/export-options`

## AI

- `GET /api/ai/dashboard`
- `GET /api/ai/history`
- `GET /api/ai/providers`
- `POST /api/ai/reports/{report}/assist`
- `POST /api/ai/reports/{report}/executive-summary`
- `POST /api/ai/reports/{report}/improve-writing`
- `POST /api/ai/reports/{report}/grammar-tone`
- `POST /api/ai/reports/{report}/action-items`
- `POST /api/ai/reports/{report}/risk-analysis`
- `POST /api/ai/reports/{report}/quality-score`
- `POST /api/ai/reports/{report}/workflow-recommendation`

## Administration

Administration endpoints are nested under `/api/admin/*` and require administration policies:

- Company settings
- Departments
- Teams
- Positions
- Reporting calendars
- Workflow configurations
- Notification settings
- AI settings
- Feature flags
- Audit center

## Monitoring

- `GET /live`
- `GET /ready`
- `GET /health`
- `GET /version`
