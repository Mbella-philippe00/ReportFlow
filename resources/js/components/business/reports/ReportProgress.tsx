import { cn } from '@/utils/cn';

export type ReportProgressProps = {
    className?: string;
    label?: string;
    showValue?: boolean;
    value: number;
};

export function ReportProgress({ className, label = 'Report progress', showValue = true, value }: ReportProgressProps) {
    const normalizedValue = Math.min(100, Math.max(0, value));

    return (
        <div className={cn('grid gap-2', className)}>
            <div className="flex items-center justify-between gap-3 text-xs text-muted-foreground">
                <span>{label}</span>
                {showValue && <span>{normalizedValue}%</span>}
            </div>
            <div aria-label={label} aria-valuemax={100} aria-valuemin={0} aria-valuenow={normalizedValue} className="h-2 rounded-full bg-muted" role="progressbar">
                <div className="h-2 rounded-full bg-primary transition-all" style={{ width: `${normalizedValue}%` }} />
            </div>
        </div>
    );
}
