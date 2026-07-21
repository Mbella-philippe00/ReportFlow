# AI Assistant API

ReportFlow exposes AI assistant capabilities through authenticated REST endpoints under `/api/ai`.

## Authentication

All endpoints require Sanctum authentication.

## Authorization

- `GET /api/ai/dashboard`: managers and super-admins.
- `GET /api/ai/history`: authenticated employees, managers and super-admins. Employees see their own history.
- `GET /api/ai/providers`: authenticated employees, managers and super-admins.
- Report AI endpoints: report owner, manager or super-admin.
- Workflow recommendation endpoint: manager or super-admin only.

The backend remains authoritative for permissions.

## Providers

The API reuses the existing Gemini-backed `WeeklyReportAiService` and reports configured providers through `/api/ai/providers`.

No API keys are exposed.

## Endpoints

### GET `/api/ai/dashboard`

Returns AI usage metrics for the authenticated user:

- `total_generations`
- `today_generations`
- `available_actions`
- `providers`
- `by_action`
- `recent`

### GET `/api/ai/providers`

Returns available provider metadata:

- provider name
- display label
- configured status
- model list
- default model

### GET `/api/ai/history`

Returns paginated AI generation history.

Query parameters:

| Parameter | Type | Description |
| --- | --- | --- |
| `action` | string | Optional AI action filter. |
| `report_id` | integer | Optional report filter. |
| `scope` | `mine` or `all` | Managers and super-admins may request `all`; employees are restricted to their own history. |
| `page` | integer | Pagination page. |
| `per_page` | integer | Pagination size, max 100. |

### POST `/api/ai/reports/{report}/assist`

Generic report assistant endpoint.

Request body:

```json
{
  "action": "writing_improvement",
  "section": "activities",
  "text": "Optional selected text",
  "instructions": "Optional user instructions",
  "persist": false,
  "locale": "fr"
}
```

Supported actions:

- `executive_summary`
- `writing_improvement`
- `writing_suggestions`
- `grammar_tone`
- `action_items`
- `risk_analysis`
- `priority_detection`
- `missing_information`
- `quality_score`
- `workflow_recommendation`
- `powerpoint_summary`
- `rewrite_professionally`
- `summarize_report`
- `expand_report`
- `suggest_next_actions`
- `suggest_objectives`
- `highlight_missing_sections`

### Specific Report Endpoints

Each endpoint accepts the same optional body fields except `action`.

- `POST /api/ai/reports/{report}/executive-summary`
- `POST /api/ai/reports/{report}/improve-writing`
- `POST /api/ai/reports/{report}/writing-suggestions`
- `POST /api/ai/reports/{report}/grammar-tone`
- `POST /api/ai/reports/{report}/action-items`
- `POST /api/ai/reports/{report}/risk-analysis`
- `POST /api/ai/reports/{report}/priority-detection`
- `POST /api/ai/reports/{report}/missing-information`
- `POST /api/ai/reports/{report}/quality-score`
- `POST /api/ai/reports/{report}/workflow-recommendation`
- `POST /api/ai/reports/{report}/powerpoint-summary`

## Persistence

AI history is stored through the existing Spatie Activity Log with `log_name = ai`.

Executive summary generation can persist the generated summary by passing:

```json
{
  "persist": true
}
```

No workflow transition is performed by AI endpoints.

## Response Shape

Successful generation response:

```json
{
  "success": true,
  "message": "AI generation completed successfully.",
  "data": {
    "action": "executive_summary",
    "content": "Generated content",
    "provider": "gemini",
    "model": "gemini-2.5-flash",
    "history_id": 1,
    "metadata": {
      "section": null,
      "persisted": false
    },
    "report": {
      "id": 1,
      "week": "2026-W27",
      "department": "IT",
      "status": "draft",
      "executive_summary": null
    },
    "created_at": "2026-07-10T00:00:00.000000Z"
  }
}
```

Provider failures return `503` with a safe message.

Validation errors return `422`.

Unauthorized requests return `401`.

Forbidden requests return `403`.
