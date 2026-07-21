import { cva } from 'class-variance-authority';
import type { VariantProps } from 'class-variance-authority';
import { forwardRef } from 'react';
import type { ButtonHTMLAttributes, ReactNode } from 'react';

import { Spinner } from '@/components/ui/Spinner';
import { cn } from '@/utils/cn';

export const buttonVariants = cva(
    'inline-flex items-center justify-center gap-2 rounded-2xl font-semibold tracking-[-0.01em] transition duration-200 ease-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-background disabled:pointer-events-none disabled:opacity-60',
    {
        defaultVariants: {
            size: 'md',
            variant: 'primary',
        },
        variants: {
            size: {
                sm: 'h-9 px-3 text-sm',
                md: 'h-11 px-4 text-sm',
                lg: 'h-12 px-5 text-base',
            },
            variant: {
                danger: 'bg-danger text-danger-foreground shadow-soft hover:-translate-y-0.5 hover:shadow-elevated',
                ghost: 'bg-transparent text-foreground hover:bg-muted/70',
                outline: 'border border-border/80 bg-surface/90 text-foreground shadow-soft hover:-translate-y-0.5 hover:border-primary/30 hover:bg-white hover:shadow-elevated dark:hover:bg-surface',
                primary: 'bg-primary text-primary-foreground shadow-[0_12px_28px_rgb(37_99_235_/_0.22)] hover:-translate-y-0.5 hover:bg-blue-600 hover:shadow-[0_18px_38px_rgb(37_99_235_/_0.28)]',
                secondary: 'bg-slate-900 text-white shadow-soft hover:-translate-y-0.5 hover:bg-slate-800 hover:shadow-elevated dark:bg-slate-100 dark:text-slate-950',
                subtle: 'bg-muted/70 text-foreground hover:bg-muted',
            },
        },
    },
);

export type ButtonProps = ButtonHTMLAttributes<HTMLButtonElement> &
    VariantProps<typeof buttonVariants> & {
        leftIcon?: ReactNode;
        loading?: boolean;
        rightIcon?: ReactNode;
    };

export const Button = forwardRef<HTMLButtonElement, ButtonProps>(
    ({ children, className, disabled, leftIcon, loading = false, rightIcon, size, type = 'button', variant, ...props }, ref) => (
        <button
            className={cn(buttonVariants({ size, variant }), className)}
            aria-busy={loading || undefined}
            disabled={disabled || loading}
            ref={ref}
            type={type}
            {...props}
        >
            {loading ? <Spinner size='sm' /> : leftIcon}
            <span>{children}</span>
            {rightIcon}
        </button>
    ),
);

Button.displayName = 'Button';
