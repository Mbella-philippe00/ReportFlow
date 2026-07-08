import { cva } from 'class-variance-authority';
import type { VariantProps } from 'class-variance-authority';
import { forwardRef } from 'react';
import type { ButtonHTMLAttributes, ReactNode } from 'react';

import { Spinner } from '@/components/ui/Spinner';
import { cn } from '@/utils/cn';

export const buttonVariants = cva(
    'inline-flex items-center justify-center gap-2 rounded-xl font-medium transition focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-background disabled:pointer-events-none disabled:opacity-60',
    {
        defaultVariants: {
            size: 'md',
            variant: 'primary',
        },
        variants: {
            size: {
                sm: 'h-9 px-3 text-sm',
                md: 'h-10 px-4 text-sm',
                lg: 'h-12 px-5 text-base',
            },
            variant: {
                danger: 'bg-danger text-danger-foreground shadow-soft hover:opacity-90',
                ghost: 'bg-transparent text-foreground hover:bg-muted',
                outline: 'border bg-surface text-foreground hover:bg-muted',
                primary: 'bg-primary text-primary-foreground shadow-soft hover:opacity-90',
                secondary: 'bg-secondary text-secondary-foreground shadow-soft hover:opacity-90',
                subtle: 'bg-muted text-foreground hover:bg-muted/80',
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
            disabled={disabled || loading}
            ref={ref}
            type={type}
            {...props}
        >
            {loading ? <Spinner size="sm" /> : leftIcon}
            <span>{children}</span>
            {rightIcon}
        </button>
    ),
);

Button.displayName = 'Button';
