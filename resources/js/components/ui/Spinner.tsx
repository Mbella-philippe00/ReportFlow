import { cva } from 'class-variance-authority';
import type { VariantProps } from 'class-variance-authority';

import { cn } from '@/utils/cn';

const spinnerVariants = cva('inline-block animate-spin rounded-full border-current border-r-transparent align-[-0.125em]', {
    defaultVariants: {
        size: 'md',
    },
    variants: {
        size: {
            sm: 'size-4 border-2',
            md: 'size-5 border-2',
            lg: 'size-8 border-[3px]',
        },
    },
});

export type SpinnerProps = VariantProps<typeof spinnerVariants> & {
    className?: string;
    label?: string;
};

export function Spinner({ className, label = 'Loading', size }: SpinnerProps) {
    return (
        <span aria-label={label} className={cn(spinnerVariants({ size }), className)} role="status">
            <span className="sr-only">{label}</span>
        </span>
    );
}
