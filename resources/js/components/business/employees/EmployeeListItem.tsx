import type { ReactNode } from 'react';

import { Badge } from '@/components/ui';
import { EmployeeAvatar } from '@/components/business/employees/EmployeeAvatar';
import { cn } from '@/utils/cn';

export type EmployeeListItemProps = {
    actions?: ReactNode;
    avatarUrl?: string | null;
    className?: string;
    department?: ReactNode;
    email?: string | null;
    name: string;
    onSelect?: () => void;
    status?: 'active' | 'inactive';
};

export function EmployeeListItem({ actions, avatarUrl, className, department, email, name, onSelect, status }: EmployeeListItemProps) {
    const content = (
        <>
            <EmployeeAvatar avatarUrl={avatarUrl} email={email} name={name} />
            <span className="min-w-0 flex-1 text-left">
                <span className="block truncate text-sm font-medium text-foreground">{name}</span>
                <span className="block truncate text-xs text-muted-foreground">{email ?? department}</span>
            </span>
            {status && <Badge intent={status === 'active' ? 'success' : 'neutral'}>{status === 'active' ? 'Active' : 'Inactive'}</Badge>}
            {actions}
        </>
    );

    if (onSelect) {
        return (
            <button className={cn('flex w-full items-center gap-3 rounded-2xl border bg-surface p-3 transition hover:bg-muted/60 focus:outline-none focus:ring-2 focus:ring-primary', className)} onClick={onSelect} type="button">
                {content}
            </button>
        );
    }

    return <div className={cn('flex items-center gap-3 rounded-2xl border bg-surface p-3', className)}>{content}</div>;
}
