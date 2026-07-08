import { Sparkles } from 'lucide-react';
import type { ReactNode } from 'react';

import { EmptyState } from '@/components/ui';

export type ComingSoonProps = {
    description?: ReactNode;
    title?: ReactNode;
};

export function ComingSoon({ description = 'This capability is planned for a later implementation phase.', title = 'Coming soon' }: ComingSoonProps) {
    return <EmptyState description={description} icon={<Sparkles aria-hidden="true" className="size-10" />} title={title} />;
}
