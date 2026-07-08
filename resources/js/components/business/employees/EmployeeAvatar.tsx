import { Avatar } from '@/components/ui';

export type EmployeeAvatarProps = {
    avatarUrl?: string | null;
    email?: string | null;
    name: string;
    size?: 'lg' | 'md' | 'sm';
};

export function EmployeeAvatar({ avatarUrl, email, name, size = 'md' }: EmployeeAvatarProps) {
    return <Avatar alt={name} fallback={name || email || 'Employee'} size={size} src={avatarUrl ?? undefined} />;
}
