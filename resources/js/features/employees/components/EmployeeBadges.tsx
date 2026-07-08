import { Badge } from '@/components/ui';
import type { RoleName } from '@/types';

export function DepartmentBadge({ department }: { department?: string | null }) {
    return <Badge intent={department ? 'primary' : 'neutral'}>{department || 'No department'}</Badge>;
}

const roleLabels: Record<RoleName, string> = {
    employee: 'Employee',
    manager: 'Manager',
    'super-admin': 'Super admin',
};

const roleIntent: Record<RoleName, 'neutral' | 'primary' | 'success' | 'warning'> = {
    employee: 'neutral',
    manager: 'success',
    'super-admin': 'warning',
};

export function RoleBadge({ role }: { role?: RoleName | null }) {
    if (!role) {
        return <Badge intent="neutral">No role</Badge>;
    }

    return <Badge intent={roleIntent[role]}>{roleLabels[role]}</Badge>;
}