import type { AnalyticsFilters, AnalyticsGranularity, AnalyticsPeriod, AnalyticsStatusDistributionItem, AuthUser, ReportStatusValue } from '@/types';

export const analyticsPeriodOptions: readonly { label: string; value: AnalyticsPeriod }[] = [
    { label: 'Today', value: 'today' },
    { label: 'Last 7 days', value: 'last_7_days' },
    { label: 'Last 30 days', value: 'last_30_days' },
    { label: 'Quarter', value: 'quarter' },
    { label: 'Year', value: 'year' },
    { label: 'Custom range', value: 'custom' },
];

export const analyticsGranularityOptions: readonly { label: string; value: AnalyticsGranularity }[] = [
    { label: 'Weekly', value: 'weekly' },
    { label: 'Monthly', value: 'monthly' },
    { label: 'Yearly', value: 'yearly' },
];

export const analyticsStatusOptions: readonly { label: string; value: '' | ReportStatusValue }[] = [
    { label: 'All statuses', value: '' },
    { label: 'Draft', value: 'draft' },
    { label: 'Submitted', value: 'submitted' },
    { label: 'Under Review', value: 'under_review' },
    { label: 'Approved', value: 'approved' },
    { label: 'Rejected', value: 'rejected' },
];

export const analyticsNavItems = [
    { label: 'Dashboard', path: '/analytics' },
    { label: 'Executive', path: '/analytics/executive' },
    { label: 'Reports', path: '/analytics/reports' },
    { label: 'Employees', path: '/analytics/employees' },
    { label: 'Departments', path: '/analytics/departments' },
    { label: 'Workflow', path: '/analytics/workflow' },
    { label: 'Activity', path: '/analytics/activity' },
] as const;

const numberFormatter = new Intl.NumberFormat('en-US');
const compactNumberFormatter = new Intl.NumberFormat('en-US', { maximumFractionDigits: 1, notation: 'compact' });
const dateTimeFormatter = new Intl.DateTimeFormat('en-US', {
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    month: 'short',
    year: 'numeric',
});

export const formatAnalyticsNumber = (value: number | null | undefined) => numberFormatter.format(value ?? 0);

export const formatCompactNumber = (value: number | null | undefined) => compactNumberFormatter.format(value ?? 0);

export const formatAnalyticsPercent = (value: number | null | undefined) => `${numberFormatter.format(value ?? 0)}%`;

export const formatAnalyticsDateTime = (value: string | null | undefined) => {
    if (!value) {
        return 'Not available';
    }

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return 'Not available';
    }

    return dateTimeFormatter.format(date);
};

export const formatRelativeTime = (value: string | null | undefined) => {
    if (!value) {
        return 'Not available';
    }

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return 'Not available';
    }

    const elapsedMinutes = Math.max(0, Math.floor((Date.now() - date.getTime()) / 60_000));

    if (elapsedMinutes < 1) {
        return 'Just now';
    }

    if (elapsedMinutes < 60) {
        return `${elapsedMinutes}m ago`;
    }

    const elapsedHours = Math.floor(elapsedMinutes / 60);

    if (elapsedHours < 24) {
        return `${elapsedHours}h ago`;
    }

    const elapsedDays = Math.floor(elapsedHours / 24);

    if (elapsedDays < 7) {
        return `${elapsedDays}d ago`;
    }

    return formatAnalyticsDateTime(value);
};

export const getAnalyticsErrorMessage = (error: unknown, fallback = 'Analytics data could not be loaded.') =>
    error instanceof Error ? error.message : fallback;

export const sanitizeAnalyticsFilters = (filters: AnalyticsFilters): AnalyticsFilters => {
    const normalized: AnalyticsFilters = {
        period: filters.period ?? 'last_30_days',
    };

    if (filters.department?.trim()) {
        normalized.department = filters.department.trim();
    }

    if (filters.employee !== undefined && filters.employee !== null && String(filters.employee).trim() !== '') {
        normalized.employee = String(filters.employee).trim();
    }

    if (filters.status) {
        normalized.status = filters.status;
    }

    if (filters.granularity) {
        normalized.granularity = filters.granularity;
    }

    if (normalized.period === 'custom') {
        if (filters.from) {
            normalized.from = filters.from;
        }

        if (filters.to) {
            normalized.to = filters.to;
        }
    }

    return normalized;
};

export const getStatusBadgeIntent = (status: AnalyticsStatusDistributionItem['color']): 'danger' | 'neutral' | 'primary' | 'success' | 'warning' => {
    if (status === 'danger') {
        return 'danger';
    }

    if (status === 'success') {
        return 'success';
    }

    if (status === 'warning') {
        return 'warning';
    }

    if (status === 'info') {
        return 'primary';
    }

    return 'neutral';
};

export const getStatusChartColor = (status: ReportStatusValue | string) => {
    const colors: Record<string, string> = {
        draft: '#64748b',
        approved: '#16a34a',
        under_review: '#2563eb',
        rejected: '#dc2626',
        submitted: '#f59e0b',
    };

    return colors[status] ?? '#2563eb';
};

export const getChartPaletteColor = (index: number) => {
    const palette = ['#2563eb', '#16a34a', '#f59e0b', '#dc2626', '#7c3aed', '#0891b2', '#db2777', '#64748b'];

    return palette[index % palette.length];
};

export const getWorkflowStageLabel = (stage: string) =>
    stage
        .split('_')
        .map((part) => part.charAt(0).toUpperCase() + part.slice(1))
        .join(' ');

export const canViewAnalytics = (user: AuthUser | null) => Boolean(user?.roles.some((role) => role === 'manager' || role === 'super-admin'));
