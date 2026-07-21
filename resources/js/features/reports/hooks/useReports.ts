import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';

import { dashboardQueryKeys } from '@/services/dashboard.service';
import { analyticsQueryKeys } from '@/services/analytics.service';
import {
    createReport,
    deleteReport,
    getReport,
    listReports,
    reportsQueryKeys,
    submitReport,
    updateReport,
} from '@/services/reports.service';
import type { ListReportsParams } from '@/services/reports.service';
import type { ApiSuccessResponse, PaginatedApiResponse, ReportPayload, WeeklyReport } from '@/types';

const updateReportCaches = (queryClient: ReturnType<typeof useQueryClient>, report: WeeklyReport) => {
    queryClient.setQueryData<ApiSuccessResponse<WeeklyReport>>(reportsQueryKeys.detail(report.id), {
        data: report,
        success: true,
    });

    queryClient.setQueriesData<PaginatedApiResponse<WeeklyReport>>({ queryKey: reportsQueryKeys.lists() }, (current) => {
        if (!current) {
            return current;
        }

        return {
            ...current,
            data: current.data.map((item) => (item.id === report.id ? report : item)),
        };
    });
};

export const useReportsQuery = (params: ListReportsParams = {}) =>
    useQuery({
        queryFn: ({ signal }) => listReports({ ...params, signal }),
        queryKey: reportsQueryKeys.list(params),
    });

export const useReportQuery = (id: number | undefined) =>
    useQuery({
        enabled: typeof id === 'number' && Number.isFinite(id),
        queryFn: ({ signal }) => getReport(id as number, { signal }),
        queryKey: typeof id === 'number' ? reportsQueryKeys.detail(id) : ['reports', 'detail', 'invalid'],
    });

export const useCreateReportMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (payload: ReportPayload) => createReport(payload),
        onSuccess: (response) => {
            queryClient.setQueryData(reportsQueryKeys.detail(response.data.id), response);
            void queryClient.invalidateQueries({ queryKey: reportsQueryKeys.lists() });
            void queryClient.invalidateQueries({ queryKey: dashboardQueryKeys.detail() });
            void queryClient.invalidateQueries({ queryKey: analyticsQueryKeys.all });
        },
    });
};

export const useUpdateReportMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: ({ id, payload }: { id: number; payload: Partial<ReportPayload> }) => updateReport({ id, payload }),
        onSuccess: (response) => {
            updateReportCaches(queryClient, response.data);
            void queryClient.invalidateQueries({ queryKey: dashboardQueryKeys.detail() });
            void queryClient.invalidateQueries({ queryKey: analyticsQueryKeys.all });
        },
    });
};

export const useDeleteReportMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (id: number) => deleteReport(id),
        onMutate: async (id) => {
            await queryClient.cancelQueries({ queryKey: reportsQueryKeys.lists() });

            const previousLists = queryClient.getQueriesData<PaginatedApiResponse<WeeklyReport>>({ queryKey: reportsQueryKeys.lists() });

            queryClient.setQueriesData<PaginatedApiResponse<WeeklyReport>>({ queryKey: reportsQueryKeys.lists() }, (current) => {
                if (!current) {
                    return current;
                }

                return {
                    ...current,
                    data: current.data.filter((report) => report.id !== id),
                    meta: {
                        ...current.meta,
                        total: Math.max(0, current.meta.total - 1),
                    },
                };
            });

            return { previousLists };
        },
        onError: (_error, _id, context) => {
            context?.previousLists.forEach(([queryKey, data]) => {
                queryClient.setQueryData(queryKey, data);
            });
        },
        onSettled: () => {
            void queryClient.invalidateQueries({ queryKey: reportsQueryKeys.all });
            void queryClient.invalidateQueries({ queryKey: dashboardQueryKeys.detail() });
            void queryClient.invalidateQueries({ queryKey: analyticsQueryKeys.all });
        },
    });
};

export const useSubmitReportMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (id: number) => submitReport({ id }),
        onSuccess: (response) => {
            updateReportCaches(queryClient, response.data);
            void queryClient.invalidateQueries({ queryKey: reportsQueryKeys.all });
            void queryClient.invalidateQueries({ queryKey: dashboardQueryKeys.detail() });
            void queryClient.invalidateQueries({ queryKey: analyticsQueryKeys.all });
        },
    });
};