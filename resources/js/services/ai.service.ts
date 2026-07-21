import { http } from '@/lib/http';
import type {
    AiAction,
    AiAssistPayload,
    AiDashboard,
    AiGeneration,
    AiGenerationPayload,
    AiHistoryFilters,
    AiHistoryResponse,
    AiProvider,
    AiSpecificEndpointAction,
    ApiSuccessResponse,
} from '@/types';

export type AiQueryOptions = {
    signal?: AbortSignal;
};

export type AiHistoryOptions = AiHistoryFilters & AiQueryOptions;

export type GenerateAiInput = AiGenerationPayload & {
    action: AiAction;
    reportId: number;
};

const specificActionPaths: Record<AiSpecificEndpointAction, string> = {
    action_items: 'action-items',
    executive_summary: 'executive-summary',
    grammar_tone: 'grammar-tone',
    missing_information: 'missing-information',
    quality_score: 'quality-score',
    risk_analysis: 'risk-analysis',
    workflow_recommendation: 'workflow-recommendation',
    writing_improvement: 'improve-writing',
};

const specificActions = new Set<AiAction>(Object.keys(specificActionPaths) as AiSpecificEndpointAction[]);

const buildQueryPath = (path: string, params: Record<string, number | string | undefined> = {}) => {
    const searchParams = new URLSearchParams();

    Object.entries(params).forEach(([key, value]) => {
        if (value !== undefined && value !== '') {
            searchParams.set(key, String(value));
        }
    });

    const queryString = searchParams.toString();

    return queryString ? `${path}?${queryString}` : path;
};

export const aiQueryKeys = {
    all: ['ai'] as const,
    dashboard: () => ['ai', 'dashboard'] as const,
    history: (filters: AiHistoryFilters = {}) => ['ai', 'history', filters] as const,
    providers: () => ['ai', 'providers'] as const,
};

export const getAiDashboard = ({ signal }: AiQueryOptions = {}) =>
    http<ApiSuccessResponse<AiDashboard>>('/ai/dashboard', {
        signal,
    });

export const getAiProviders = ({ signal }: AiQueryOptions = {}) =>
    http<ApiSuccessResponse<AiProvider[]>>('/ai/providers', {
        signal,
    });

export const getAiHistory = ({ signal, ...filters }: AiHistoryOptions = {}) =>
    http<AiHistoryResponse>(buildQueryPath('/ai/history', filters), {
        signal,
    });

export const generateReportAi = ({ action, reportId, ...payload }: GenerateAiInput) => {
    if (specificActions.has(action)) {
        const endpoint = specificActionPaths[action as AiSpecificEndpointAction];

        return http<ApiSuccessResponse<AiGeneration>>(`/ai/reports/${reportId}/${endpoint}`, {
            body: payload,
            method: 'POST',
        });
    }

    const assistPayload: AiAssistPayload = {
        ...payload,
        action,
    };

    return http<ApiSuccessResponse<AiGeneration>>(`/ai/reports/${reportId}/assist`, {
        body: assistPayload,
        method: 'POST',
    });
};
