import { cva } from 'class-variance-authority';
import type { HTMLAttributes, PropsWithChildren } from 'react';

import { cn } from '@/utils/cn';

const cardVariants = cva('rounded-2xl border bg-surface text-surface-foreground', {
    defaultVariants: {
        elevation: 'sm',
    },
    variants: {
        elevation: {
            none: 'shadow-none',
            sm: 'shadow-soft',
            md: 'shadow-elevated',
        },
    },
});

export type CardProps = HTMLAttributes<HTMLDivElement> & {
    elevation?: 'md' | 'none' | 'sm';
};

export function Card({ className, elevation, ...props }: CardProps) {
    return <div className={cn(cardVariants({ elevation }), className)} {...props} />;
}

export function CardHeader({ className, ...props }: HTMLAttributes<HTMLDivElement>) {
    return <div className={cn('flex flex-col gap-1.5 p-5', className)} {...props} />;
}

export function CardTitle({ className, ...props }: HTMLAttributes<HTMLHeadingElement>) {
    return <h3 className={cn('text-lg font-semibold leading-tight tracking-tight', className)} {...props} />;
}

export function CardDescription({ className, ...props }: HTMLAttributes<HTMLParagraphElement>) {
    return <p className={cn('text-sm leading-relaxed text-muted-foreground', className)} {...props} />;
}

export function CardContent({ className, ...props }: PropsWithChildren<HTMLAttributes<HTMLDivElement>>) {
    return <div className={cn('p-5 pt-0', className)} {...props} />;
}

export function CardFooter({ className, ...props }: HTMLAttributes<HTMLDivElement>) {
    return <div className={cn('flex items-center gap-2 border-t p-5', className)} {...props} />;
}
