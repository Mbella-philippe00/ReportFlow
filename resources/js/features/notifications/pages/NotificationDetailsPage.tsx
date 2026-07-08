import { AlertCircle, Bell, ChevronLeft } from 'lucide-react';
import { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

import { PageContainer } from '@/components/layout/PageContainer';
import { Alert, Button, EmptyState, Skeleton } from '@/components/ui';
import { appConfig } from '@/config/app';
import { useToast } from '@/providers/ToastProvider';
import type { AppNotification } from '@/types';

import { NotificationDetailPanel } from '../components/NotificationDetailPanel';
import {
    useArchiveNotificationMutation,
    useDeleteNotificationMutation,
    useMarkNotificationReadMutation,
    useNotificationQuery,
    useRestoreNotificationMutation,
} from '../hooks/useNotifications';

const getErrorMessage = (error: unknown) => (error instanceof Error ? error.message : 'Notification details could not be loaded.');

function NotificationDetailsSkeleton() {
    return (
        <PageContainer description="Loading notification details from the Notifications API." eyebrow="Notifications" title="Notification details">
            <Skeleton className="h-44" />
            <Skeleton className="h-40" />
            <Skeleton className="h-52" />
        </PageContainer>
    );
}

export function NotificationDetailsPage() {
    const { id } = useParams();
    const navigate = useNavigate();
    const { notify } = useToast();
    const [pendingAction, setPendingAction] = useState<'archive' | 'delete' | 'read' | 'restore' | null>(null);
    const notificationQuery = useNotificationQuery(id);
    const markAsRead = useMarkNotificationReadMutation();
    const archive = useArchiveNotificationMutation();
    const restore = useRestoreNotificationMutation();
    const deleteMutation = useDeleteNotificationMutation();

    useEffect(() => {
        document.title = `Notification details - ${appConfig.name}`;
    }, []);

    const runAction = async (notification: AppNotification, action: 'archive' | 'delete' | 'read' | 'restore') => {
        setPendingAction(action);

        try {
            if (action === 'read') {
                await markAsRead.mutateAsync(notification.id);
                notify({ intent: 'success', title: 'Notification marked as read' });
            }
            if (action === 'archive') {
                await archive.mutateAsync(notification.id);
                notify({ intent: 'success', title: 'Notification archived' });
            }
            if (action === 'restore') {
                await restore.mutateAsync(notification.id);
                notify({ intent: 'success', title: 'Notification restored' });
            }
            if (action === 'delete') {
                await deleteMutation.mutateAsync(notification.id);
                notify({ intent: 'success', title: 'Notification deleted' });
                navigate('/notifications');
            }
        } catch (error) {
            notify({ description: getErrorMessage(error), intent: 'error', title: 'Notification action failed' });
        } finally {
            setPendingAction(null);
        }
    };

    if (!id) {
        return (
            <PageContainer description="The requested notification identifier is invalid." eyebrow="Notifications" title="Notification not found">
                <EmptyState action={{ label: 'Back to notifications', onClick: () => navigate('/notifications') }} icon={<Bell aria-hidden="true" className="size-10" />} title="Invalid notification" description="Open a notification from the notification center." />
            </PageContainer>
        );
    }

    if (notificationQuery.isLoading) {
        return <NotificationDetailsSkeleton />;
    }

    if (notificationQuery.isError) {
        return (
            <PageContainer description="The Notifications API returned an error." eyebrow="Notifications" title="Notification details">
                <Alert description={getErrorMessage(notificationQuery.error)} icon={<AlertCircle aria-hidden="true" className="size-5" />} intent="danger" title="Unable to load notification" />
            </PageContainer>
        );
    }

    const notification = notificationQuery.data?.data;

    if (!notification) {
        return (
            <PageContainer description="No notification was returned by the Notifications API." eyebrow="Notifications" title="Notification not found">
                <EmptyState action={{ label: 'Back to notifications', onClick: () => navigate('/notifications') }} icon={<Bell aria-hidden="true" className="size-10" />} title="Notification not found" description="The notification may have been deleted or is no longer available." />
            </PageContainer>
        );
    }

    return (
        <PageContainer
            actions={
                <Button leftIcon={<ChevronLeft aria-hidden="true" className="size-4" />} onClick={() => navigate('/notifications')} variant="outline">
                    Back to center
                </Button>
            }
            description="Inspect the complete backend notification payload and allowed actions."
            eyebrow="Notifications"
            title={notification.title}
        >
            <NotificationDetailPanel
                isPending={Boolean(pendingAction)}
                notification={notification}
                onArchive={(value) => void runAction(value, 'archive')}
                onDelete={(value) => void runAction(value, 'delete')}
                onMarkAsRead={(value) => void runAction(value, 'read')}
                onRestore={(value) => void runAction(value, 'restore')}
            />
        </PageContainer>
    );
}
