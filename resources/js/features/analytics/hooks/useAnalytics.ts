import { useQuery } from '@tanstack/react-query';

import {
    analyticsQueryKeys,
    getAnalyticsActivity,
    getAnalyticsDepartments,
    getAnalyticsEmployees,
    getAnalyticsExportOptions,
    getAnalyticsOverview,
    getAnalyticsReports,
    getAnalyticsTrends,
    getAnalyticsWorkflow,
} from '@/services/analytics.service';
import type { AnalyticsFilters } from '@/types';

const analyticsStaleTime = 60_000;

export const useAnalyticsOverviewQuery = (filters: AnalyticsFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getAnalyticsOverview({ ...filters, signal }),
        queryKey: analyticsQueryKeys.overview(filters),
        staleTime: analyticsStaleTime,
    });

export const useAnalyticsTrendsQuery = (filters: AnalyticsFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getAnalyticsTrends({ ...filters, signal }),
        queryKey: analyticsQueryKeys.trends(filters),
        staleTime: analyticsStaleTime,
    });

export const useAnalyticsReportsQuery = (filters: AnalyticsFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getAnalyticsReports({ ...filters, signal }),
        queryKey: analyticsQueryKeys.reports(filters),
        staleTime: analyticsStaleTime,
    });

export const useAnalyticsEmployeesQuery = (filters: AnalyticsFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getAnalyticsEmployees({ ...filters, signal }),
        queryKey: analyticsQueryKeys.employees(filters),
        staleTime: analyticsStaleTime,
    });

export const useAnalyticsDepartmentsQuery = (filters: AnalyticsFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getAnalyticsDepartments({ ...filters, signal }),
        queryKey: analyticsQueryKeys.departments(filters),
        staleTime: analyticsStaleTime,
    });

export const useAnalyticsWorkflowQuery = (filters: AnalyticsFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getAnalyticsWorkflow({ ...filters, signal }),
        queryKey: analyticsQueryKeys.workflow(filters),
        staleTime: analyticsStaleTime,
    });

export const useAnalyticsActivityQuery = (filters: AnalyticsFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getAnalyticsActivity({ ...filters, signal }),
        queryKey: analyticsQueryKeys.activity(filters),
        staleTime: analyticsStaleTime,
    });

export const useAnalyticsExportOptionsQuery = () =>
    useQuery({
        queryFn: ({ signal }) => getAnalyticsExportOptions({ signal }),
        queryKey: analyticsQueryKeys.exportOptions(),
        staleTime: 5 * 60_000,
    });


import { getExecutiveAlerts, getExecutiveAnalyticsDashboard, getExecutiveComparisons, getExecutiveKpiCenter, getExecutiveReport } from '@/services/analytics.service';

export const useExecutiveAnalyticsDashboardQuery = (filters: AnalyticsFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getExecutiveAnalyticsDashboard({ ...filters, signal }),
        queryKey: ['analytics', 'executive-dashboard', filters],
        staleTime: analyticsStaleTime,
    });

export const useExecutiveKpiCenterQuery = (filters: AnalyticsFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getExecutiveKpiCenter({ ...filters, signal }),
        queryKey: ['analytics', 'kpi-center', filters],
        staleTime: analyticsStaleTime,
    });

export const useExecutiveComparisonsQuery = (filters: AnalyticsFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getExecutiveComparisons({ ...filters, signal }),
        queryKey: ['analytics', 'executive-comparisons', filters],
        staleTime: analyticsStaleTime,
    });

export const useExecutiveAlertsQuery = (filters: AnalyticsFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getExecutiveAlerts({ ...filters, signal }),
        queryKey: ['analytics', 'executive-alerts', filters],
        staleTime: analyticsStaleTime,
    });

export const useExecutiveReportQuery = (filters: AnalyticsFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getExecutiveReport({ ...filters, signal }),
        queryKey: ['analytics', 'executive-report', filters],
        staleTime: analyticsStaleTime,
    });
