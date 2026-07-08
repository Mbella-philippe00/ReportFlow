import { useEffect } from 'react';

import { PageContainer } from '@/components/layout/PageContainer';
import { appConfig } from '@/config/app';

import { NotificationCenter } from '../components/NotificationCenter';

export function NotificationsPage() {
    useEffect(() => {
        document.title = `Notifications - ${appConfig.name}`;
    }, []);

    return (
        <PageContainer
            description="Review workflow, report, employee, system, AI, and administration notifications from the backend Notifications API."
            eyebrow="Notifications"
            title="Notifications"
        >
            <NotificationCenter />
        </PageContainer>
    );
}
