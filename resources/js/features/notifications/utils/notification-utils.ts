import { Bot, BriefcaseBusiness, FileText, GitPullRequest, Settings, ShieldCheck } from 'lucide-react';
import type { ComponentType, SVGProps } from 'react';

import type { SelectOption } from '@/components/ui';
import type { AppNotification, NotificationSortValue, NotificationStatusFilter, NotificationType } from '@/types';

export type NotificationGroup = {
    label: string;
    notifications: AppNotification[];
};

export type NotificationTypeMeta = {
    icon: ComponentType<SVGProps<SVGSVGElement>>;
    intent: 'danger' | 'neutral' | 'primary' | 'success' | 'warning';
    label: string;
};

const minute = 60 * 1000;
const hour = 60 * minute;
const day = 24 * hour;

export const notificationStatusOptions: readonly SelectOption[] = [
    { label: 'All active', value: 'all' },
    { label: 'Unread', value: 'unread' },
    { label: 'Read', value: 'read' },
    { label: 'Archived', value: 'archived' },
];

export const notificationTypeOptions: readonly SelectOption[] = [
    { label: 'All types', value: '' },
    { label: 'Workflow', value: 'workflow' },
    { label: 'Reports', value: 'reports' },
    { label: 'Employees', value: 'employees' },
    { label: 'System', value: 'system' },
    { label: 'AI', value: 'ai' },
    { label: 'Administration', value: 'administration' },
];

export const notificationSortOptions: readonly SelectOption[] = [
    { label: 'Newest first', value: '-created_at' },
    { label: 'Oldest first', value: 'created_at' },
    { label: 'Unread state', value: '-read_at' },
    { label: 'Type A-Z', value: 'type' },
];

export const notificationTypeMeta: Record<NotificationType, NotificationTypeMeta> = {
    administration: {
        icon: ShieldCheck,
        intent: 'warning',
        label: 'Administration',
    },
    ai: {
        icon: Bot,
        intent: 'primary',
        label: 'AI',
    },
    employees: {
        icon: BriefcaseBusiness,
        intent: 'success',
        label: 'Employees',
    },
    reports: {
        icon: FileText,
        intent: 'neutral',
        label: 'Reports',
    },
    system: {
        icon: Settings,
        intent: 'neutral',
        label: 'System',
    },
    workflow: {
        icon: GitPullRequest,
        intent: 'primary',
        label: 'Workflow',
    },
};

const startOfToday = () => {
    const value = new Date();
    value.setHours(0, 0, 0, 0);

    return value;
};

const startOfYesterday = () => {
    const value = startOfToday();
    value.setDate(value.getDate() - 1);

    return value;
};

const startOfWeek = () => {
    const value = startOfToday();
    const dayOfWeek = value.getDay();
    const daysSinceMonday = dayOfWeek === 0 ? 6 : dayOfWeek - 1;
    value.setDate(value.getDate() - daysSinceMonday);

    return value;
};

export const formatNotificationDate = (value: string | null) => {
    if (!value) {
        return 'Not available';
    }

    return new Intl.DateTimeFormat(undefined, {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(new Date(value));
};

export const formatRelativeNotificationTime = (value: string) => {
    const timestamp = new Date(value).getTime();
    const diff = Date.now() - timestamp;

    if (!Number.isFinite(timestamp)) {
        return 'Recently';
    }

    if (diff < minute) {
        return 'Just now';
    }

    if (diff < hour) {
        const minutes = Math.max(1, Math.floor(diff / minute));
        return `${minutes} min ago`;
    }

    if (diff < day) {
        const hours = Math.max(1, Math.floor(diff / hour));
        return `${hours} hr ago`;
    }

    if (diff < 7 * day) {
        const days = Math.max(1, Math.floor(diff / day));
        return `${days} day${days === 1 ? '' : 's'} ago`;
    }

    return new Intl.DateTimeFormat(undefined, { dateStyle: 'medium' }).format(new Date(value));
};

export const groupNotificationsByDate = (notifications: readonly AppNotification[]): NotificationGroup[] => {
    const today = startOfToday();
    const yesterday = startOfYesterday();
    const week = startOfWeek();
    const todayGroup: NotificationGroup = { label: 'Today', notifications: [] };
    const yesterdayGroup: NotificationGroup = { label: 'Yesterday', notifications: [] };
    const earlierThisWeekGroup: NotificationGroup = { label: 'Earlier This Week', notifications: [] };
    const earlierGroup: NotificationGroup = { label: 'Earlier', notifications: [] };

    notifications.forEach((notification) => {
        const createdAt = new Date(notification.created_at);

        if (createdAt >= today) {
            todayGroup.notifications.push(notification);
            return;
        }

        if (createdAt >= yesterday) {
            yesterdayGroup.notifications.push(notification);
            return;
        }

        if (createdAt >= week) {
            earlierThisWeekGroup.notifications.push(notification);
            return;
        }

        earlierGroup.notifications.push(notification);
    });

    return [todayGroup, yesterdayGroup, earlierThisWeekGroup, earlierGroup].filter((group) => group.notifications.length > 0);
};

export const normalizeNotificationStatus = (value: string): NotificationStatusFilter => {
    if (value === 'archived' || value === 'read' || value === 'unread') {
        return value;
    }

    return 'all';
};

export const normalizeNotificationSort = (value: string): NotificationSortValue => {
    if (value === 'created_at' || value === 'read_at' || value === 'type' || value === '-created_at' || value === '-read_at' || value === '-type') {
        return value;
    }

    return '-created_at';
};

export const normalizeNotificationType = (value: string): '' | NotificationType => {
    if (value === 'administration' || value === 'ai' || value === 'employees' || value === 'reports' || value === 'system' || value === 'workflow') {
        return value;
    }

    return '';
};
