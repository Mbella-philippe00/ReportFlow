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
                    <label className="text-sm font-semibold text-foreground" htmlFor={inputId}>
                        {label}
                    </label>
                )}
                <div className="relative">
                    {leftIcon && <span className="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-muted-foreground">{leftIcon}</span>}
                    <input
                        aria-describedby={hasDescription ? descriptionId : undefined}
                        aria-invalid={Boolean(error)}
                        className={cn(
                            'h-11 w-full rounded-2xl border border-border/80 bg-surface/95 px-3.5 text-sm text-foreground shadow-soft outline-none transition duration-200 placeholder:text-muted-foreground focus:border-primary/40 focus:bg-white focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:opacity-60 dark:focus:bg-surface',
                            leftIcon && 'pl-11',
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
