import { forwardRef } from 'react';
import type { ButtonHTMLAttributes, ReactNode } from 'react';
import type { VariantProps } from 'class-variance-authority';

import { buttonVariants } from '@/components/ui/Button';
import { Spinner } from '@/components/ui/Spinner';
import { cn } from '@/utils/cn';

type IconButtonSize = 'sm' | 'md' | 'lg';

const iconButtonSizes: Record<IconButtonSize, string> = {
    sm: 'size-9 px-0',
    md: 'size-10 px-0',
    lg: 'size-12 px-0',
};

export type IconButtonProps = Omit<ButtonHTMLAttributes<HTMLButtonElement>, 'children'> &
    Omit<VariantProps<typeof buttonVariants>, 'size'> & {
        'aria-label': string;
        icon: ReactNode;
        loading?: boolean;
        size?: IconButtonSize;
    };

export const IconButton = forwardRef<HTMLButtonElement, IconButtonProps>(
    ({ className, disabled, icon, loading = false, size = 'md', type = 'button', variant = 'ghost', ...props }, ref) => (
        <button
            className={cn(buttonVariants({ variant }), iconButtonSizes[size], className)}
            disabled={disabled || loading}
            ref={ref}
            type={type}
            {...props}
        >
            {loading ? <Spinner size="sm" /> : icon}
        </button>
    ),
);

IconButton.displayName = 'IconButton';
