import { cva } from 'class-variance-authority';
import type { HTMLAttributes } from 'react';
import type { VariantProps } from 'class-variance-authority';

import { cn } from '@/utils/cn';

const badgeVariants = cva('inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-semibold tracking-[-0.01em] shadow-[inset_0_1px_0_rgb(255_255_255_/_0.45)]', {
    defaultVariants: {
        intent: 'neutral',
    },
    variants: {
        intent: {
            danger: 'border-danger/20 bg-danger/10 text-danger',
            neutral: 'border-slate-200 bg-slate-100 text-slate-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300',
            primary: 'border-primary/20 bg-primary/10 text-primary',
            success: 'border-success/20 bg-success/10 text-success',
            warning: 'border-warning/25 bg-warning/10 text-warning',
        },
    },
});

export type BadgeProps = HTMLAttributes<HTMLSpanElement> & VariantProps<typeof badgeVariants>;

export function Badge({ className, intent, ...props }: BadgeProps) {
    return <span className={cn(badgeVariants({ intent }), className)} {...props} />;
}
