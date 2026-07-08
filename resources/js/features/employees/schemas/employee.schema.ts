import { z } from 'zod';

const optionalText = z.string().trim().optional();

export const employeeFormSchema = z.object({
    active: z.boolean(),
    department: optionalText,
    email: z.string().trim().min(1, 'Email is required.').email('Enter a valid email address.'),
    first_name: z.string().trim().min(1, 'First name is required.').max(255, 'First name must be 255 characters or fewer.'),
    last_name: z.string().trim().min(1, 'Last name is required.').max(255, 'Last name must be 255 characters or fewer.'),
    user_id: z.string().trim().refine((value) => value === '' || /^\d+$/.test(value), 'User ID must be a positive integer.').optional(),
});

export type EmployeeFormValues = z.infer<typeof employeeFormSchema>;