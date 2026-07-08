# Employees API

All Employees API endpoints are protected by Sanctum and return JSON.

## Authorization

- `super-admin`: list, view, create, update, delete, reports, activity.
- `manager`: list, view, create, update, reports, activity.
- `employee`: view only their own employee record, reports, and activity.

Forbidden requests return `403`.
Unauthenticated requests return `401`.

## List Employees

`GET /api/employees`

Query parameters:

| Parameter | Type | Description |
| --- | --- | --- |
| `search` | string | Matches first name, last name, email, or department. |
| `department` | string | Exact department filter. |
| `active` | boolean | Accepts `1`, `0`, `true`, or `false`. |
| `sort` | string | One of `name`, `first_name`, `last_name`, `email`, `department`, `active`, `reports_count`, `created_at`, `updated_at`. Prefix with `-` for descending. |
| `direction` | string | `asc` or `desc`; ignored when `sort` is prefixed with `-`. |
| `page` | integer | Pagination page. |
| `per_page` | integer | Items per page, from 1 to 100. Defaults to 15. |

Response shape:

```json
{
  "success": true,
  "data": [],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 0
  }
}
```

## Get Employee

`GET /api/employees/{employee}`

Returns:

- `data`: employee resource with user, roles, department, status, and report count.
- `statistics`: report totals by workflow status.
- `recent_reports`: the five most recent weekly reports.

## Create Employee

`POST /api/employees`

Payload:

```json
{
  "user_id": 1,
  "first_name": "Ada",
  "last_name": "Lovelace",
  "email": "ada@example.com",
  "department": "IT",
  "active": true
}
```

Validation:

- `first_name`, `last_name`, and `email` are required.
- `email` must be unique in `employees`.
- `user_id` is optional, must reference an existing user, and must be unique when present.

## Update Employee

`PUT /api/employees/{employee}`

Accepts the same fields as create. All fields are optional.

## Delete Employee

`DELETE /api/employees/{employee}`

Only `super-admin` users can delete employees.

## Employee Reports

`GET /api/employees/{employee}/reports`

Returns paginated weekly reports for the employee.
Supports `page` and `per_page`.

## Employee Activity

`GET /api/employees/{employee}/activity`

Returns paginated workflow activity log entries for the employee's weekly reports, using existing Spatie activity logs.
Supports `page` and `per_page`.