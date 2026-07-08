import type { ReactNode } from 'react';

import { Dialog } from '@/components/ui';

export type ConfirmDeleteDialogProps = {
    cancelLabel?: string;
    children?: ReactNode;
    confirmLabel?: string;
    description?: string;
    onConfirm: () => void;
    onOpenChange: (open: boolean) => void;
    open: boolean;
    resourceName?: string;
    title?: string;
};

export function ConfirmDeleteDialog({
    cancelLabel = 'Cancel',
    children,
    confirmLabel = 'Delete',
    description,
    onConfirm,
    onOpenChange,
    open,
    resourceName = 'this item',
    title = 'Confirm deletion',
}: ConfirmDeleteDialogProps) {
    return (
        <Dialog
            cancelLabel={cancelLabel}
            confirmLabel={confirmLabel}
            description={description ?? `This action will permanently delete ${resourceName}.`}
            intent="danger"
            onConfirm={onConfirm}
            onOpenChange={onOpenChange}
            open={open}
            title={title}
        >
            {children}
        </Dialog>
    );
}
