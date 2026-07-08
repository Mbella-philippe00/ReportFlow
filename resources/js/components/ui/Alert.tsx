import { cva } from 'class-variance-authority';
import type { HTMLAttributes, ReactNode } from 'react';
import type { VariantProps } from 'class-variance-authority';

import { cn } from '@/utils/cn';

const alertVariants = cva('rounded-2xl border p-4 text-sm', {
    defaultVariants: {
        intent: 'info',
    },
    variants: {
        intent: {
            danger: 'border-danger/30 bg-danger/10 text-danger',
            info: 'border-primary/30 bg-primary/10 text-primary',
            success: 'border-success/30 bg-success/10 text-success',
            warning: 'border-warning/30 bg-warning/10 text-warning',
        },
    },
});

export type AlertProps = HTMLAttributes<HTMLDivElement> &
    VariantProps<typeof alertVariants> & {
        description?: ReactNode;
        icon?: ReactNode;
        title?: ReactNode;
    };

export function Alert({ className, description, icon, intent, title, ...props }: AlertProps) {
    return (
        <div className={cn(alertVariants({ intent }), className)} role={intent === 'danger' ? 'alert' : 'status'} {...props}>
            <div className="flex gap-3">
                {icon && <span className="mt-0.5 shrink-0">{icon}</span>}
                <div className="min-w-0">
                    {title && <p className="font-semibold">{title}</p>}
                    {description && <div className="mt-1 leading-relaxed opacity-90">{description}</div>}
                </div>
            </div>
        </div>
    );
}
