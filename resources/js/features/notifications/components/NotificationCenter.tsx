import { AlertCircle, Bell, CheckCheck, RefreshCw } from 'lucide-react';
import { useMemo, useState } from 'react';
import { useSearchParams } from 'react-router-dom';

import { SectionHeader } from '@/components/business/common';
import { Alert, Button, Card, CardContent, EmptyState, Pagination, Skeleton } from '@/components/ui';
import { useToast } from '@/providers/ToastProvider';
import type { AppNotification, NotificationSortValue, NotificationStatusFilter, NotificationType } from '@/types';

import {
    useArchiveNotificationMutation,
    useDeleteNotificationMutation,
    useMarkAllNotificationsReadMutation,
    useMarkNotificationReadMutation,
    useNotificationsQuery,
    useRestoreNotificationMutation,
} from '../hooks/useNotifications';
import { groupNotificationsByDate, normalizeNotificationSort, normalizeNotificationStatus, normalizeNotificationType } from '../utils/notification-utils';
import { NotificationCard } from './NotificationCard';
import { NotificationFilters } from './NotificationFilters';

const getErrorMessage = (error: unknown) => (error instanceof Error ? error.message : 'Notifications could not be loaded.');

function NotificationCenterSkeleton() {
    return (
        <Card>
            <CardContent className="grid gap-3 p-5">
                {Array.from({ length: 5 }, (_, index) => (
                    <Skeleton className="h-24" key={index} />
                ))}
            </CardContent>
        </Card>
    );
}

export function NotificationCenter() {
    const { notify } = useToast();
    const [searchParams, setSearchParams] = useSearchParams();
    const page = Math.max(1, Number(searchParams.get('page') ?? '1'));
    const [search, setSearch] = useState(searchParams.get('search') ?? '');
    const [status, setStatus] = useState<NotificationStatusFilter>(normalizeNotificationStatus(searchParams.get('status') ?? 'all'));
    const [type, setType] = useState<'' | NotificationType>(normalizeNotificationType(searchParams.get('type') ?? ''));
    const [sort, setSort] = useState<NotificationSortValue>(normalizeNotificationSort(searchParams.get('sort') ?? '-created_at'));
    const [pendingAction, setPendingAction] = useState<{ action: 'archive' | 'delete' | 'read' | 'restore'; id: string } | null>(null);

    const notificationsQuery = useNotificationsQuery({ page, per_page: 15, search, sort, status, type });
    const markAsRead = useMarkNotificationReadMutation();
    const markAllAsRead = useMarkAllNotificationsReadMutation();
    const archive = useArchiveNotificationMutation();
    const restore = useRestoreNotificationMutation();
    const deleteMutation = useDeleteNotificationMutation();
    const notifications = notificationsQuery.data?.data ?? [];
    const meta = notificationsQuery.data?.meta;
    const groups = useMemo(() => groupNotificationsByDate(notifications), [notifications]);

    const syncParams = (updates: Partial<{ page: number; search: string; sort: NotificationSortValue; status: NotificationStatusFilter; type: '' | NotificationType }>) => {
        const next = {
            page,
            search,
            sort,
            status,
            type,
            ...updates,
        };
        const params = new URLSearchParams();

        if (next.page > 1) {
            params.set('page', String(next.page));
        }
        if (next.search.trim()) {
            params.set('search', next.search.trim());
        }
        if (next.status !== 'all') {
            params.set('status', next.status);
        }
        if (next.type) {
            params.set('type', next.type);
        }
        if (next.sort !== '-created_at') {
            params.set('sort', next.sort);
        }

        setSearchParams(params);
    };

    const resetFilters = () => {
        setSearch('');
        setStatus('all');
        setType('');
        setSort('-created_at');
        setSearchParams(new URLSearchParams());
    };

    const runAction = async (notification: AppNotification, action: 'archive' | 'delete' | 'read' | 'restore') => {
        setPendingAction({ action, id: notification.id });

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
            }
        } catch (error) {
            notify({ description: getErrorMessage(error), intent: 'error', title: 'Notification action failed' });
        } finally {
            setPendingAction(null);
        }
    };

    const markAll = async () => {
        try {
            const response = await markAllAsRead.mutateAsync();
            notify({ description: `${response.data.updated} notifications updated.`, intent: 'success', title: 'Notifications marked as read' });
        } catch (error) {
            notify({ description: getErrorMessage(error), intent: 'error', title: 'Bulk action failed' });
        }
    };

    return (
        <div className="grid gap-6">
            <NotificationFilters
                onReset={resetFilters}
                onSearchChange={(value) => {
                    setSearch(value);
                    syncParams({ page: 1, search: value });
                }}
                onSortChange={(value) => {
                    setSort(value);
                    syncParams({ page: 1, sort: value });
                }}
                onStatusChange={(value) => {
                    setStatus(value);
                    syncParams({ page: 1, status: value });
                }}
                onTypeChange={(value) => {
                    setType(value);
                    syncParams({ page: 1, type: value });
                }}
                search={search}
                sort={sort}
                status={status}
                type={type}
            />

            <section className="grid gap-4" aria-label="Notification center results">
                <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <SectionHeader
                        description={meta ? `${meta.total} notifications ? ${meta.unread_count} unread ? page ${meta.current_page} of ${meta.last_page}` : 'Notifications from the backend API.'}
                        title="Notification center"
                    />
                    <div className="flex flex-wrap items-center gap-2">
                        <Button leftIcon={<RefreshCw aria-hidden="true" className="size-4" />} loading={notificationsQuery.isFetching} onClick={() => void notificationsQuery.refetch()} variant="outline">
                            Refresh
                        </Button>
                        <Button disabled={!meta?.unread_count} leftIcon={<CheckCheck aria-hidden="true" className="size-4" />} loading={markAllAsRead.isPending} onClick={() => void markAll()}>
                            Mark all read
                        </Button>
                    </div>
                </div>

                {notificationsQuery.isError && (
                    <Alert description={getErrorMessage(notificationsQuery.error)} icon={<AlertCircle aria-hidden="true" className="size-5" />} intent="danger" title="Unable to load notifications" />
                )}

                {notificationsQuery.isLoading ? (
                    <NotificationCenterSkeleton />
                ) : notifications.length === 0 ? (
                    <EmptyState
                        action={search || type || status !== 'all' ? { label: 'Reset filters', onClick: resetFilters } : undefined}
                        description="Notifications from workflow, reports, employees, system, AI, and administration events will appear here."
                        icon={<Bell aria-hidden="true" className="size-10" />}
                        title="No notifications found"
                    />
                ) : (
                    <div className="grid gap-6">
                        {groups.map((group) => (
                            <section className="grid gap-3" key={group.label} aria-label={group.label}>
                                <h2 className="text-sm font-semibold uppercase tracking-wide text-muted-foreground">{group.label}</h2>
                                <div className="grid gap-3">
                                    {group.notifications.map((notification) => (
                                        <NotificationCard
                                            isPending={pendingAction?.id === notification.id}
                                            key={notification.id}
                                            notification={notification}
                                            onArchive={(value) => void runAction(value, 'archive')}
                                            onDelete={(value) => void runAction(value, 'delete')}
                                            onMarkAsRead={(value) => void runAction(value, 'read')}
                                            onRestore={(value) => void runAction(value, 'restore')}
                                        />
                                    ))}
                                </div>
                            </section>
                        ))}
                    </div>
                )}

                {meta && meta.last_page > 1 && (
                    <Pagination
                        className="justify-center"
                        onPageChange={(nextPage) => {
                            syncParams({ page: nextPage });
                        }}
                        page={meta.current_page}
                        pageCount={meta.last_page}
                    />
                )}
            </section>
        </div>
    );
}
