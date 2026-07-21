import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';

import { aiQueryKeys, generateReportAi, getAiDashboard, getAiHistory, getAiProviders } from '@/services/ai.service';
import { analyticsQueryKeys } from '@/services/analytics.service';
import { dashboardQueryKeys } from '@/services/dashboard.service';
import type { GenerateAiInput } from '@/services/ai.service';
import { reportsQueryKeys } from '@/services/reports.service';
import type { AiHistoryFilters } from '@/types';

const aiStaleTime = 60_000;

export const useAiDashboardQuery = () =>
    useQuery({
        queryFn: ({ signal }) => getAiDashboard({ signal }),
        queryKey: aiQueryKeys.dashboard(),
        staleTime: aiStaleTime,
    });

export const useAiProvidersQuery = () =>
    useQuery({
        queryFn: ({ signal }) => getAiProviders({ signal }),
        queryKey: aiQueryKeys.providers(),
        staleTime: 5 * aiStaleTime,
    });

export const useAiHistoryQuery = (filters: AiHistoryFilters = {}) =>
    useQuery({
        queryFn: ({ signal }) => getAiHistory({ ...filters, signal }),
        queryKey: aiQueryKeys.history(filters),
        staleTime: aiStaleTime,
    });

export const useAiGenerationMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (input: GenerateAiInput) => generateReportAi(input),
        onSuccess: (response, input) => {
            void queryClient.invalidateQueries({ queryKey: aiQueryKeys.dashboard() });
            void queryClient.invalidateQueries({ queryKey: ['ai', 'history'] });

            if (input.action === 'executive_summary' && response.data.metadata.persisted) {
                void queryClient.invalidateQueries({ queryKey: reportsQueryKeys.detail(input.reportId) });
                void queryClient.invalidateQueries({ queryKey: reportsQueryKeys.lists() });
                void queryClient.invalidateQueries({ queryKey: dashboardQueryKeys.detail() });
                void queryClient.invalidateQueries({ queryKey: analyticsQueryKeys.all });
            }
        },
    });
};
