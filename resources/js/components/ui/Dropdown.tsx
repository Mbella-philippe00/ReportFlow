import { ChevronDown } from 'lucide-react';
import { useEffect, useId, useRef, useState } from 'react';
import type { ReactNode } from 'react';

import { Button } from '@/components/ui/Button';
import { cn } from '@/utils/cn';

export type DropdownItem = {
    destructive?: boolean;
    disabled?: boolean;
    icon?: ReactNode;
    label: string;
    onSelect?: () => void;
};

export type DropdownProps = {
    align?: 'end' | 'start';
    items: readonly DropdownItem[];
    label?: string;
    trigger: ReactNode;
};

export function Dropdown({ align = 'end', items, label = 'Open menu', trigger }: DropdownProps) {
    const [open, setOpen] = useState(false);
    const menuId = useId();
    const itemRefs = useRef<Array<HTMLButtonElement | null>>([]);

    useEffect(() => {
        if (!open) {
            return undefined;
        }

        const closeOnEscape = (event: KeyboardEvent) => {
            if (event.key === 'Escape') {
                setOpen(false);
            }
        };

        document.addEventListener('keydown', closeOnEscape);

        return () => document.removeEventListener('keydown', closeOnEscape);
    }, [open]);

    const focusItem = (index: number) => {
        const enabledItems = itemRefs.current.filter((item): item is HTMLButtonElement => Boolean(item && !item.disabled));
        enabledItems[index]?.focus();
    };

    const handleMenuKeyDown = (event: React.KeyboardEvent<HTMLDivElement>) => {
        const currentIndex = itemRefs.current.findIndex((item) => item === document.activeElement);
        const enabledItems = itemRefs.current.filter((item): item is HTMLButtonElement => Boolean(item && !item.disabled));

        if (event.key === 'ArrowDown') {
            event.preventDefault();
            focusItem((currentIndex + 1) % enabledItems.length);
        }

        if (event.key === 'ArrowUp') {
            event.preventDefault();
            focusItem((currentIndex - 1 + enabledItems.length) % enabledItems.length);
        }
    };

    return (
        <div className="relative inline-block text-left">
            <Button
                aria-controls={open ? menuId : undefined}
                aria-expanded={open}
                aria-haspopup="menu"
                onClick={() => setOpen((current) => !current)}
                rightIcon={<ChevronDown aria-hidden="true" className="size-4" />}
                variant="outline"
            >
                {trigger}
            </Button>
            {open && (
                <div
                    className={cn(
                        'absolute z-30 mt-2 min-w-48 rounded-2xl border bg-surface p-1 shadow-elevated',
                        align === 'end' ? 'right-0' : 'left-0',
                    )}
                    id={menuId}
                    onKeyDown={handleMenuKeyDown}
                    role="menu"
                >
                    <span className="sr-only">{label}</span>
                    {items.map((item, index) => (
                        <button
                            className={cn(
                                'flex w-full items-center gap-2 rounded-xl px-3 py-2 text-left text-sm text-muted-foreground transition hover:bg-muted hover:text-foreground focus:bg-muted focus:text-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50',
                                item.destructive && 'text-danger hover:text-danger focus:text-danger',
                            )}
                            disabled={item.disabled}
                            key={item.label}
                            onClick={() => {
                                item.onSelect?.();
                                setOpen(false);
                            }}
                            ref={(element) => {
                                itemRefs.current[index] = element;
                            }}
                            role="menuitem"
                            type="button"
                        >
                            {item.icon}
                            {item.label}
                        </button>
                    ))}
                </div>
            )}
        </div>
    );
}
