import { z } from 'zod';

import type { AiAction } from '@/types';

export const aiActions = [
    'executive_summary',
    'writing_improvement',
    'rewrite_professionally',
    'grammar_tone',
    'action_items',
    'risk_analysis',
    'missing_information',
    'quality_score',
    'workflow_recommendation',
] as const satisfies readonly AiAction[];

export const aiSectionOptions = [
    'objectives',
    'activities',
    'achievements',
    'difficulties',
    'next_actions',
    'executive_summary',
] as const;

export const aiGenerationFormSchema = z.object({
    action: z.enum(aiActions),
    instructions: z.string().trim().max(2000, 'Instructions must be 2,000 characters or fewer.').optional(),
    locale: z.enum(['en', 'fr']),
    persist: z.boolean(),
    report_id: z.number({ error: 'Report ID is required.' }).int('Report ID must be an integer.').positive('Report ID must be positive.'),
    section: z.union([z.enum(aiSectionOptions), z.literal('')]).optional(),
    text: z.string().trim().max(12000, 'Selected text must be 12,000 characters or fewer.').optional(),
});

export type AiGenerationFormValues = z.infer<typeof aiGenerationFormSchema>;
