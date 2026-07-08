import { useId, useState } from 'react';
import type { ReactNode } from 'react';

import { cn } from '@/utils/cn';

export type TooltipProps = {
    children: ReactNode;
    className?: string;
    content: ReactNode;
};

export function Tooltip({ children, className, content }: TooltipProps) {
    const [open, setOpen] = useState(false);
    const tooltipId = useId();

    return (
        <span className="relative inline-flex" onBlur={() => setOpen(false)} onFocus={() => setOpen(true)} onMouseEnter={() => setOpen(true)} onMouseLeave={() => setOpen(false)}>
            <span aria-describedby={open ? tooltipId : undefined}>{children}</span>
            {open && (
                <span
                    className={cn('absolute bottom-full left-1/2 z-30 mb-2 -translate-x-1/2 whitespace-nowrap rounded-lg bg-foreground px-2 py-1 text-xs text-background shadow-soft', className)}
                    id={tooltipId}
                    role="tooltip"
                >
                    {content}
                </span>
            )}
        </span>
    );
}
