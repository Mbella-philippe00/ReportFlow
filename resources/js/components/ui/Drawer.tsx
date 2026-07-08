import { X } from 'lucide-react';
import { useEffect, useId, useRef } from 'react';
import type { ReactNode } from 'react';
import { cva } from 'class-variance-authority';
import type { VariantProps } from 'class-variance-authority';

import { IconButton } from '@/components/ui/IconButton';
import { cn } from '@/utils/cn';

const drawerVariants = cva('fixed z-50 flex bg-surface text-surface-foreground shadow-elevated outline-none', {
    defaultVariants: {
        side: 'right',
    },
    variants: {
        side: {
            bottom: 'inset-x-0 bottom-0 max-h-[85vh] flex-col rounded-t-2xl border-t',
            left: 'inset-y-0 left-0 w-80 max-w-[90vw] flex-col border-r',
            right: 'inset-y-0 right-0 w-80 max-w-[90vw] flex-col border-l',
            top: 'inset-x-0 top-0 max-h-[85vh] flex-col rounded-b-2xl border-b',
        },
    },
});

export type DrawerProps = VariantProps<typeof drawerVariants> & {
    children: ReactNode;
    description?: string;
    footer?: ReactNode;
    onOpenChange: (open: boolean) => void;
    open: boolean;
    title: string;
};

export function Drawer({ children, description, footer, onOpenChange, open, side, title }: DrawerProps) {
    const titleId = useId();
    const descriptionId = useId();
    const panelRef = useRef<HTMLElement>(null);

    useEffect(() => {
        if (!open) {
            return undefined;
        }

        panelRef.current?.focus();

        const closeOnEscape = (event: KeyboardEvent) => {
            if (event.key === 'Escape') {
                onOpenChange(false);
            }
        };

        document.addEventListener('keydown', closeOnEscape);

        return () => document.removeEventListener('keydown', closeOnEscape);
    }, [onOpenChange, open]);

    if (!open) {
        return null;
    }

    return (
        <div className="fixed inset-0 z-50 bg-slate-950/50 backdrop-blur-sm" role="presentation">
            <button aria-label="Close drawer overlay" className="absolute inset-0 cursor-default" onClick={() => onOpenChange(false)} type="button" />
            <aside
                aria-describedby={description ? descriptionId : undefined}
                aria-labelledby={titleId}
                aria-modal="true"
                className={cn(drawerVariants({ side }))}
                ref={panelRef}
                role="dialog"
                tabIndex={-1}
            >
                <header className="flex items-start justify-between gap-4 border-b p-5">
                    <div>
                        <h2 className="text-lg font-semibold tracking-tight" id={titleId}>{title}</h2>
                        {description && <p className="mt-1 text-sm text-muted-foreground" id={descriptionId}>{description}</p>}
                    </div>
                    <IconButton aria-label="Close drawer" icon={<X aria-hidden="true" className="size-5" />} onClick={() => onOpenChange(false)} />
                </header>
                <div className="flex-1 overflow-auto p-5">{children}</div>
                {footer && <footer className="border-t p-5">{footer}</footer>}
            </aside>
        </div>
    );
}
