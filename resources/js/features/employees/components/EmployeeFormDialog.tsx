import { zodResolver } from '@hookform/resolvers/zod';
import { AlertCircle } from 'lucide-react';
import { useEffect } from 'react';
import { useForm } from 'react-hook-form';

import { Alert, Button, Input, Modal, Switch } from '@/components/ui';
import { getErrorMessage, getValidationSummary } from '@/lib/errors';
import { HttpError } from '@/lib/http';
import { useToast } from '@/providers/ToastProvider';
import type { Employee, EmployeePayload } from '@/types';
import { employeeFormSchema } from '../schemas/employee.schema';
import type { EmployeeFormValues } from '../schemas/employee.schema';
import { createEmployeePayload, getEmployeeFormDefaults } from '../utils/employee-utils';

export type EmployeeFormDialogProps = {
    employee?: Employee | null;
    isPending?: boolean;
    onOpenChange: (open: boolean) => void;
    onSubmit: (payload: EmployeePayload) => Promise<void>;
    open: boolean;
};

const fieldLabels: Record<keyof EmployeeFormValues, string> = {
    active: 'Active status',
    department: 'Department',
    email: 'Email',
    first_name: 'First name',
    last_name: 'Last name',
    user_id: 'User ID',
};

export function EmployeeFormDialog({ employee = null, isPending = false, onOpenChange, onSubmit, open }: EmployeeFormDialogProps) {
    const { notify } = useToast();
    const {
        formState: { errors, isSubmitting },
        handleSubmit,
        register,
        reset,
        setError,
    } = useForm<EmployeeFormValues>({
        defaultValues: getEmployeeFormDefaults(employee),
        resolver: zodResolver(employeeFormSchema),
    });

    useEffect(() => {
        if (open) {
            reset(getEmployeeFormDefaults(employee));
        }
    }, [employee, open, reset]);

    const submitForm = handleSubmit(async (values) => {
        try {
            await onSubmit(createEmployeePayload(values));
            onOpenChange(false);
        } catch (error) {
            if (error instanceof HttpError && error.validationErrors) {
                Object.entries(error.validationErrors).forEach(([field, messages]) => {
                    if (field in fieldLabels) {
                        setError(field as keyof EmployeeFormValues, {
                            message: messages[0] ?? `${fieldLabels[field as keyof EmployeeFormValues]} is invalid.`,
                            type: 'server',
                        });
                    }
                });

                notify({ description: getValidationSummary(error), intent: 'warning', title: 'Employee needs changes' });
                return;
            }

            notify({ description: getErrorMessage(error, 'The employee could not be saved.'), intent: 'error', title: 'Save failed' });
            setError('root', {
                message: getErrorMessage(error, 'The employee could not be saved.'),
                type: 'server',
            });
        }
    });

    const disabled = isPending || isSubmitting;

    return (
        <Modal
            description={employee ? 'Update employee profile details through the Employees API.' : 'Create a new employee through the Employees API.'}
            footer={
                <>
                    <Button disabled={disabled} onClick={() => onOpenChange(false)} variant="outline">
                        Cancel
                    </Button>
                    <Button loading={disabled} onClick={() => void submitForm()}>
                        {employee ? 'Save employee' : 'Create employee'}
                    </Button>
                </>
            }
            onOpenChange={onOpenChange}
            open={open}
            size="lg"
            title={employee ? 'Edit employee' : 'Create employee'}
        >
            <form className="grid gap-4" onSubmit={submitForm}>
                {errors.root?.message && (
                    <Alert description={errors.root.message} icon={<AlertCircle aria-hidden="true" className="size-5" />} intent="danger" title="Unable to save employee" />
                )}
                <div className="grid gap-4 md:grid-cols-2">
                    <Input error={errors.first_name?.message} label="First name" {...register('first_name')} />
                    <Input error={errors.last_name?.message} label="Last name" {...register('last_name')} />
                    <Input error={errors.email?.message} label="Email" type="email" {...register('email')} />
                    <Input error={errors.department?.message} label="Department" {...register('department')} />
                    <Input error={errors.user_id?.message} helperText="Optional existing user ID to link to this employee." label="User ID" inputMode="numeric" {...register('user_id')} />
                    <Switch description="Inactive employees remain visible but are marked as inactive." label="Active employee" {...register('active')} />
                </div>
                <button className="sr-only" disabled={disabled} type="submit">
                    Submit employee
                </button>
            </form>
        </Modal>
    );
}