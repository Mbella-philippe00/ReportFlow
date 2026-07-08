import { forwardRef, useId } from 'react';
import type { FieldsetHTMLAttributes, InputHTMLAttributes, PropsWithChildren } from 'react';

import { cn } from '@/utils/cn';

export type RadioProps = Omit<InputHTMLAttributes<HTMLInputElement>, 'type'> & {
    description?: string;
    label: string;
};

export const Radio = forwardRef<HTMLInputElement, RadioProps>(({ className, description, id, label, ...props }, ref) => {
    const generatedId = useId();
    const radioId = id ?? generatedId;
    const descriptionId = `${radioId}-description`;

    return (
        <label className="flex items-start gap-3 text-sm text-foreground" htmlFor={radioId}>
            <input
                aria-describedby={description ? descriptionId : undefined}
                className={cn('mt-0.5 size-4 border bg-surface text-primary accent-primary focus:ring-2 focus:ring-primary', className)}
                id={radioId}
                ref={ref}
                type="radio"
                {...props}
            />
            <span>
                <span className="block font-medium">{label}</span>
                {description && <span className="block text-xs text-muted-foreground" id={descriptionId}>{description}</span>}
            </span>
        </label>
    );
});

Radio.displayName = 'Radio';

export type RadioGroupProps = PropsWithChildren<FieldsetHTMLAttributes<HTMLFieldSetElement>> & {
    description?: string;
    label: string;
};

export function RadioGroup({ children, className, description, label, ...props }: RadioGroupProps) {
    return (
        <fieldset className={cn('grid gap-3', className)} {...props}>
            <legend className="text-sm font-medium text-foreground">{label}</legend>
            {description && <p className="text-xs text-muted-foreground">{description}</p>}
            <div className="grid gap-2">{children}</div>
        </fieldset>
    );
}
