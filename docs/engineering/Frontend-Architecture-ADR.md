# Frontend Architecture ADR

Status: Proposed
Date: 2026-07-02
Project: ReportFlow
Decision owners: Engineering

## 1. Goals

- Define the frontend architecture before implementation starts.
- Build a scalable React frontend for ReportFlow without changing backend business logic, database schema, tests, or API routes during the frontend foundation phase.
- Consume the existing Laravel API through Sanctum Bearer tokens.
- Support the target product areas: Dashboard, Reports, Workflow, Notifications, Employees, Analytics, AI, Settings, Profile, and PWA.
- Establish clear folder boundaries so feature work can grow without turning `resources/js` into a flat component dump.
- Standardize routing, state, forms, API access, error handling, theming, testing, and performance decisions before production code is written.
- Keep the frontend operationally aligned with the existing Laravel/Vite/Tailwind stack.

## 2. Non-goals

- Do not redesign or refactor backend services.
- Do not change database schema.
- Do not change existing API routes as part of the architecture freeze.
- Do not replace Filament administration screens.
- Do not introduce server-side rendering in the first frontend foundation phase.
- Do not implement production UI components in this ADR.
- Do not install packages in this ADR.
- Do not commit to mobile native applications; the target mobile strategy is PWA first.
- Do not duplicate backend authorization logic in React. The frontend may hide or disable actions, but the backend remains authoritative.

## 3. Current Backend Architecture

ReportFlow is currently a Laravel API-first application with an administrative Filament surface.

Observed backend characteristics:

- Laravel backend with Sanctum authentication.
- API routes are defined under `routes/api.php`.
- Public endpoint:
  - `POST /api/login`
- Protected endpoints under `auth:sanctum`:
  - `POST /api/logout`
  - `GET /api/me`
  - `GET /api/user`
  - `GET /api/dashboard`
  - `GET /api/profile`
  - `PUT /api/profile`
  - `apiResource /api/reports`
  - `POST /api/reports/{report}/submit`
  - `POST /api/reports/{report}/approve`
  - `POST /api/reports/{report}/final-approve`
  - `POST /api/reports/{report}/reject`
- Domain resources already exist for dashboard, weekly reports, and employees.
- Report workflow status is represented by `draft`, `submitted`, `manager_approved`, `generated`, and `rejected`.
- Backend services already cover AI-assisted report summary generation, PowerPoint generation, notifications, activity logs, dashboard metrics, and report validation.
- Filament provides an internal administration/admin dashboard layer and should remain separate from the customer-facing React application.

Important constraint:

- The frontend must treat the API contract as the source of truth and must not bypass authorization, workflow, or validation logic.

## 4. Frontend Strategy

The chosen frontend strategy is a React SPA mounted by Laravel and served through Vite.

Key decisions:

- Use React for the customer-facing application.
- Use BrowserRouter for client-side routing.
- Let Laravel serve the SPA shell through a web fallback route.
- Consume backend data through JSON API endpoints.
- Keep Filament for administration and internal operational screens.
- Keep frontend code in `resources/js`.
- Use Tailwind CSS 4 as the styling foundation.
- Use feature-first organization for scalable product delivery.

This strategy matches the current backend better than Inertia because the existing application already exposes API endpoints and does not currently include Inertia middleware, Inertia routes, or Inertia dependencies.

## 5. Why React

React is selected for the ReportFlow frontend because:

- It is well suited for a complex SaaS interface with dashboards, workflows, dense tables, form-heavy screens, and repeated UI patterns.
- It has a mature ecosystem for routing, data fetching, forms, accessibility, testing, and PWA integration.
- It supports clear component composition for reusable report, workflow, notification, analytics, and settings modules.
- It pairs well with Vite and Tailwind.
- It is easier to staff and maintain in many enterprise teams due to broad market familiarity.
- It enables a clean API-driven client without requiring backend page rendering for every product screen.

React is not selected because it is universally better than Vue or Inertia. It is selected because it fits the requested frontend direction and the current API-first backend shape.

## 6. Why a React SPA Instead of Inertia

Inertia is not selected for the first frontend foundation because:

- The current backend does not include Inertia dependencies or Inertia middleware.
- Existing domain endpoints are already JSON API endpoints.
- The frontend needs a rich client application model with app-level providers, route guards, cached server state, optimistic updates, and PWA behavior.
- Inertia would require backend route/controller changes to return Inertia pages, which conflicts with the current instruction not to modify backend code during architecture freeze.
- API-driven frontend development allows UI work to proceed while preserving existing backend route contracts.

React SPA is preferred because:

- It consumes the existing API directly.
- It makes server state caching explicit through TanStack Query.
- It separates customer app concerns from Filament.
- It supports future non-browser clients through the same API contract.
- It provides a natural foundation for PWA features such as offline shell caching, install prompts, and client-side route restoration.

## 7. Routing Strategy

The frontend will use `BrowserRouter`, not `HashRouter`.

Decision:

- React Router with `BrowserRouter` will own client-side navigation.
- Laravel will serve the SPA shell for all frontend application routes through a fallback route.
- API routes remain under `/api`.
- Filament/admin routes remain owned by Laravel/Filament.
- Static assets remain served through Vite/Laravel build output.

Preferred route model:

- `/login`
- `/dashboard`
- `/reports`
- `/reports/create`
- `/reports/:id`
- `/reports/:id/edit`
- `/workflow`
- `/notifications`
- `/employees`
- `/analytics`
- `/ai`
- `/settings`
- `/profile`

Why BrowserRouter:

- It produces clean, shareable URLs without hash fragments.
- It is better for enterprise SaaS navigation, bookmarking, browser history, analytics, and support workflows.
- It aligns with user expectations for application URLs.
- It avoids the technical and UX compromises of hash-based routing.
- It allows route-level authorization and lazy loading to follow normal URL semantics.

Laravel fallback requirement:

- Laravel must return the SPA shell for frontend routes that are not API, Filament, storage, or asset routes.
- This fallback should be explicit and constrained so it does not swallow backend/API/admin routes.
- The fallback should be implemented only after approval for backend route changes, because it touches Laravel routing.

Fallback principle:

- Laravel serves the shell.
- React owns the screen.
- Laravel API remains the source of data and authorization.
Local development URL decision:

- The canonical local ReportFlow origin is `http://localhost:8081`.
- All local development commands, browser checks, verification steps, and screenshots must use `http://localhost:8081`.
- `http://localhost` must not be assumed to point to ReportFlow because port `80` may be occupied by another local service.
- React API calls should remain same-origin through `VITE_API_BASE_URL=/api`, resolving to `http://localhost:8081/api` locally.

## 8. Project Folder Structure

The frontend will use a feature-first architecture with shared infrastructure folders.

Target structure:

```text
resources/js/
  app/
  assets/
  components/
  config/
  features/
  hooks/
  lib/
  providers/
  routes/
  services/
  stores/
  styles/
  types/
  utils/
```

Folder responsibilities:

- `app/`
  - Application bootstrap.
  - Root component.
  - App-level composition.
  - Global initialization.
  - This folder should stay small.

- `assets/`
  - Static frontend assets imported by React.
  - Images, icons, illustrations, and PWA-specific visual assets.
  - Does not contain business logic.

- `components/`
  - Shared reusable components.
  - Organized by generic responsibility, for example `ui`, `layout`, `forms`, `data-display`, and `feedback`.
  - Must not contain feature-specific business logic.

- `config/`
  - Client-side configuration constants.
  - Navigation configuration.
  - API base configuration.
  - Feature flags where needed.
  - Role/permission display maps.

- `features/`
  - Product domain modules.
  - Each major domain owns its components, hooks, schemas, pages, and local helpers.
  - Expected modules: `auth`, `dashboard`, `reports`, `workflow`, `notifications`, `employees`, `analytics`, `ai`, `settings`, `profile`, and `pwa`.

- `hooks/`
  - Shared reusable React hooks that are not feature-specific.
  - Examples: media queries, local storage, debounce, document title, and permissions helpers.

- `lib/`
  - Low-level integrations and application libraries.
  - HTTP client, query client, logger, date adapter, storage adapter, and auth token adapter.
  - Must be framework-aware only where necessary.

- `providers/`
  - React context providers and provider composition.
  - Auth provider, theme provider, query provider, router provider, and toast provider.

- `routes/`
  - Route definitions.
  - Protected route wrappers.
  - Lazy route imports.
  - Route metadata for titles, breadcrumbs, and authorization.

- `services/`
  - API service modules.
  - Each service maps to a backend resource area such as auth, reports, dashboard, workflow, profile, notifications, and employees.
  - Services should be thin wrappers around the HTTP client.

- `stores/`
  - Zustand stores for client state.
  - Stores should not duplicate server state owned by TanStack Query.
  - Good candidates: auth session metadata, UI sidebar state, theme state, command palette state, draft UI preferences.

- `styles/`
  - Global CSS entrypoints and Tailwind layer additions.
  - Design tokens exposed through CSS variables.
  - Theme variables.

- `types/`
  - Shared TypeScript types.
  - API response wrappers.
  - Backend resource DTOs.
  - Auth, role, permission, pagination, report, employee, notification, dashboard, and settings types.

- `utils/`
  - Pure helper functions.
  - Formatting, date helpers, string helpers, number helpers, status mapping, and safe guards.
  - No React code and no network code.

## 9. State Management

Evaluated options:

- React local state
- React Context
- Redux Toolkit
- Zustand
- TanStack Query for server state

Decision:

- Use Zustand for client state.
- Use TanStack Query for server state.
- Use React local state for simple component-only state.
- Use React Context only for provider-style dependencies such as theme, auth, and query client.

Why Zustand:

- Small API surface.
- Minimal boilerplate.
- Easy to organize into focused stores.
- Works well with TypeScript.
- Does not force global state for everything.
- Good fit for UI state such as sidebar collapse, theme preference, current workspace UI state, command palette, and unsaved local form helpers.

Why Redux is unnecessary:

- ReportFlow does not currently require complex event-sourced client state.
- Most important data is server state and belongs in TanStack Query.
- Redux would add boilerplate and conventions before the product needs them.
- Zustand is enough for targeted client state without reducing maintainability.

State ownership rule:

- If the data comes from the API, TanStack Query owns it.
- If the data is only UI/application state, Zustand or local React state owns it.
- Do not mirror query data into Zustand unless there is a specific, documented reason.

## 10. Server State

Decision:

- Use TanStack Query for server state.

Why TanStack Query:

- Handles caching, refetching, loading states, error states, retries, invalidation, and mutation flows.
- Reduces custom data-fetching code.
- Supports optimistic updates for workflows and form mutations.
- Works well with a Laravel API.
- Keeps API data out of global client stores.

Caching strategy:

- Authentication user query:
  - Key: `auth.me`
  - Refetch on app load and after login/logout.
  - Short stale time because roles/profile may change.
- Dashboard query:
  - Key: `dashboard.index`
  - Moderate stale time.
  - Refetch on workflow mutations.
- Reports list:
  - Key includes filters, page, sort, and search.
  - Preserve previous data during pagination.
  - Invalidate after create, update, delete, submit, approve, final approve, or reject.
- Report details:
  - Key includes report ID.
  - Invalidate after any workflow mutation for that report.
- Notifications:
  - Short stale time or polling interval.
  - Invalidate after mark-read actions once endpoints exist.

Optimistic updates:

- Use optimistic updates only where the user benefit is clear and rollback is safe.
- Candidate actions:
  - Mark notification as read.
  - Update lightweight UI preferences.
  - Report workflow actions may use optimistic status updates only after workflow rules are stable.
- For irreversible workflow actions like approve, final approve, reject, and delete, prefer pending UI states unless backend behavior is fully predictable.

Mutation error policy:

- Roll back optimistic cache changes on error.
- Show field errors for validation failures.
- Show action-level errors for workflow failures.
- Invalidate affected queries after settled mutations where stale data would be harmful.

## 11. Forms

Decision:

- Use React Hook Form for form state.
- Use Zod for runtime schema validation and TypeScript inference.

Why React Hook Form:

- Efficient rendering for large forms.
- Good support for controlled and uncontrolled inputs.
- Works well with enterprise forms and field arrays.
- Good integration with schema resolvers.

Why Zod:

- Provides runtime validation.
- Provides inferred TypeScript types.
- Keeps frontend validation rules explicit.
- Can model API payloads clearly.

Form strategy:

- Backend validation remains authoritative.
- Frontend schemas improve UX by catching common errors before submit.
- API `422` validation errors must be mapped back into form fields.
- Long report forms should be split into sections with autosave only if/when a backend autosave endpoint exists.
- Rejection forms should require a reason and enforce max length based on API validation.

## 12. Authentication

Decision:

- Use Sanctum Bearer tokens returned by `/api/login`.
- Store the token through a dedicated auth storage adapter.
- Attach `Authorization: Bearer <token>` to protected API requests.
- Use `/api/me` to hydrate the authenticated user on app boot.

Token storage:

- Initial implementation may use `localStorage` through an adapter for persistence.
- The adapter must centralize token reads/writes/removal.
- Direct use of `localStorage` outside the adapter is not allowed.
- Future hardening may move tokens to an HTTP-only cookie strategy if backend support is approved.

Refresh strategy:

- The current API does not expose a refresh-token endpoint.
- On app load, the client validates the stored token by calling `/api/me`.
- On `401`, the token is cleared and the user is redirected to login.
- Token rotation or refresh can be added later if backend endpoints are introduced.

Protected routes:

- Protected route wrappers require an authenticated user.
- During `/api/me` loading, show an app loading state.
- If authentication fails, redirect to `/login`.
- If a user is authenticated and visits `/login`, redirect to `/dashboard`.
- Authorization checks for roles/permissions happen after authentication is resolved.

Logout:

- Call `/api/logout` when possible.
- Always clear local token and auth state after logout attempt.
- Invalidate all protected query caches after logout.

## 13. RBAC

Decision:

- React will consume roles and permissions from the backend.
- The backend remains authoritative for all permission enforcement.

Current state:

- `/api/login` returns user roles.
- `/api/me` returns user roles and employee relationship.
- Fine-grained permissions are not currently exposed in the inspected auth response.

Target RBAC contract:

- `/api/me` should expose:
  - user identity
  - roles
  - permissions
  - employee profile
  - optional feature flags

Frontend usage:

- `usePermissions()` exposes helpers such as `hasRole`, `hasAnyRole`, `can`, and `canAny`.
- Navigation items declare required roles/permissions.
- Buttons and actions declare required permissions.
- Route metadata declares required permissions.
- Unauthorized screens should show a clear access-denied state.

Important rule:

- Hiding UI actions is a UX improvement, not a security boundary. The API must still reject unauthorized actions.

## 14. Design System

Decision:

- Build a small internal design system in `components/`.
- Use Tailwind CSS 4 and CSS variables for tokens.
- Keep components accessible, composable, and domain-neutral.

Component groups:

- `components/ui`
  - Button, IconButton, Input, Textarea, Select, Checkbox, Switch, Badge, Tooltip, Dialog, Drawer, Dropdown, Tabs.
- `components/layout`
  - AppShell, Sidebar, Topbar, Breadcrumbs, PageHeader, SectionHeader, MobileNav.
- `components/forms`
  - FormField, FieldError, RequiredMarker, FormActions.
- `components/data-display`
  - Table, Pagination, EmptyState, StatCard, Timeline, DescriptionList.
- `components/feedback`
  - Toast, Alert, Skeleton, Spinner, ErrorState, ConfirmDialog.

Feature-specific components stay inside `features/*`.

Design principles:

- Dense, readable SaaS UI.
- Clear hierarchy for operational workflows.
- Minimal decoration.
- Consistent status colors for report workflow.
- Reusable primitives before feature-specific variants.
- Accessibility built into primitives rather than added later.

## 15. Theme System

Decision:

- Support light, dark, and system themes.
- Store user preference in client storage through a theme store.
- Apply theme through a root class and CSS variables.

Modes:

- `light`
  - Always use light color tokens.
- `dark`
  - Always use dark color tokens.
- `system`
  - Follow `prefers-color-scheme`.

Theme rules:

- Theme tokens live in CSS variables.
- Components reference tokens through Tailwind utilities and CSS variables.
- Status colors must remain distinguishable in light and dark modes.
- Charts must use theme-aware palettes.
- The system mode must react to OS preference changes.

## 16. Error Handling

Error categories:

- Validation errors: HTTP `422`
- Authentication errors: HTTP `401`
- Authorization errors: HTTP `403`
- Not found errors: HTTP `404`
- Conflict/workflow errors: HTTP `409` or backend-specific error response
- Server errors: HTTP `500`
- Network/offline errors

Strategy:

- Centralize response handling in the API client.
- Map `422` errors to form fields.
- Clear auth state on `401`.
- Show access-denied UI on `403`.
- Show not-found route or resource state on `404`.
- Show retryable error states for dashboard/report list queries.
- Show toast notifications for action failures.
- Log unexpected client errors through a future observability adapter.

React error boundaries:

- App-level error boundary for fatal UI crashes.
- Route-level error boundaries for lazy-loaded feature failures.
- Component-level fallback for charts and large widgets where appropriate.

## 17. Notification Strategy

Current backend state:

- Laravel database notifications exist.
- Filament uses database notification polling.
- Dedicated customer-facing notification API endpoints were not observed during inspection.

Frontend target:

- Add a notification bell in the app shell.
- Display unread count.
- Display notification list.
- Support mark as read and mark all as read when backend endpoints exist.

Initial strategy:

- Do not fake notifications if the API does not expose them.
- Design the UI contract and service boundary now.
- Implement frontend notification service only against approved endpoints.
- Use polling first because it is simpler and matches the current Filament pattern.

Future strategy:

- Start with 30-second polling.
- Move to Laravel broadcasting, SSE, or WebSockets only if real-time requirements justify the operational cost.

## 18. API Client Strategy

Decision:

- Create a single HTTP client wrapper in `lib/http.ts`.
- Services in `services/` use the HTTP client.
- Components and pages do not call `fetch` or `axios` directly.

Responsibilities:

- Base URL handling.
- JSON headers.
- Bearer token injection.
- Request cancellation support.
- Error normalization.
- `401` handling.
- `422` validation error extraction.
- Pagination metadata typing.
- Optional request logging in development.

API response model:

- Standard success responses should be typed.
- Paginated responses should expose data and meta.
- Services should return domain data, not raw HTTP internals, unless the caller needs response metadata.

## 19. Performance Strategy

Performance goals:

- Fast initial shell load.
- Lazy-loaded feature pages.
- Cached server state.
- Minimal global re-renders.
- Efficient large tables and report lists.

Strategies:

- Code split route-level modules.
- Keep app bootstrap small.
- Use TanStack Query cache to avoid unnecessary refetches.
- Memoize expensive derived values only when profiling shows benefit.
- Avoid storing large API responses in Zustand.
- Use pagination for report lists.
- Use skeletons for perceived performance.
- Defer non-critical providers where possible.
- Keep chart libraries lazy-loaded with analytics/dashboard routes.

## 20. Code Splitting Strategy

Decision:

- Split by route and major feature.
- Keep shared UI in the main shared bundle only when broadly used.
- Lazy-load heavy modules such as analytics charts, AI screens, and PWA helpers.

Route chunks:

- Auth routes.
- Dashboard.
- Reports.
- Workflow.
- Notifications.
- Employees.
- Analytics.
- AI.
- Settings.
- Profile.

Bundle hygiene:

- Do not import feature modules from shared UI.
- Do not import chart libraries in the root app.
- Do not import all icons globally.
- Prefer named imports and per-feature imports where libraries support tree shaking.

## 21. Lazy Loading Strategy

Decision:

- Use `React.lazy` and route-level suspense boundaries.
- Use skeletons tailored to each route.

Rules:

- Lazy-load page components.
- Lazy-load expensive widgets.
- Lazy-load chart components.
- Lazy-load PWA registration after app boot.
- Keep core layout eagerly loaded so navigation feels stable.

Fallbacks:

- App shell loading state for auth hydration.
- Route skeleton for page loading.
- Widget skeleton for dashboard cards and charts.
- Error boundary fallback for failed chunks.

## 22. Accessibility Strategy

Decision:

- Accessibility is a foundation requirement, not a final QA pass.

Standards:

- Target WCAG 2.2 AA where practical.
- Keyboard navigation for all controls.
- Visible focus states.
- Semantic HTML.
- Proper labels and descriptions for form controls.
- ARIA only when semantic HTML is insufficient.
- Dialogs must trap focus and restore focus on close.
- Menus and dropdowns must be keyboard accessible.
- Color is never the only status indicator.
- Tables must expose headers and captions where needed.
- Error messages must be associated with fields.

Testing:

- Include accessibility checks in component tests where feasible.
- Include manual keyboard checks for critical workflows.
- Add automated checks with an accessibility testing library during the testing phase.

## 23. PWA Strategy

Decision:

- ReportFlow will support PWA behavior after the core SPA foundation is stable.
- PWA implementation must not compromise authentication security.

PWA features:

- Web app manifest.
- App icons.
- Install prompt.
- Offline fallback shell.
- Service worker update prompt.
- Basic asset caching.
- Optional route shell caching for authenticated app shell.

Caching rules:

- Do not cache authenticated API responses by default.
- Do not cache Bearer tokens in the service worker.
- Cache static assets and app shell.
- Let TanStack Query manage in-memory API cache while online.
- Consider persisted query cache only after security review.

Offline behavior:

- If offline before login, show offline/login unavailable state.
- If offline after login, show cached shell and explain data may be unavailable.
- Do not allow final workflow actions while offline unless a backend-supported sync queue exists.

## 24. Testing Strategy

Testing layers:

- Unit tests for pure utilities.
- Component tests for shared UI primitives.
- Hook tests for auth, permissions, and query helpers.
- Service tests with mocked HTTP responses.
- Route smoke tests for protected/unauthenticated flows.
- End-to-end tests for critical workflows after the initial UI exists.

Recommended tools:

- Vitest for unit and component-level tests.
- React Testing Library for component behavior.
- MSW for API mocking.
- Playwright for end-to-end smoke tests.
- Accessibility checks through testing-library/jest-dom and axe-compatible tooling.

Critical flows:

- Login.
- Auth hydration from stored token.
- Logout.
- Protected route redirect.
- Dashboard load.
- Reports list pagination.
- Report create/update.
- Submit report.
- Approve report.
- Final approve report.
- Reject report with reason.
- Permission-gated navigation.

## 25. Coding Standards

General:

- TypeScript-first.
- No `any` unless documented and localized.
- Prefer explicit domain types.
- Keep feature modules cohesive.
- Keep shared components domain-neutral.
- Do not call the API directly from components.
- Do not duplicate server state in Zustand.
- Keep backend status values as typed unions.
- Use named exports for shared modules unless a framework convention requires default exports.

React:

- Function components only.
- Hooks at the top level.
- Keep components small and purposeful.
- Prefer composition over configuration-heavy components.
- Use route-level boundaries.
- Keep form schemas close to feature forms.

Styling:

- Tailwind utilities for layout and common styling.
- CSS variables for tokens and themes.
- Avoid one-off hard-coded colors in feature code.
- Use shared status mapping utilities.

Naming:

- Feature files use clear domain names.
- Hooks start with `use`.
- Service files end with `.service.ts`.
- Store files end with `.store.ts`.
- Schema files end with `.schema.ts`.
- Type files end with `.types.ts` or live under `types/`.

## 26. Risks

- BrowserRouter requires a Laravel fallback route, which is a backend route change and must be approved separately.
- Current `/api/profile` routes point to an empty controller, so Profile frontend work may be blocked without backend completion.
- Fine-grained permissions are not currently exposed to React, so full RBAC UI will require an API contract decision.
- Notification UI depends on future customer-facing notification endpoints.
- LocalStorage Bearer token storage has XSS exposure; it must be protected by strong frontend hygiene and may need future migration to HTTP-only cookies.
- PWA caching can accidentally expose sensitive data if implemented carelessly.
- API validation and frontend Zod schemas can drift without shared contract discipline.
- Existing worktree is dirty, so frontend changes must avoid touching unrelated backend files.
- Tailwind 4 and Vite 8 are modern choices; package compatibility must be verified when implementation begins.

## 27. Future Evolution

Possible future improvements:

- Move token handling to HTTP-only Sanctum cookie authentication if backend support is approved.
- Add explicit `/api/permissions` or enrich `/api/me` with permissions.
- Add notification endpoints and real-time broadcasting.
- Add report autosave endpoint and offline draft support.
- Add analytics-specific endpoints for filters and drill-down views.
- Add OpenAPI or generated TypeScript clients from backend contracts.
- Add persisted TanStack Query cache after security review.
- Add module federation or micro-frontends only if team boundaries demand it later.
- Add SSR only if SEO or first-load performance requirements become strong enough to justify complexity.

## Phased Implementation Roadmap

### Phase 0: Architecture Approval

- Review and approve this ADR.
- Confirm React SPA API-first direction.
- Confirm BrowserRouter plus Laravel fallback route.
- Confirm approved dependency list.
- Confirm whether backend route fallback changes are allowed in the frontend foundation phase.

### Phase 1: Tooling Foundation

- Add React, React DOM, TypeScript, Vite React plugin, React Router, Zustand, TanStack Query, React Hook Form, and Zod.
- Add TypeScript configuration.
- Update Vite entrypoint for React.
- Update Tailwind source scanning for React/TypeScript files.
- Add baseline frontend scripts for build and typecheck.

### Phase 2: App Shell

- Create the React root.
- Create provider composition.
- Add BrowserRouter.
- Add Laravel SPA fallback route after explicit backend approval.
- Add AppShell, GuestLayout, protected route handling, and base route map.

### Phase 3: API and Auth

- Implement HTTP client.
- Implement auth service.
- Implement token adapter.
- Implement auth store/provider.
- Implement login, logout, and `/api/me` hydration.
- Add 401/403/422 handling.

### Phase 4: Design System Foundation

- Add design tokens.
- Add theme provider for light, dark, and system.
- Add base UI primitives.
- Add feedback components.
- Add layout components.
- Add accessibility behavior to dialogs, menus, forms, and focus states.

### Phase 5: Core Product Screens

- Implement Dashboard.
- Implement Reports list, detail, create, edit.
- Implement workflow actions: submit, approve, final approve, reject.
- Implement report status components.
- Implement protected and permission-gated navigation.

### Phase 6: Extended Product Areas

- Implement Notifications after API contract is available.
- Implement Employees after endpoint availability is confirmed.
- Implement Analytics widgets and chart lazy loading.
- Implement AI screen around approved backend AI capabilities.
- Implement Settings and Profile once API support is complete.

### Phase 7: PWA

- Add manifest.
- Add icons.
- Add service worker.
- Add offline fallback.
- Add install prompt.
- Add service worker update prompt.
- Verify sensitive data is not cached.

### Phase 8: Testing and Hardening

- Add unit and component tests.
- Add service tests with API mocks.
- Add route smoke tests.
- Add critical Playwright flows.
- Add accessibility checks.
- Run build, typecheck, and smoke validation before release.

