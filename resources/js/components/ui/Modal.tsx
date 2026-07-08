import { X } from 'lucide-react';
import { useEffect, useId, useRef } from 'react';
import type { ReactNode } from 'react';
import { cva } from 'class-variance-authority';
import type { VariantProps } from 'class-variance-authority';

import { IconButton } from '@/components/ui/IconButton';
import { cn } from '@/utils/cn';

const modalVariants = cva('w-full rounded-2xl border bg-surface text-surface-foreground shadow-elevated outline-none', {
    defaultVariants: {
        size: 'md',
    },
    variants: {
        size: {
            sm: 'max-w-md',
            md: 'max-w-lg',
            lg: 'max-w-2xl',
            xl: 'max-w-4xl',
        },
    },
});

export type ModalProps = VariantProps<typeof modalVariants> & {
    children: ReactNode;
    closeOnEscape?: boolean;
    closeOnOverlayClick?: boolean;
    description?: string;
    footer?: ReactNode;
    onOpenChange: (open: boolean) => void;
    open: boolean;
    title: string;
};

export function Modal({
    children,
    closeOnEscape = true,
    closeOnOverlayClick = true,
    description,
    footer,
    onOpenChange,
    open,
    size,
    title,
}: ModalProps) {
    const titleId = useId();
    const descriptionId = useId();
    const panelRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        if (!open) {
            return undefined;
        }

        panelRef.current?.focus();

        const closeOnKeydown = (event: KeyboardEvent) => {
            if (closeOnEscape && event.key === 'Escape') {
                onOpenChange(false);
            }
        };

        document.addEventListener('keydown', closeOnKeydown);

        return () => document.removeEventListener('keydown', closeOnKeydown);
    }, [closeOnEscape, onOpenChange, open]);

    if (!open) {
        return null;
    }

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm" role="presentation">
            <button
                aria-label="Close modal overlay"
                className="absolute inset-0 cursor-default"
                onClick={() => closeOnOverlayClick && onOpenChange(false)}
                type="button"
            />
            <section
                aria-describedby={description ? descriptionId : undefined}
                aria-labelledby={titleId}
                aria-modal="true"
                className={cn(modalVariants({ size }), 'relative')}
                ref={panelRef}
                role="dialog"
                tabIndex={-1}
            >
                <header className="flex items-start justify-between gap-4 border-b p-5">
                    <div>
                        <h2 className="text-lg font-semibold tracking-tight" id={titleId}>{title}</h2>
                        {description && <p className="mt-1 text-sm text-muted-foreground" id={descriptionId}>{description}</p>}
                    </div>
                    <IconButton aria-label="Close modal" icon={<X aria-hidden="true" className="size-5" />} onClick={() => onOpenChange(false)} />
                </header>
                <div className="p-5">{children}</div>
                {footer && <footer className="flex items-center justify-end gap-2 border-t p-5">{footer}</footer>}
            </section>
        </div>
    );
}
