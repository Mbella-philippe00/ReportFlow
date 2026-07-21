import type { SelectOption } from '@/components/ui';
import type { AiAction, AiHistoryItem, AuthUser } from '@/types';

export type AiActionMeta = {
    description: string;
    label: string;
    resultTitle: string;
};

export type AiHistoryGroup = {
    items: AiHistoryItem[];
    label: string;
};

const day = 24 * 60 * 60 * 1000;

export const aiActionMeta: Record<AiAction, AiActionMeta> = {
    action_items: {
        description: 'Extract concrete next steps and owners from a weekly report.',
        label: 'Action Items',
        resultTitle: 'Extracted action items',
    },
    executive_summary: {
        description: 'Generate a concise executive summary for leadership review.',
        label: 'Executive Summary',
        resultTitle: 'Executive summary',
    },
    grammar_tone: {
        description: 'Correct grammar and improve tone while preserving meaning.',
        label: 'Grammar & Tone',
        resultTitle: 'Grammar and tone correction',
    },
    missing_information: {
        description: 'Detect missing context, weak sections, and incomplete report details.',
        label: 'Missing Information',
        resultTitle: 'Missing information analysis',
    },
    quality_score: {
        description: 'Score report quality and explain how to improve it.',
        label: 'Quality Score',
        resultTitle: 'Report quality score',
    },
    rewrite_professionally: {
        description: 'Rewrite selected report content in a polished professional style.',
        label: 'Rewrite Professionally',
        resultTitle: 'Professional rewrite',
    },
    risk_analysis: {
        description: 'Identify delivery, workflow, dependency, and operational risks.',
        label: 'Risk Analysis',
        resultTitle: 'Risk analysis',
    },
    workflow_recommendation: {
        description: 'Recommend an approval decision and highlight review concerns.',
        label: 'Workflow Recommendation',
        resultTitle: 'Workflow recommendation',
    },
    writing_improvement: {
        description: 'Improve clarity, structure, and wording for a weekly report.',
        label: 'Writing Improvement',
        resultTitle: 'Improved writing',
    },
};

export const aiActionOptions: readonly SelectOption[] = Object.entries(aiActionMeta).map(([value, meta]) => ({
    label: meta.label,
    value,
}));

export const aiSectionOptions: readonly SelectOption[] = [
    { label: 'Entire report', value: '' },
    { label: 'Objectives', value: 'objectives' },
    { label: 'Activities', value: 'activities' },
    { label: 'Achievements', value: 'achievements' },
    { label: 'Difficulties', value: 'difficulties' },
    { label: 'Next actions', value: 'next_actions' },
    { label: 'Executive summary', value: 'executive_summary' },
];

export const aiLocaleOptions: readonly SelectOption[] = [
    { label: 'French', value: 'fr' },
    { label: 'English', value: 'en' },
];

export const aiHistoryScopeOptions: readonly SelectOption[] = [
    { label: 'My history', value: 'mine' },
    { label: 'All users', value: 'all' },
];

export const formatAiAction = (action: string): string => aiActionMeta[action as AiAction]?.label ?? action.replaceAll('_', ' ');

export const getAiActionDescription = (action: AiAction): string => aiActionMeta[action].description;

export const getAiResultTitle = (action: string): string => aiActionMeta[action as AiAction]?.resultTitle ?? 'AI result';

export const canUseAi = (user: AuthUser | null): boolean => Boolean(user);

export const canViewAiDashboard = (user: AuthUser | null): boolean => Boolean(user?.roles.includes('manager') || user?.roles.includes('super-admin'));

export const canRequestWorkflowRecommendation = (user: AuthUser | null): boolean => canViewAiDashboard(user);

export const getAvailableReportAssistantActions = (user: AuthUser | null): AiAction[] => {
    const actions: AiAction[] = [
        'writing_improvement',
        'rewrite_professionally',
        'grammar_tone',
        'executive_summary',
        'action_items',
        'risk_analysis',
        'missing_information',
        'quality_score',
    ];

    if (canRequestWorkflowRecommendation(user)) {
        actions.push('workflow_recommendation');
    }

    return actions;
};

const startOfToday = () => {
    const value = new Date();
    value.setHours(0, 0, 0, 0);

    return value;
};

const startOfYesterday = () => {
    const value = startOfToday();
    value.setDate(value.getDate() - 1);

    return value;
};

const startOfWeek = () => {
    const value = startOfToday();
    const dayOfWeek = value.getDay();
    const daysSinceMonday = dayOfWeek === 0 ? 6 : dayOfWeek - 1;
    value.setDate(value.getDate() - daysSinceMonday);

    return value;
};

export const formatAiDate = (value: string | null): string => {
    if (!value) {
        return 'Not available';
    }

    return new Intl.DateTimeFormat(undefined, {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(new Date(value));
};

export const formatRelativeAiTime = (value: string): string => {
    const timestamp = new Date(value).getTime();

    if (!Number.isFinite(timestamp)) {
        return 'Recently';
    }

    const diff = Date.now() - timestamp;

    if (diff < 60_000) {
        return 'Just now';
    }

    if (diff < 60 * 60_000) {
        const minutes = Math.max(1, Math.floor(diff / 60_000));
        return `${minutes} min ago`;
    }

    if (diff < day) {
        const hours = Math.max(1, Math.floor(diff / (60 * 60_000)));
        return `${hours} hr ago`;
    }

    if (diff < 7 * day) {
        const days = Math.max(1, Math.floor(diff / day));
        return `${days} day${days === 1 ? '' : 's'} ago`;
    }

    return new Intl.DateTimeFormat(undefined, { dateStyle: 'medium' }).format(new Date(value));
};

export const groupAiHistoryByDate = (items: readonly AiHistoryItem[]): AiHistoryGroup[] => {
    const today = startOfToday();
    const yesterday = startOfYesterday();
    const week = startOfWeek();
    const todayGroup: AiHistoryGroup = { items: [], label: 'Today' };
    const yesterdayGroup: AiHistoryGroup = { items: [], label: 'Yesterday' };
    const earlierThisWeekGroup: AiHistoryGroup = { items: [], label: 'Earlier This Week' };
    const earlierGroup: AiHistoryGroup = { items: [], label: 'Earlier' };

    items.forEach((item) => {
        const createdAt = new Date(item.created_at);

        if (createdAt >= today) {
            todayGroup.items.push(item);
            return;
        }

        if (createdAt >= yesterday) {
            yesterdayGroup.items.push(item);
            return;
        }

        if (createdAt >= week) {
            earlierThisWeekGroup.items.push(item);
            return;
        }

        earlierGroup.items.push(item);
    });

    return [todayGroup, yesterdayGroup, earlierThisWeekGroup, earlierGroup].filter((group) => group.items.length > 0);
};
