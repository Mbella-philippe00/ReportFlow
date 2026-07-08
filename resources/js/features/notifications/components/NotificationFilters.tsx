import { DataToolbar, FilterBar, SearchBar } from '@/components/business/common';
import { Button } from '@/components/ui';
import type { NotificationSortValue, NotificationStatusFilter, NotificationType } from '@/types';

import { notificationSortOptions, notificationStatusOptions, notificationTypeOptions } from '../utils/notification-utils';

export type NotificationFiltersProps = {
    onReset: () => void;
    onSearchChange: (value: string) => void;
    onSortChange: (value: NotificationSortValue) => void;
    onStatusChange: (value: NotificationStatusFilter) => void;
    onTypeChange: (value: '' | NotificationType) => void;
    search: string;
    sort: NotificationSortValue;
    status: NotificationStatusFilter;
    type: '' | NotificationType;
};

export function NotificationFilters({ onReset, onSearchChange, onSortChange, onStatusChange, onTypeChange, search, sort, status, type }: NotificationFiltersProps) {
    return (
        <DataToolbar
            actions={
                <Button onClick={onReset} variant="outline">
                    Reset
                </Button>
            }
            filters={
                <FilterBar
                    filters={[
                        {
                            id: 'notification-status',
                            label: 'Status',
                            onChange: (value) => onStatusChange(value as NotificationStatusFilter),
                            options: notificationStatusOptions,
                            value: status,
                        },
                        {
                            id: 'notification-type',
                            label: 'Type',
                            onChange: (value) => onTypeChange(value as '' | NotificationType),
                            options: notificationTypeOptions,
                            value: type,
                        },
                        {
                            id: 'notification-sort',
                            label: 'Sort',
                            onChange: (value) => onSortChange(value as NotificationSortValue),
                            options: notificationSortOptions,
                            value: sort,
                        },
                    ]}
                />
            }
            search={<SearchBar id="notification-search" onChange={onSearchChange} placeholder="Search notifications?" value={search} />}
        />
    );
}
