import { cva } from 'class-variance-authority';
import type { HTMLAttributes, PropsWithChildren } from 'react';

import { cn } from '@/utils/cn';

const cardVariants = cva('rounded-3xl border border-border/70 bg-surface/95 text-surface-foreground backdrop-blur-sm transition duration-200', {
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
    return <div className={cn('flex flex-col gap-2 p-6', className)} {...props} />;
}

export function CardTitle({ className, ...props }: HTMLAttributes<HTMLHeadingElement>) {
    return <h3 className={cn('font-display text-lg font-semibold leading-tight tracking-tight text-surface-foreground', className)} {...props} />;
}

export function CardDescription({ className, ...props }: HTMLAttributes<HTMLParagraphElement>) {
    return <p className={cn('text-sm leading-relaxed text-muted-foreground', className)} {...props} />;
}

export function CardContent({ className, ...props }: PropsWithChildren<HTMLAttributes<HTMLDivElement>>) {
    return <div className={cn('p-6 pt-0', className)} {...props} />;
}

export function CardFooter({ className, ...props }: HTMLAttributes<HTMLDivElement>) {
    return <div className={cn('flex items-center gap-2 border-t border-border/70 p-6', className)} {...props} />;
}
