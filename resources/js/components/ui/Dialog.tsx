import type { ReactNode } from 'react';

import { Button } from '@/components/ui/Button';
import { Modal } from '@/components/ui/Modal';

export type DialogProps = {
    cancelLabel?: string;
    children?: ReactNode;
    confirmLabel?: string;
    description?: string;
    intent?: 'danger' | 'primary';
    onCancel?: () => void;
    onConfirm?: () => void;
    onOpenChange: (open: boolean) => void;
    open: boolean;
    title: string;
};

export function Dialog({
    cancelLabel = 'Cancel',
    children,
    confirmLabel = 'Confirm',
    description,
    intent = 'primary',
    onCancel,
    onConfirm,
    onOpenChange,
    open,
    title,
}: DialogProps) {
    const closeDialog = () => {
        onCancel?.();
        onOpenChange(false);
    };

    const confirmDialog = () => {
        onConfirm?.();
        onOpenChange(false);
    };

    return (
        <Modal
            description={description}
            footer={
                <>
                    <Button onClick={closeDialog} variant="outline">{cancelLabel}</Button>
                    <Button onClick={confirmDialog} variant={intent === 'danger' ? 'danger' : 'primary'}>{confirmLabel}</Button>
                </>
            }
            onOpenChange={onOpenChange}
            open={open}
            size="sm"
            title={title}
        >
            {children}
        </Modal>
    );
}
