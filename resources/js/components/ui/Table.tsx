import type { HTMLAttributes, TableHTMLAttributes, TdHTMLAttributes, ThHTMLAttributes } from 'react';

import { cn } from '@/utils/cn';

export function Table({ className, ...props }: TableHTMLAttributes<HTMLTableElement>) {
    return (
        <div className="w-full overflow-x-auto rounded-3xl border border-border/70 bg-surface/95 shadow-soft">
            <table className={cn('w-full caption-bottom text-sm', className)} {...props} />
        </div>
    );
}

export function TableCaption({ className, ...props }: HTMLAttributes<HTMLTableCaptionElement>) {
    return <caption className={cn('mt-4 text-sm text-muted-foreground', className)} {...props} />;
}

export function TableHeader({ className, ...props }: HTMLAttributes<HTMLTableSectionElement>) {
    return <thead className={cn('border-b border-border/70 bg-slate-50/80 dark:bg-muted/50', className)} {...props} />;
}

export function TableBody({ className, ...props }: HTMLAttributes<HTMLTableSectionElement>) {
    return <tbody className={cn('divide-y', className)} {...props} />;
}

export function TableFooter({ className, ...props }: HTMLAttributes<HTMLTableSectionElement>) {
    return <tfoot className={cn('border-t bg-muted/60 font-medium', className)} {...props} />;
}

export function TableRow({ className, ...props }: HTMLAttributes<HTMLTableRowElement>) {
    return <tr className={cn('transition duration-150 hover:bg-blue-50/55 dark:hover:bg-muted/40', className)} {...props} />;
}

export function TableHead({ className, ...props }: ThHTMLAttributes<HTMLTableCellElement>) {
    return <th className={cn('h-12 px-5 text-left align-middle text-xs font-semibold uppercase tracking-[0.14em] text-muted-foreground', className)} {...props} />;
}

export function TableCell({ className, ...props }: TdHTMLAttributes<HTMLTableCellElement>) {
    return <td className={cn('px-5 py-4 align-middle text-foreground', className)} {...props} />;
}
