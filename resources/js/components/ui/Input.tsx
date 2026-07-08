import { forwardRef, useId } from 'react';
import type { InputHTMLAttributes, ReactNode } from 'react';

import { cn } from '@/utils/cn';

export type InputProps = Omit<InputHTMLAttributes<HTMLInputElement>, 'size'> & {
    error?: string;
    helperText?: string;
    label?: string;
    leftIcon?: ReactNode;
    rightIcon?: ReactNode;
};

export const Input = forwardRef<HTMLInputElement, InputProps>(
    ({ className, error, helperText, id, label, leftIcon, rightIcon, type = 'text', ...props }, ref) => {
        const generatedId = useId();
        const inputId = id ?? generatedId;
        const descriptionId = `${inputId}-description`;
        const hasDescription = Boolean(error || helperText);

        return (
            <div className="grid gap-2">
                {label && (
                    <label className="text-sm font-medium text-foreground" htmlFor={inputId}>
                        {label}
                    </label>
                )}
                <div className="relative">
                    {leftIcon && <span className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground">{leftIcon}</span>}
                    <input
                        aria-describedby={hasDescription ? descriptionId : undefined}
                        aria-invalid={Boolean(error)}
                        className={cn(
                            'h-10 w-full rounded-xl border bg-surface px-3 text-sm text-foreground outline-none transition placeholder:text-muted-foreground focus:ring-2 focus:ring-primary disabled:cursor-not-allowed disabled:opacity-60',
                            leftIcon && 'pl-10',
                            rightIcon && 'pr-10',
                            error && 'border-danger focus:ring-danger',
                            className,
                        )}
                        id={inputId}
                        ref={ref}
                        type={type}
                        {...props}
                    />
                    {rightIcon && <span className="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground">{rightIcon}</span>}
                </div>
                {hasDescription && (
                    <p className={cn('text-xs text-muted-foreground', error && 'text-danger')} id={descriptionId}>
                        {error ?? helperText}
                    </p>
                )}
            </div>
        );
    },
);

Input.displayName = 'Input';
