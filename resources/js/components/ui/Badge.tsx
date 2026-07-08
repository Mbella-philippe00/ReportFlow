import { cva } from 'class-variance-authority';
import type { HTMLAttributes } from 'react';
import type { VariantProps } from 'class-variance-authority';

import { cn } from '@/utils/cn';

const badgeVariants = cva('inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium', {
    defaultVariants: {
        intent: 'neutral',
    },
    variants: {
        intent: {
            danger: 'border-danger/30 bg-danger/10 text-danger',
            neutral: 'border-border bg-muted text-muted-foreground',
            primary: 'border-primary/30 bg-primary/10 text-primary',
            success: 'border-success/30 bg-success/10 text-success',
            warning: 'border-warning/30 bg-warning/10 text-warning',
        },
    },
});

export type BadgeProps = HTMLAttributes<HTMLSpanElement> & VariantProps<typeof badgeVariants>;

export function Badge({ className, intent, ...props }: BadgeProps) {
    return <span className={cn(badgeVariants({ intent }), className)} {...props} />;
}
