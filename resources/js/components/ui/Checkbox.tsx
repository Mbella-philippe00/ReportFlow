import { forwardRef, useId } from 'react';
import type { InputHTMLAttributes } from 'react';

import { cn } from '@/utils/cn';

export type CheckboxProps = Omit<InputHTMLAttributes<HTMLInputElement>, 'type'> & {
    description?: string;
    error?: string;
    label?: string;
};

export const Checkbox = forwardRef<HTMLInputElement, CheckboxProps>(
    ({ className, description, error, id, label, ...props }, ref) => {
        const generatedId = useId();
        const checkboxId = id ?? generatedId;
        const descriptionId = `${checkboxId}-description`;
        const hasDescription = Boolean(error || description);

        return (
            <div className="grid gap-1.5">
                <label className="flex items-start gap-3 text-sm text-foreground" htmlFor={checkboxId}>
                    <input
                        aria-describedby={hasDescription ? descriptionId : undefined}
                        aria-invalid={Boolean(error)}
                        className={cn('mt-0.5 size-4 rounded border bg-surface text-primary accent-primary focus:ring-2 focus:ring-primary', className)}
                        id={checkboxId}
                        ref={ref}
                        type="checkbox"
                        {...props}
                    />
                    <span>
                        {label && <span className="block font-medium">{label}</span>}
                        {hasDescription && (
                            <span className={cn('block text-xs text-muted-foreground', error && 'text-danger')} id={descriptionId}>
                                {error ?? description}
                            </span>
                        )}
                    </span>
                </label>
            </div>
        );
    },
);

Checkbox.displayName = 'Checkbox';
