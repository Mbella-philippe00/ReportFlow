import { http } from '@/lib/http';
import type {
    AnalyticsActivityResponse,
    AnalyticsDataset,
    AnalyticsDepartmentData,
    AnalyticsEmployeeData,
    AnalyticsExportOptions,
    AnalyticsFilters,
    AnalyticsOverview,
    AnalyticsReportsData,
    AnalyticsResponse,
    AnalyticsTrendPoint,
    AnalyticsWorkflowData,
    ApiSuccessResponse,
} from '@/types';

export type ListAnalyticsOptions = AnalyticsFilters & {
    signal?: AbortSignal;
};

const buildAnalyticsPath = (path: string, params: AnalyticsFilters = {}) => {
    const searchParams = new URLSearchParams();

    Object.entries(params).forEach(([key, value]) => {
        if (value !== undefined && value !== null && value !== '') {
            searchParams.set(key, String(value));
        }
    });

    const queryString = searchParams.toString();

    return queryString ? `${path}?${queryString}` : path;
};

export const analyticsQueryKeys = {
    activity: (params: AnalyticsFilters = {}) => ['analytics', 'activity', params] as const,
    all: ['analytics'] as const,
    departments: (params: AnalyticsFilters = {}) => ['analytics', 'departments', params] as const,
    employees: (params: AnalyticsFilters = {}) => ['analytics', 'employees', params] as const,
    exportOptions: () => ['analytics', 'export-options'] as const,
    overview: (params: AnalyticsFilters = {}) => ['analytics', 'overview', params] as const,
    reports: (params: AnalyticsFilters = {}) => ['analytics', 'reports', params] as const,
    trends: (params: AnalyticsFilters = {}) => ['analytics', 'trends', params] as const,
    workflow: (params: AnalyticsFilters = {}) => ['analytics', 'workflow', params] as const,
};

export const getAnalyticsOverview = ({ signal, ...params }: ListAnalyticsOptions = {}) =>
    http<AnalyticsResponse<AnalyticsOverview>>(buildAnalyticsPath('/analytics/overview', params), {
        signal,
    });

export const getAnalyticsTrends = ({ signal, ...params }: ListAnalyticsOptions = {}) =>
    http<AnalyticsResponse<AnalyticsDataset<AnalyticsTrendPoint[], { granularity: string }>>>(buildAnalyticsPath('/analytics/trends', params), {
        signal,
    });

export const getAnalyticsReports = ({ signal, ...params }: ListAnalyticsOptions = {}) =>
    http<AnalyticsResponse<AnalyticsDataset<AnalyticsReportsData, { total_reports: number }>>>(buildAnalyticsPath('/analytics/reports', params), {
        signal,
    });

export const getAnalyticsEmployees = ({ signal, ...params }: ListAnalyticsOptions = {}) =>
    http<AnalyticsResponse<AnalyticsDataset<AnalyticsEmployeeData[], { total_employees: number }>>>(buildAnalyticsPath('/analytics/employees', params), {
        signal,
    });

export const getAnalyticsDepartments = ({ signal, ...params }: ListAnalyticsOptions = {}) =>
    http<AnalyticsResponse<AnalyticsDataset<AnalyticsDepartmentData[], { total_departments: number }>>>(buildAnalyticsPath('/analytics/departments', params), {
        signal,
    });

export const getAnalyticsWorkflow = ({ signal, ...params }: ListAnalyticsOptions = {}) =>
    http<AnalyticsResponse<AnalyticsDataset<AnalyticsWorkflowData, { total_reports: number }>>>(buildAnalyticsPath('/analytics/workflow', params), {
        signal,
    });

export const getAnalyticsActivity = ({ signal, ...params }: ListAnalyticsOptions = {}) =>
    http<AnalyticsActivityResponse>(buildAnalyticsPath('/analytics/activity', params), {
        signal,
    });

export const getAnalyticsExportOptions = ({ signal }: { signal?: AbortSignal } = {}) =>
    http<ApiSuccessResponse<AnalyticsExportOptions>>('/analytics/export-options', {
        signal,
    });


import type { ExecutiveAnalyticsAlert, ExecutiveComparisonsData, ExecutiveDashboardData, ExecutiveKpiCenterData, ExecutiveReportData } from '@/types';

export const getExecutiveAnalyticsDashboard = ({ signal, ...params }: ListAnalyticsOptions = {}) =>
    http<AnalyticsResponse<AnalyticsDataset<ExecutiveDashboardData>>>(buildAnalyticsPath('/analytics/executive-dashboard', params), {
        signal,
    });

export const getExecutiveKpiCenter = ({ signal, ...params }: ListAnalyticsOptions = {}) =>
    http<AnalyticsResponse<AnalyticsDataset<ExecutiveKpiCenterData>>>(buildAnalyticsPath('/analytics/kpi-center', params), {
        signal,
    });

export const getExecutiveComparisons = ({ signal, ...params }: ListAnalyticsOptions = {}) =>
    http<AnalyticsResponse<AnalyticsDataset<ExecutiveComparisonsData>>>(buildAnalyticsPath('/analytics/comparisons', params), {
        signal,
    });

export const getExecutiveAlerts = ({ signal, ...params }: ListAnalyticsOptions = {}) =>
    http<AnalyticsResponse<AnalyticsDataset<ExecutiveAnalyticsAlert[], { critical: number; high: number; medium: number; total_alerts: number }>>>(buildAnalyticsPath('/analytics/alerts', params), {
        signal,
    });

export const getExecutiveReport = ({ signal, ...params }: ListAnalyticsOptions = {}) =>
    http<AnalyticsResponse<AnalyticsDataset<ExecutiveReportData>>>(buildAnalyticsPath('/analytics/executive-report', params), {
        signal,
    });
