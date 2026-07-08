import { appConfig } from '@/config/app';
import { cn } from '@/utils/cn';

type ApplicationLogoProps = {
    className?: string;
    compact?: boolean;
};

export function ApplicationLogo({ className, compact = false }: ApplicationLogoProps) {
    return (
        <div className={cn('flex items-center gap-3', className)} aria-label={`${appConfig.name} application`}>
            <div
                aria-hidden="true"
                className="flex size-10 shrink-0 items-center justify-center rounded-xl bg-primary text-sm font-bold text-primary-foreground shadow-soft"
            >
                RF
            </div>
            {!compact && (
                <div className="min-w-0">
                    <p className="truncate text-sm font-semibold text-foreground">{appConfig.name}</p>
                    <p className="truncate text-xs text-muted-foreground">Application workspace</p>
                </div>
            )}
        </div>
    );
}

