import { http } from '@/lib/http';
import type { ApiMessageResponse, ApiSuccessResponse, PaginatedApiResponse, ReportPayload, WeeklyReport } from '@/types';

export type ListReportsParams = {
    page?: number;
};

export type ListReportsOptions = ListReportsParams & {
    signal?: AbortSignal;
};

export type ReportMutationOptions = {
    signal?: AbortSignal;
};

export type UpdateReportInput = ReportMutationOptions & {
    id: number;
    payload: Partial<ReportPayload>;
};

export type ReportWorkflowInput = ReportMutationOptions & {
    comment?: string;
    id: number;
};

export type RejectReportInput = ReportWorkflowInput & {
    reason: string;
};

const buildReportsPath = ({ page }: ListReportsParams = {}) => {
    const searchParams = new URLSearchParams();

    if (typeof page === 'number' && page > 0) {
        searchParams.set('page', String(page));
    }

    const queryString = searchParams.toString();

    return queryString ? `/reports?${queryString}` : '/reports';
};

export const reportsQueryKeys = {
    all: ['reports'] as const,
    detail: (id: number) => ['reports', 'detail', id] as const,
    lists: () => ['reports', 'list'] as const,
    list: (params: ListReportsParams = {}) => ['reports', 'list', params] as const,
    workflowQueue: () => ['reports', 'workflow-queue'] as const,
};

export const listReports = ({ signal, ...params }: ListReportsOptions = {}) =>
    http<PaginatedApiResponse<WeeklyReport>>(buildReportsPath(params), {
        signal,
    });

export const listWorkflowQueue = ({ signal }: ReportMutationOptions = {}) =>
    http<ApiSuccessResponse<WeeklyReport[]>>('/reports/workflow/queue', {
        signal,
    });

export const getReport = (id: number, { signal }: ReportMutationOptions = {}) =>
    http<ApiSuccessResponse<WeeklyReport>>(`/reports/${id}`, {
        signal,
    });

export const createReport = (payload: ReportPayload, { signal }: ReportMutationOptions = {}) =>
    http<ApiSuccessResponse<WeeklyReport>>('/reports', {
        body: payload,
        method: 'POST',
        signal,
    });

export const updateReport = ({ id, payload, signal }: UpdateReportInput) =>
    http<ApiSuccessResponse<WeeklyReport>>(`/reports/${id}`, {
        body: payload,
        method: 'PUT',
        signal,
    });

export const deleteReport = (id: number, { signal }: ReportMutationOptions = {}) =>
    http<ApiMessageResponse>(`/reports/${id}`, {
        method: 'DELETE',
        signal,
    });

export const submitReport = ({ id, signal }: ReportWorkflowInput) =>
    http<ApiSuccessResponse<WeeklyReport>>(`/reports/${id}/submit`, {
        method: 'POST',
        signal,
    });

export const rejectReport = ({ id, reason, signal }: RejectReportInput) =>
    http<ApiSuccessResponse<WeeklyReport>>(`/reports/${id}/reject`, {
        body: { reason },
        method: 'POST',
        signal,
    });

export const approveReport = ({ comment, id, signal }: ReportWorkflowInput) =>
    http<ApiSuccessResponse<WeeklyReport>>(`/reports/${id}/approve`, {
        body: comment ? { comment } : {},
        method: 'POST',
        signal,
    });

export const finalApproveReport = ({ id, signal }: ReportWorkflowInput) =>
    http<ApiSuccessResponse<WeeklyReport>>(`/reports/${id}/final-approve`, {
        method: 'POST',
        signal,
    });
