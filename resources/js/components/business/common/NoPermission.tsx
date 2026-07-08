import { ShieldAlert } from 'lucide-react';
import type { ReactNode } from 'react';

import { EmptyState } from '@/components/ui';

export type NoPermissionProps = {
    action?: {
        label: string;
        onClick: () => void;
    };
    description?: ReactNode;
    title?: ReactNode;
};

export function NoPermission({ action, description = 'You do not have permission to access this area.', title = 'Access restricted' }: NoPermissionProps) {
    return <EmptyState action={action} description={description} icon={<ShieldAlert aria-hidden="true" className="size-10" />} title={title} />;
}
