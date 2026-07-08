import type { ReactNode } from 'react';

import { ApprovalStatusBadge } from '@/components/business/workflow/ApprovalStatusBadge';
import type { ApprovalStatus } from '@/components/business/workflow/ApprovalStatusBadge';

export type ApprovalTimelineItem = {
    actor?: ReactNode;
    description?: ReactNode;
    id: string;
    status: ApprovalStatus;
    timestamp?: ReactNode;
    title: ReactNode;
};

export type ApprovalTimelineProps = {
    items: readonly ApprovalTimelineItem[];
};

export function ApprovalTimeline({ items }: ApprovalTimelineProps) {
    return (
        <ol className="relative grid gap-4 border-l pl-5" aria-label="Approval timeline">
            {items.map((item) => (
                <li className="relative" key={item.id}>
                    <span aria-hidden="true" className="absolute -left-[1.65rem] top-1.5 size-3 rounded-full border-2 border-surface bg-primary" />
                    <div className="rounded-2xl border bg-surface p-4">
                        <div className="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h3 className="text-sm font-semibold text-foreground">{item.title}</h3>
                                {(item.actor || item.timestamp) && (
                                    <p className="mt-1 text-xs text-muted-foreground">
                                        {item.actor}
                                        {item.actor && item.timestamp ? ' · ' : null}
                                        {item.timestamp}
                                    </p>
                                )}
                            </div>
                            <ApprovalStatusBadge status={item.status} />
                        </div>
                        {item.description && <div className="mt-3 text-sm leading-relaxed text-muted-foreground">{item.description}</div>}
                    </div>
                </li>
            ))}
        </ol>
    );
}
