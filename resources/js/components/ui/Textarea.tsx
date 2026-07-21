import { forwardRef, useId } from 'react';
import type { TextareaHTMLAttributes } from 'react';

import { cn } from '@/utils/cn';

export type TextareaProps = TextareaHTMLAttributes<HTMLTextAreaElement> & {
    error?: string;
    helperText?: string;
    label?: string;
};

export const Textarea = forwardRef<HTMLTextAreaElement, TextareaProps>(
    ({ className, error, helperText, id, label, ...props }, ref) => {
        const generatedId = useId();
        const textareaId = id ?? generatedId;
        const descriptionId = `${textareaId}-description`;
        const hasDescription = Boolean(error || helperText);

        return (
            <div className="grid gap-2">
                {label && (
                    <label className="text-sm font-semibold text-foreground" htmlFor={textareaId}>
                        {label}
                    </label>
                )}
                <textarea
                    aria-describedby={hasDescription ? descriptionId : undefined}
                    aria-invalid={Boolean(error)}
                    className={cn(
                        'min-h-32 w-full resize-y rounded-2xl border border-border/80 bg-surface/95 px-3.5 py-3 text-sm text-foreground shadow-soft outline-none transition duration-200 placeholder:text-muted-foreground focus:border-primary/40 focus:bg-white focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:opacity-60 dark:focus:bg-surface',
                        error && 'border-danger focus:ring-danger',
                        className,
                    )}
                    id={textareaId}
                    ref={ref}
                    {...props}
                />
                {hasDescription && (
                    <p className={cn('text-xs text-muted-foreground', error && 'text-danger')} id={descriptionId}>
                        {error ?? helperText}
                    </p>
                )}
            </div>
        );
    },
);

Textarea.displayName = 'Textarea';
