import { forwardRef, useId } from 'react';
import type { SelectHTMLAttributes } from 'react';

import { cn } from '@/utils/cn';

export type SelectOption = {
    disabled?: boolean;
    label: string;
    value: string;
};

export type SelectProps = SelectHTMLAttributes<HTMLSelectElement> & {
    error?: string;
    helperText?: string;
    label?: string;
    options?: readonly SelectOption[];
    placeholder?: string;
};

export const Select = forwardRef<HTMLSelectElement, SelectProps>(
    ({ children, className, error, helperText, id, label, options, placeholder, ...props }, ref) => {
        const generatedId = useId();
        const selectId = id ?? generatedId;
        const descriptionId = `${selectId}-description`;
        const hasDescription = Boolean(error || helperText);

        return (
            <div className="grid gap-2">
                {label && (
                    <label className="text-sm font-medium text-foreground" htmlFor={selectId}>
                        {label}
                    </label>
                )}
                <select
                    aria-describedby={hasDescription ? descriptionId : undefined}
                    aria-invalid={Boolean(error)}
                    className={cn(
                        'h-10 w-full rounded-xl border bg-surface px-3 text-sm text-foreground outline-none transition focus:ring-2 focus:ring-primary disabled:cursor-not-allowed disabled:opacity-60',
                        error && 'border-danger focus:ring-danger',
                        className,
                    )}
                    id={selectId}
                    ref={ref}
                    {...props}
                >
                    {placeholder && <option value="">{placeholder}</option>}
                    {options?.map((option) => (
                        <option disabled={option.disabled} key={option.value} value={option.value}>
                            {option.label}
                        </option>
                    ))}
                    {children}
                </select>
                {hasDescription && (
                    <p className={cn('text-xs text-muted-foreground', error && 'text-danger')} id={descriptionId}>
                        {error ?? helperText}
                    </p>
                )}
            </div>
        );
    },
);

Select.displayName = 'Select';
