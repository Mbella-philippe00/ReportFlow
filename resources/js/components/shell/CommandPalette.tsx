import { Search, X } from 'lucide-react';
import { useEffect, useId, useRef } from 'react';

import { useUiStore } from '@/stores/ui.store';

export function CommandPalette() {
    const open = useUiStore((state) => state.commandPaletteOpen);
    const setOpen = useUiStore((state) => state.setCommandPaletteOpen);
    const titleId = useId();
    const inputRef = useRef<HTMLInputElement>(null);

    useEffect(() => {
        if (!open) {
            return undefined;
        }

        inputRef.current?.focus();

        const closeOnEscape = (event: KeyboardEvent) => {
            if (event.key === 'Escape') {
                setOpen(false);
            }
        };

        document.addEventListener('keydown', closeOnEscape);

        return () => document.removeEventListener('keydown', closeOnEscape);
    }, [open, setOpen]);

    if (!open) {
        return null;
    }

    return (
        <div className="fixed inset-0 z-50 flex items-start justify-center bg-slate-950/50 px-4 py-20 backdrop-blur-sm" role="presentation">
            <section
                aria-labelledby={titleId}
                aria-modal="true"
                className="w-full max-w-2xl overflow-hidden rounded-2xl border bg-surface shadow-elevated"
                role="dialog"
            >
                <div className="flex items-center gap-3 border-b px-4 py-3">
                    <Search aria-hidden="true" className="size-5 text-muted-foreground" />
                    <input
                        aria-describedby={`${titleId}-description`}
                        aria-label="Command palette search"
                        className="min-w-0 flex-1 bg-transparent text-sm text-foreground outline-none placeholder:text-muted-foreground"
                        placeholder="Command search will be connected in a later phase"
                        readOnly
                        ref={inputRef}
                        type="search"
                    />
                    <button
                        aria-label="Close command palette"
                        className="inline-flex size-9 items-center justify-center rounded-xl text-muted-foreground transition hover:bg-muted hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                        onClick={() => setOpen(false)}
                        type="button"
                    >
                        <X aria-hidden="true" className="size-5" />
                    </button>
                </div>
                <div className="px-4 py-6">
                    <h2 className="text-sm font-semibold text-surface-foreground" id={titleId}>Command palette</h2>
                    <p className="mt-2 text-sm text-muted-foreground" id={`${titleId}-description`}>
                        Global actions and keyboard shortcuts will be registered here when product features are implemented.
                    </p>
                </div>
            </section>
        </div>
    );
}

