import { http } from '@/lib/http';
import type { ApiSuccessResponse, DashboardData } from '@/types';

export const dashboardQueryKeys = {
    detail: () => ['dashboard'] as const,
};

export type GetDashboardOptions = {
    signal?: AbortSignal;
};

export const getDashboard = ({ signal }: GetDashboardOptions = {}) =>
    http<ApiSuccessResponse<DashboardData>>('/dashboard', {
        signal,
    });
