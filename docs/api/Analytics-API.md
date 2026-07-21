# Analytics API

ReportFlow exposes analytics through authenticated REST endpoints under `/api/analytics`.

## Authentication

All endpoints require a valid Sanctum bearer token.

## Authorization

Analytics access is restricted to users with one of these roles:

- `manager`
- `super-admin`

Employees receive `403 Forbidden`.

## Shared Filters

All analytics endpoints except `export-options` accept the same optional query filters.

| Parameter | Type | Values | Description |
| --- | --- | --- | --- |
| `period` | string | `today`, `last_7_days`, `last_30_days`, `quarter`, `year`, `custom` | Date window applied to report creation dates. Defaults to `last_30_days`. |
| `from` | date | ISO date | Required when `period=custom`. |
| `to` | date | ISO date | Required when `period=custom`; must be after or equal to `from`. |
| `department` | string | Existing department name | Filters reports by department. |
| `employee` | integer | Existing employee id | Filters reports by employee. |
| `status` | string | `draft`, `submitted`, `manager_approved`, `generated`, `rejected` | Filters reports by workflow status. |
| `granularity` | string | `weekly`, `monthly`, `yearly` | Used by the trends endpoint. |

Each filtered response includes a `filters` object with the effective period and applied filters.

## Response Envelope

Successful responses use the existing ReportFlow JSON envelope:

```json
{
  "success": true,
  "data": {},
  "filters": {}
}
```

Validation errors return `422` with Laravel validation errors. Unauthorized requests return `401`. Forbidden requests return `403`.

## Endpoints

### GET `/api/analytics/overview`

Returns high-level analytics KPIs.

Response fields:

- `total_reports`
- `submitted_reports`
- `approved_reports`
- `rejected_reports`
- `generated_reports`
- `pending_reports`
- `validation_rate`
- `completion_rate`
- `average_approval_time`
- `status_distribution`

`validation_rate` is calculated from generated reports over decided reports (`generated + rejected`).

`completion_rate` is calculated from non-draft reports over total reports.

### GET `/api/analytics/trends`

Returns chart-ready report trends grouped by `granularity`.

Supported granularities:

- `weekly`
- `monthly`
- `yearly`

Each trend point includes total, submitted, approved, generated, rejected, and pending counts.

### GET `/api/analytics/reports`

Returns report analytics:

- status distribution
- department distribution
- weekly distribution
- generated PowerPoint statistics

### GET `/api/analytics/employees`

Returns employee productivity analytics derived from weekly reports:

- employee identity
- total reports
- reports submitted
- approval rate
- average completion time
- generated reports

### GET `/api/analytics/departments`

Returns department-level analytics:

- active employees
- total reports
- generated reports
- rejected reports
- pending reports
- validation rate
- completion rate

### GET `/api/analytics/workflow`

Returns workflow analytics:

- current workflow distribution
- approval bottlenecks
- average processing time
- transition rates

Bottlenecks currently track manager approval and final approval queues.

### GET `/api/analytics/activity`

Returns recent analytical workflow activity from the existing Spatie Activity Log data.

Only report workflow activity is included; generic model audit events are excluded.

### GET `/api/analytics/export-options`

Returns analytics export availability.

Analytics-specific exports are not currently implemented, so the endpoint returns:

```json
{
  "supported": false,
  "available_formats": [],
  "message": "Dedicated analytics exports are not available yet.",
  "future_formats": ["csv", "xlsx", "pdf"]
}
```

## Example Request

```http
GET /api/analytics/overview?period=last_30_days&department=IT&status=generated
Authorization: Bearer {token}
Accept: application/json
```

## Release Notes

This API reuses existing ReportFlow data sources:

- `weekly_reports`
- `employees`
- workflow timestamps
- generated PowerPoint fields
- Spatie activity logs
- Spatie role-based access control

No frontend behavior, database schema, or workflow transition logic is changed by this API.
