import { Copy, Download, Edit, FileText, Printer, Send, Trash2 } from 'lucide-react';
import type { ReactNode } from 'react';

import { Button } from '@/components/ui';
import type { ReportCapabilities } from '@/features/reports/utils/report-utils';

export type ReportActionBarProps = {
    capabilities: ReportCapabilities;
    compact?: boolean;
    exportUrl?: string | null;
    onDelete?: () => void;
    onDuplicate?: () => void;
    onEdit?: () => void;
    onPrint?: () => void;
    onSubmit?: () => void;
    onView?: () => void;
    pendingAction?: 'delete' | 'duplicate' | 'submit' | null;
};

const iconClassName = 'size-4';

function ActionButton({ children, compact, ...props }: { children: ReactNode; compact?: boolean } & React.ComponentProps<typeof Button>) {
    return (
        <Button size={compact ? 'sm' : 'md'} {...props}>
            {children}
        </Button>
    );
}

export function ReportActionBar({
    capabilities,
    compact = false,
    exportUrl,
    onDelete,
    onDuplicate,
    onEdit,
    onPrint,
    onSubmit,
    onView,
    pendingAction = null,
}: ReportActionBarProps) {
    return (
        <div className="flex flex-wrap items-center gap-2">
            {onView && (
                <ActionButton compact={compact} leftIcon={<FileText aria-hidden="true" className={iconClassName} />} onClick={onView} variant="outline">
                    View
                </ActionButton>
            )}
            {capabilities.canEdit && onEdit && (
                <ActionButton compact={compact} leftIcon={<Edit aria-hidden="true" className={iconClassName} />} onClick={onEdit} variant="outline">
                    Edit
                </ActionButton>
            )}
            {capabilities.canSubmit && onSubmit && (
                <ActionButton
                    compact={compact}
                    leftIcon={<Send aria-hidden="true" className={iconClassName} />}
                    loading={pendingAction === 'submit'}
                    onClick={onSubmit}
                >
                    Submit
                </ActionButton>
            )}
            {capabilities.canDuplicate && onDuplicate && (
                <ActionButton
                    compact={compact}
                    leftIcon={<Copy aria-hidden="true" className={iconClassName} />}
                    loading={pendingAction === 'duplicate'}
                    onClick={onDuplicate}
                    variant="outline"
                >
                    Duplicate
                </ActionButton>
            )}
            {capabilities.canPrint && onPrint && (
                <ActionButton compact={compact} leftIcon={<Printer aria-hidden="true" className={iconClassName} />} onClick={onPrint} variant="outline">
                    Print
                </ActionButton>
            )}
            {capabilities.canExportPptx && exportUrl && (
                <a
                    className="inline-flex h-9 items-center justify-center gap-2 rounded-xl border bg-surface px-3 text-sm font-medium text-foreground transition hover:bg-muted focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-background"
                    href={exportUrl}
                    rel="noreferrer"
                    target="_blank"
                >
                    <Download aria-hidden="true" className={iconClassName} />
                    Export PPTX
                </a>
            )}
            {capabilities.canDelete && onDelete && (
                <ActionButton
                    compact={compact}
                    leftIcon={<Trash2 aria-hidden="true" className={iconClassName} />}
                    loading={pendingAction === 'delete'}
                    onClick={onDelete}
                    variant="danger"
                >
                    Delete
                </ActionButton>
            )}
        </div>
    );
}