import type { PaginationMeta } from './api';

export type AiAction =
    | 'action_items'
    | 'executive_summary'
    | 'grammar_tone'
    | 'missing_information'
    | 'quality_score'
    | 'risk_analysis'
    | 'rewrite_professionally'
    | 'workflow_recommendation'
    | 'writing_improvement';

export type AiSpecificEndpointAction = Exclude<AiAction, 'rewrite_professionally'>;

export type AiSection = 'achievements' | 'activities' | 'difficulties' | 'executive_summary' | 'next_actions' | 'objectives';

export type AiProvider = {
    active?: boolean;
    configured: boolean;
    default_model: string | null;
    label: string;
    models: string[];
    name: string;
};

export type AiActionUsage = {
    action: AiAction | string;
    label: string;
    total: number;
};

export type AiReportReference = {
    department: string | null;
    executive_summary?: string | null;
    id: number | null;
    status: string | null;
    week: string | null;
};

export type AiHistoryCauser = {
    email: string | null;
    id: number;
    name: string;
};

export type AiHistoryItem = {
    action: AiAction | string;
    causer: AiHistoryCauser | null;
    content: string;
    created_at: string;
    id: number;
    model: string | null;
    persisted: boolean;
    provider: string;
    report: AiReportReference | null;
    section: AiSection | null;
};

export type AiDashboard = {
    available_actions: string[];
    by_action: AiActionUsage[];
    providers: AiProvider[];
    recent: AiHistoryItem[];
    today_generations: number;
    total_generations: number;
};

export type AiGeneration = {
    action: AiAction | string;
    content: string;
    created_at: string;
    history_id: number | null;
    metadata: {
        persisted?: boolean;
        section?: AiSection | null;
        [key: string]: unknown;
    };
    model: string | null;
    provider: string;
    report: AiReportReference | null;
};

export type AiGenerationPayload = {
    instructions?: string;
    locale?: 'en' | 'fr';
    persist?: boolean;
    section?: AiSection;
    text?: string;
};

export type AiAssistPayload = AiGenerationPayload & {
    action: AiAction;
};

export type AiHistoryFilters = {
    action?: AiAction | '';
    page?: number;
    per_page?: number;
    report_id?: number;
    scope?: 'all' | 'mine';
};

export type AiHistoryResponse = {
    data: AiHistoryItem[];
    meta: PaginationMeta;
    success: true;
};
