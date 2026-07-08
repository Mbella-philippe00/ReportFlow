import { zodResolver } from '@hookform/resolvers/zod';
import { AlertCircle, Save } from 'lucide-react';
import { useEffect } from 'react';
import { useForm } from 'react-hook-form';

import { reportFormSchema } from '@/features/reports/schemas/report.schema';
import type { ReportFormValues } from '@/features/reports/schemas/report.schema';
import { createReportPayload } from '@/features/reports/utils/report-utils';
import { HttpError } from '@/lib/http';
import { Alert, Button, Card, CardContent, CardHeader, CardTitle, Input, Textarea } from '@/components/ui';
import type { ReportPayload } from '@/types';

export type ReportFormProps = {
    defaultValues: ReportFormValues;
    disabled?: boolean;
    onCancel?: () => void;
    onSubmit: (payload: ReportPayload) => Promise<void>;
    submitLabel: string;
};

const reportFieldLabels: Record<keyof ReportFormValues, string> = {
    achievements: 'Achievements',
    activities: 'Activities',
    department: 'Department',
    difficulties: 'Difficulties',
    employee_id: 'Employee ID',
    next_actions: 'Next actions',
    objectives: 'Objectives',
    week: 'Week',
};

export function ReportForm({ defaultValues, disabled = false, onCancel, onSubmit, submitLabel }: ReportFormProps) {
    const {
        formState: { errors, isSubmitting },
        handleSubmit,
        register,
        reset,
        setError,
    } = useForm<ReportFormValues>({
        defaultValues,
        resolver: zodResolver(reportFormSchema),
    });

    useEffect(() => {
        reset(defaultValues);
    }, [defaultValues, reset]);

    const submitForm = handleSubmit(async (values) => {
        try {
            await onSubmit(createReportPayload(values));
        } catch (error) {
            if (error instanceof HttpError && error.validationErrors) {
                Object.entries(error.validationErrors).forEach(([field, messages]) => {
                    if (field in reportFieldLabels) {
                        setError(field as keyof ReportFormValues, {
                            message: messages[0] ?? `${reportFieldLabels[field as keyof ReportFormValues]} is invalid.`,
                            type: 'server',
                        });
                    }
                });

                return;
            }

            setError('root', {
                message: error instanceof Error ? error.message : 'The report could not be saved.',
                type: 'server',
            });
        }
    });

    const submitting = disabled || isSubmitting;

    return (
        <form className="grid gap-6" onSubmit={submitForm}>
            {errors.root?.message && (
                <Alert
                    description={errors.root.message}
                    icon={<AlertCircle aria-hidden="true" className="size-5" />}
                    intent="danger"
                    title="Unable to save report"
                />
            )}

            <Card>
                <CardHeader>
                    <CardTitle>Report metadata</CardTitle>
                </CardHeader>
                <CardContent className="grid gap-4 md:grid-cols-3">
                    <Input
                        error={errors.employee_id?.message}
                        helperText="Required by the existing Reports API."
                        label="Employee ID"
                        min={1}
                        type="number"
                        {...register('employee_id', { valueAsNumber: true })}
                    />
                    <Input error={errors.department?.message} label="Department" {...register('department')} />
                    <Input error={errors.week?.message} helperText="Example: 2026-W27" label="Week" {...register('week')} />
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>Weekly content</CardTitle>
                </CardHeader>
                <CardContent className="grid gap-4">
                    <Textarea error={errors.objectives?.message} label="Objectives" {...register('objectives')} />
                    <Textarea error={errors.activities?.message} label="Activities" {...register('activities')} />
                    <Textarea error={errors.achievements?.message} label="Achievements" {...register('achievements')} />
                    <Textarea error={errors.difficulties?.message} label="Difficulties" {...register('difficulties')} />
                    <Textarea error={errors.next_actions?.message} label="Next actions" {...register('next_actions')} />

                </CardContent>
            </Card>

            <div className="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                {onCancel && (
                    <Button disabled={submitting} onClick={onCancel} type="button" variant="outline">
                        Cancel
                    </Button>
                )}
                <Button leftIcon={<Save aria-hidden="true" className="size-4" />} loading={submitting} type="submit">
                    {submitLabel}
                </Button>
            </div>
        </form>
    );
}