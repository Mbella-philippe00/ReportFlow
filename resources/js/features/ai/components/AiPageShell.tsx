import type { PropsWithChildren, ReactNode } from 'react';

import { PageContainer } from '@/components/layout/PageContainer';

import { AiNav } from './AiNav';

export type AiPageShellProps = PropsWithChildren<{
    actions?: ReactNode;
    description: string;
    title: string;
}>;

export function AiPageShell({ actions, children, description, title }: AiPageShellProps) {
    return (
        <PageContainer actions={actions} description={description} eyebrow="AI Assistant" title={title}>
            <AiNav />
            {children}
        </PageContainer>
    );
}
