import { cva } from 'class-variance-authority';
import type { ImgHTMLAttributes } from 'react';
import { useMemo, useState } from 'react';
import type { VariantProps } from 'class-variance-authority';

import { cn } from '@/utils/cn';

const avatarVariants = cva('relative inline-flex shrink-0 items-center justify-center overflow-hidden rounded-full bg-muted font-semibold text-muted-foreground', {
    defaultVariants: {
        size: 'md',
    },
    variants: {
        size: {
            sm: 'size-8 text-xs',
            md: 'size-10 text-sm',
            lg: 'size-14 text-lg',
        },
    },
});

export type AvatarProps = Omit<ImgHTMLAttributes<HTMLImageElement>, 'children'> &
    VariantProps<typeof avatarVariants> & {
        fallback?: string;
    };

const getInitials = (value?: string): string => {
    if (!value) {
        return 'RF';
    }

    return value
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part.charAt(0).toUpperCase())
        .join('');
};

export function Avatar({ alt = '', className, fallback, size, src, ...props }: AvatarProps) {
    const [failed, setFailed] = useState(false);
    const initials = useMemo(() => getInitials(fallback || alt), [alt, fallback]);
    const showImage = Boolean(src && !failed);

    return (
        <span className={cn(avatarVariants({ size }), className)}>
            {showImage ? (
                <img alt={alt} className="size-full object-cover" onError={() => setFailed(true)} src={src} {...props} />
            ) : (
                <span aria-hidden={alt.length > 0}>{initials}</span>
            )}
        </span>
    );
}
