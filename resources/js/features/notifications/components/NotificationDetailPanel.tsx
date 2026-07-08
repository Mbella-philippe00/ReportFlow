import { Archive, CheckCircle2, Clock, ExternalLink, RotateCcw } from 'lucide-react';
import { useNavigate } from 'react-router-dom';

import { Badge, Button, Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';
import type { AppNotification } from '@/types';

import { formatNotificationDate, notificationTypeMeta } from '../utils/notification-utils';
import { NotificationActions } from './NotificationActions';
import { NotificationTypeBadge } from './NotificationTypeBadge';

export type NotificationDetailPanelProps = {
    isPending?: boolean;
    notification: AppNotification;
    onArchive: (notification: AppNotification) => void;
    onDelete: (notification: AppNotification) => void;
    onMarkAsRead: (notification: AppNotification) => void;
    onRestore: (notification: AppNotification) => void;
};

export function NotificationDetailPanel({ isPending = false, notification, onArchive, onDelete, onMarkAsRead, onRestore }: NotificationDetailPanelProps) {
    const navigate = useNavigate();
    const meta = notificationTypeMeta[notification.type];
    const Icon = meta.icon;

    return (
        <div className="grid gap-6">
            <Card>
                <CardHeader>
                    <div className="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div className="flex items-start gap-3">
                            <span className="rounded-2xl bg-muted p-3 text-muted-foreground">
                                <Icon aria-hidden="true" className="size-6" />
                            </span>
                            <div className="min-w-0">
                                <div className="flex flex-wrap items-center gap-2">
                                    <NotificationTypeBadge type={notification.type} />
                                    {notification.is_unread && <Badge intent="primary">Unread</Badge>}
                                    {notification.is_archived && <Badge intent="warning">Archived</Badge>}
                                </div>
                                <CardTitle className="mt-3">{notification.title}</CardTitle>
                                <CardDescription>{notification.message}</CardDescription>
                            </div>
                        </div>
                        <NotificationActions
                            isPending={isPending}
                            notification={notification}
                            onArchive={onArchive}
                            onDelete={onDelete}
                            onMarkAsRead={onMarkAsRead}
                            onRestore={onRestore}
                        />
                    </div>
                </CardHeader>
                {notification.action_url && (
                    <CardContent>
                        <Button onClick={() => navigate(notification.action_url ?? '/notifications')} rightIcon={<ExternalLink aria-hidden="true" className="size-4" />} variant="outline">
                            Open related item
                        </Button>
                    </CardContent>
                )}
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>Notification timeline</CardTitle>
                    <CardDescription>Delivery, read, and archive timestamps returned by the Notifications API.</CardDescription>
                </CardHeader>
                <CardContent>
                    <dl className="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        <div className="rounded-xl bg-muted/60 p-3">
                            <dt className="flex items-center gap-2 text-xs font-medium uppercase tracking-wide text-muted-foreground"><Clock aria-hidden="true" className="size-4" /> Created</dt>
                            <dd className="mt-1 text-sm font-medium text-foreground">{formatNotificationDate(notification.created_at)}</dd>
                        </div>
                        <div className="rounded-xl bg-muted/60 p-3">
                            <dt className="flex items-center gap-2 text-xs font-medium uppercase tracking-wide text-muted-foreground"><CheckCircle2 aria-hidden="true" className="size-4" /> Read</dt>
                            <dd className="mt-1 text-sm font-medium text-foreground">{formatNotificationDate(notification.read_at)}</dd>
                        </div>
                        <div className="rounded-xl bg-muted/60 p-3">
                            <dt className="flex items-center gap-2 text-xs font-medium uppercase tracking-wide text-muted-foreground"><Archive aria-hidden="true" className="size-4" /> Archived</dt>
                            <dd className="mt-1 text-sm font-medium text-foreground">{formatNotificationDate(notification.archived_at)}</dd>
                        </div>
                        <div className="rounded-xl bg-muted/60 p-3">
                            <dt className="flex items-center gap-2 text-xs font-medium uppercase tracking-wide text-muted-foreground"><RotateCcw aria-hidden="true" className="size-4" /> Updated</dt>
                            <dd className="mt-1 text-sm font-medium text-foreground">{formatNotificationDate(notification.updated_at)}</dd>
                        </div>
                    </dl>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>Related records</CardTitle>
                    <CardDescription>Normalized references exposed by the backend notification resource.</CardDescription>
                </CardHeader>
                <CardContent>
                    <dl className="grid gap-3 sm:grid-cols-3">
                        <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">Report ID</dt><dd className="mt-1 font-medium text-foreground">{notification.related.report_id ?? 'None'}</dd></div>
                        <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">Employee ID</dt><dd className="mt-1 font-medium text-foreground">{notification.related.employee_id ?? 'None'}</dd></div>
                        <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">User ID</dt><dd className="mt-1 font-medium text-foreground">{notification.related.user_id ?? 'None'}</dd></div>
                    </dl>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>Raw notification data</CardTitle>
                    <CardDescription>Structured payload stored by Laravel database notifications.</CardDescription>
                </CardHeader>
                <CardContent>
                    <pre className="max-h-96 overflow-auto rounded-xl bg-muted p-4 text-xs leading-relaxed text-muted-foreground">
                        {JSON.stringify(notification.data, null, 2)}
                    </pre>
                </CardContent>
            </Card>
        </div>
    );
}
