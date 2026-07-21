import type { AuthUser, PermissionName, ReportPayload, ReportStatusValue, WeeklyReport } from '@/types';
import type { ReportFormValues } from '@/features/reports/schemas/report.schema';

export type ReportCapabilities = {
    canDelete: boolean;
    canDuplicate: boolean;
    canEdit: boolean;
    canExportPptx: boolean;
    canPrint: boolean;
    canSubmit: boolean;
};

const fallbackRolePermissions: Record<PermissionName, readonly string[]> = {
    'ai.use': ['manager', 'super-admin'],
    'analytics.view': ['manager', 'super-admin'],
    'dashboard.view': ['employee', 'manager', 'super-admin'],
    'employees.view': ['manager', 'super-admin'],
    'notifications.view': ['employee', 'manager', 'super-admin'],
    'profile.view': ['employee', 'manager', 'super-admin'],
    'reports.approve': ['manager', 'super-admin'],
    'reports.create': ['employee', 'manager', 'super-admin'],
    'reports.final-approve': ['super-admin'],
    'reports.reject': ['manager', 'super-admin'],
    'reports.submit': ['employee', 'manager', 'super-admin'],
    'reports.update': ['employee', 'manager', 'super-admin'],
    'reports.view': ['employee', 'manager', 'super-admin'],
    'settings.manage': ['super-admin'],
};

const reportProgressByStatus: Record<ReportStatusValue, number> = {
    approved: 100,
    draft: 20,
    rejected: 100,
    submitted: 50,
    under_review: 75,
};

export const reportStatusOptions = [
    { label: 'All statuses', value: '' },
    { label: 'Draft', value: 'draft' },
    { label: 'Submitted', value: 'submitted' },
    { label: 'Under Review', value: 'under_review' },
    { label: 'Approved', value: 'approved' },
    { label: 'Rejected', value: 'rejected' },
] as const;

export const reportSortOptions = [
    { label: 'Newest update', value: 'updated_desc' },
    { label: 'Oldest update', value: 'updated_asc' },
    { label: 'Week ascending', value: 'week_asc' },
    { label: 'Week descending', value: 'week_desc' },
    { label: 'Department A-Z', value: 'department_asc' },
    { label: 'Department Z-A', value: 'department_desc' },
] as const;

export type ReportSortValue = (typeof reportSortOptions)[number]['value'];

export const hasReportPermission = (user: AuthUser | null, permission: PermissionName) => {
    if (!user) {
        return false;
    }

    if (user.roles.includes('super-admin')) {
        return true;
    }

    if (user.permissions && user.permissions.length > 0) {
        return user.permissions.includes(permission);
    }

    return fallbackRolePermissions[permission].some((role) => user.roles.includes(role as AuthUser['roles'][number]));
};

export const isReportEditableByWorkflow = (report: WeeklyReport) =>
    !report.is_read_only && (report.status.value === 'draft' || report.status.value === 'rejected');

export const getReportCapabilities = (report: WeeklyReport, user: AuthUser | null): ReportCapabilities => {
    const canView = hasReportPermission(user, 'reports.view');
    const canCreate = hasReportPermission(user, 'reports.create');
    const canUpdate = hasReportPermission(user, 'reports.update');
    const canSubmit = report.available_actions?.includes('submit') ?? (report.status.value === 'draft' && hasReportPermission(user, 'reports.submit'));
    const editable = isReportEditableByWorkflow(report);

    return {
        canDelete: report.status.value === 'draft' && canUpdate,
        canDuplicate: canCreate,
        canEdit: editable && canUpdate,
        canExportPptx: canView && Boolean(report.pptx_file),
        canPrint: canView,
        canSubmit,
    };
};

export const getReportProgress = (status: ReportStatusValue) => reportProgressByStatus[status];

export const getEmployeeName = (report: WeeklyReport) =>
    report.employee.name ?? report.employee.email ?? 'Unassigned employee';

export const getReportTitle = (report: WeeklyReport) => `${getEmployeeName(report)} ? Week ${report.week}`;

export const formatReportDate = (value: string | null | undefined) => {
    if (!value) {
        return 'Not available';
    }

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return 'Not available';
    }

    return new Intl.DateTimeFormat('en-US', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    }).format(date);
};

export const createReportPayload = (values: ReportFormValues): ReportPayload => ({
    achievements: values.achievements.trim(),
    activities: values.activities.trim(),
    department: values.department.trim(),
    difficulties: values.difficulties?.trim() || null,
    employee_id: values.employee_id,
    next_actions: values.next_actions.trim(),
    objectives: values.objectives.trim(),
    week: values.week.trim(),
});

export const getReportFormDefaults = (report?: WeeklyReport, employeeId?: number | null): ReportFormValues => ({
    achievements: report?.achievements ?? '',
    activities: report?.activities ?? '',
    department: report?.department ?? '',
    difficulties: report?.difficulties ?? '',
    employee_id: report?.employee.id ?? employeeId ?? 0,
    next_actions: report?.next_actions ?? '',
    objectives: report?.objectives ?? '',
    week: report?.week ?? '',
});

export const resolveReportAssetUrl = (path: string) => {
    if (/^https?:\/\//i.test(path)) {
        return path;
    }

    return path.startsWith('/') ? path : `/${path}`;
};
