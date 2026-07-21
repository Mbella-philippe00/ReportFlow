import { cn } from '@/utils/cn';

export type GlobalLoadingBarProps = {
    active: boolean;
    label?: string;
};

export function GlobalLoadingBar({ active, label = 'Loading latest data' }: GlobalLoadingBarProps) {
    return (
        <>
            <div
                aria-hidden={!active}
                className={cn(
                    'fixed inset-x-0 top-0 z-[70] h-1 overflow-hidden bg-transparent transition-opacity duration-200',
                    active ? 'opacity-100' : 'pointer-events-none opacity-0',
                )}
            >
                <div className="h-full w-1/3 animate-[pulse_1.4s_ease-in-out_infinite] rounded-r-full bg-primary shadow-[0_0_18px_var(--color-primary)]" />
            </div>
            <span className="sr-only" role="status" aria-live="polite">
                {active ? label : ''}
            </span>
        </>
    );
}
