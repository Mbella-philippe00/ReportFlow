import logoUrl from '../../../branding/reportflow-logo.png';
import markUrl from '../../../branding/reportflow-logo-mark.png';
import reverseLogoUrl from '../../../branding/reportflow-logo-reverse.png';

import { appConfig } from '@/config/app';
import { cn } from '@/utils/cn';

type ApplicationLogoProps = {
    className?: string;
    compact?: boolean;
    reverse?: boolean;
    showTagline?: boolean;
};

export function ApplicationLogo({ className, compact = false, reverse = false, showTagline = true }: ApplicationLogoProps) {
    const source = compact ? markUrl : reverse ? reverseLogoUrl : logoUrl;

    return (
        <div className={cn('flex min-w-0 items-center gap-3', className)} aria-label={appConfig.name + ' application'}>
            <img
                alt={compact ? appConfig.name + ' logo mark' : appConfig.name + ' logo'}
                className={cn(
                    'block shrink-0 select-none object-contain',
                    compact ? 'size-11 rounded-2xl' : reverse ? 'h-12 w-auto rounded-2xl shadow-soft' : 'h-12 w-auto',
                )}
                draggable={false}
                src={source}
            />
            {!compact && showTagline && !reverse && (
                <span className='sr-only'>Transform Weekly Reports Into Decisions</span>
            )}
        </div>
    );
}
