import type { ReactNode } from 'react';

import { Badge, Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui';
import { EmployeeAvatar } from '@/components/business/employees/EmployeeAvatar';

export type EmployeeCardProps = {
    actions?: ReactNode;
    avatarUrl?: string | null;
    department?: ReactNode;
    email?: string | null;
    name: string;
    role?: ReactNode;
    status?: 'active' | 'inactive';
};

export function EmployeeCard({ actions, avatarUrl, department, email, name, role, status }: EmployeeCardProps) {
    return (
        <Card>
            <CardHeader className="items-center text-center">
                <EmployeeAvatar avatarUrl={avatarUrl} email={email} name={name} size="lg" />
                <div>
                    <CardTitle>{name}</CardTitle>
                    {email && <p className="mt-1 text-sm text-muted-foreground">{email}</p>}
                </div>
            </CardHeader>
            <CardContent className="grid gap-2 text-center text-sm text-muted-foreground">
                {department && <p>{department}</p>}
                {role && <p>{role}</p>}
                {status && <Badge intent={status === 'active' ? 'success' : 'neutral'}>{status === 'active' ? 'Active' : 'Inactive'}</Badge>}
            </CardContent>
            {actions && <CardFooter className="justify-center">{actions}</CardFooter>}
        </Card>
    );
}
