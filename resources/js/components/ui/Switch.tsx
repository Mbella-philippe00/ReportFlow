import { forwardRef, useId } from 'react';
import type { InputHTMLAttributes } from 'react';

import { cn } from '@/utils/cn';

export type SwitchProps = Omit<InputHTMLAttributes<HTMLInputElement>, 'type'> & {
    description?: string;
    label?: string;
};

export const Switch = forwardRef<HTMLInputElement, SwitchProps>(
    ({ className, description, id, label, ...props }, ref) => {
        const generatedId = useId();
        const switchId = id ?? generatedId;
        const descriptionId = `${switchId}-description`;

        return (
            <label className="relative flex items-center justify-between gap-4 rounded-xl border bg-surface p-3" htmlFor={switchId}>
                <span className="min-w-0">
                    {label && <span className="block text-sm font-medium text-foreground">{label}</span>}
                    {description && <span className="block text-xs text-muted-foreground" id={descriptionId}>{description}</span>}
                </span>
                <span className="relative inline-flex h-6 w-11 shrink-0 items-center">
                    <input
                        aria-describedby={description ? descriptionId : undefined}
                        className={cn('peer sr-only', className)}
                        id={switchId}
                        ref={ref}
                        role="switch"
                        type="checkbox"
                        {...props}
                    />
                    <span className="absolute inset-0 rounded-full bg-muted transition peer-checked:bg-primary peer-focus-visible:ring-2 peer-focus-visible:ring-primary peer-focus-visible:ring-offset-2 peer-focus-visible:ring-offset-background" />
                    <span className="absolute left-1 size-4 rounded-full bg-white shadow transition peer-checked:translate-x-5" />
                </span>
            </label>
        );
    },
);

Switch.displayName = 'Switch';
