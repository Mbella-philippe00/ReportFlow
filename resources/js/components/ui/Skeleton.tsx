import { cva } from 'class-variance-authority';
import type { HTMLAttributes } from 'react';
import type { VariantProps } from 'class-variance-authority';

import { cn } from '@/utils/cn';

const skeletonVariants = cva('animate-pulse rounded-md bg-muted', {
    defaultVariants: {
        shape: 'rectangle',
    },
    variants: {
        shape: {
            circle: 'rounded-full',
            rectangle: 'rounded-md',
        },
    },
});

export type SkeletonProps = HTMLAttributes<HTMLDivElement> & VariantProps<typeof skeletonVariants>;

export function Skeleton({ className, shape, ...props }: SkeletonProps) {
    return <div aria-hidden="true" className={cn(skeletonVariants({ shape }), className)} {...props} />;
}
