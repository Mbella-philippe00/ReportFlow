import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import type { QueryClient } from '@tanstack/react-query';

import { analyticsQueryKeys } from '@/services/analytics.service';
import { dashboardQueryKeys } from '@/services/dashboard.service';
import { notificationsQueryKeys } from '@/services/notifications.service';
import { approveReport, finalApproveReport, listWorkflowQueue, rejectReport, reportsQueryKeys, submitReport } from '@/services/reports.service';
import type { ApiSuccessResponse, PaginatedApiResponse, ReportWorkflowAction, WeeklyReport } from '@/types';

export type WorkflowActionInput = {
    action: ReportWorkflowAction;
    comment?: string;
    id: number;
    reason?: string;
};

const updateWorkflowReportCaches = (queryClient: QueryClient, report: WeeklyReport) => {
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

const executeWorkflowAction = ({ action, comment, id, reason }: WorkflowActionInput) => {
    if (action === 'submit') {
        return submitReport({ id });
    }

    if (action === 'approve') {
        return approveReport({ comment, id });
    }

    if (action === 'final-approve') {
        return finalApproveReport({ id });
    }

    return rejectReport({ id, reason: reason ?? '' });
};

export const useWorkflowQueueQuery = () =>
    useQuery({
        queryFn: ({ signal }) => listWorkflowQueue({ signal }),
        queryKey: reportsQueryKeys.workflowQueue(),
    });

export const useWorkflowActionMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: executeWorkflowAction,
        onSuccess: (response) => {
            updateWorkflowReportCaches(queryClient, response.data);
            void queryClient.invalidateQueries({ queryKey: reportsQueryKeys.all });
            void queryClient.invalidateQueries({ queryKey: reportsQueryKeys.workflowQueue() });
            void queryClient.invalidateQueries({ queryKey: dashboardQueryKeys.detail() });
            void queryClient.invalidateQueries({ queryKey: analyticsQueryKeys.all });
            void queryClient.invalidateQueries({ queryKey: notificationsQueryKeys.all });
        },
    });
};
