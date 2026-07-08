import { appConfig } from '@/config/app';
import { cn } from '@/utils/cn';

type FooterProps = {
    className?: string;
};

export function Footer({ className }: FooterProps) {
    return (
        <footer className={cn('border-t bg-surface px-4 py-4 text-xs text-muted-foreground sm:px-6 lg:px-8', className)}>
            <div className="mx-auto flex w-full max-w-7xl flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <p>{appConfig.name} application shell</p>
                <p>Reusable layout foundation</p>
            </div>
        </footer>
    );
}

