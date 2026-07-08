import { z } from 'zod';

const requiredText = (label: string) => z.string().trim().min(1, `${label} is required.`);
const optionalText = z.string().trim().optional();

export const reportFormSchema = z.object({
    achievements: requiredText('Achievements'),
    activities: requiredText('Activities'),
    department: requiredText('Department').max(255, 'Department must be 255 characters or fewer.'),
    difficulties: optionalText,
    employee_id: z.number({ error: 'Employee ID is required.' }).int('Employee ID must be an integer.').positive('Employee ID must be positive.'),
    next_actions: requiredText('Next actions'),
    objectives: requiredText('Objectives'),
    week: requiredText('Week').max(20, 'Week must be 20 characters or fewer.'),
});

export type ReportFormValues = z.infer<typeof reportFormSchema>;