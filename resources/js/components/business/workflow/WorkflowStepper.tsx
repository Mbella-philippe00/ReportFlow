import { Check, Circle, X } from 'lucide-react';

import { ApprovalStatusBadge } from '@/components/business/workflow/ApprovalStatusBadge';
import type { ApprovalStatus } from '@/components/business/workflow/ApprovalStatusBadge';
import { cn } from '@/utils/cn';

export type WorkflowStep = {
    description?: string;
    id: string;
    label: string;
    status: ApprovalStatus;
};

export type WorkflowStepperProps = {
    currentStepId?: string;
    onStepSelect?: (step: WorkflowStep) => void;
    steps: readonly WorkflowStep[];
};

const statusIcon = {
    approved: Check,
    current: Circle,
    pending: Circle,
    rejected: X,
    skipped: Circle,
} as const;

export function WorkflowStepper({ currentStepId, onStepSelect, steps }: WorkflowStepperProps) {
    return (
        <nav aria-label="Workflow progress">
            <ol className="grid gap-3 md:grid-cols-[repeat(auto-fit,minmax(12rem,1fr))]">
                {steps.map((step, index) => {
                    const Icon = statusIcon[step.status];
                    const isCurrent = step.id === currentStepId || step.status === 'current';
                    const content = (
                        <>
                            <span className={cn('flex size-9 shrink-0 items-center justify-center rounded-full border bg-surface', isCurrent && 'border-primary text-primary')}>
                                <Icon aria-hidden="true" className="size-4" />
                            </span>
                            <span className="min-w-0 flex-1 text-left">
                                <span className="block text-sm font-medium text-foreground">{step.label}</span>
                                {step.description && <span className="mt-1 block text-xs text-muted-foreground">{step.description}</span>}
                            </span>
                            <ApprovalStatusBadge status={step.status} />
                        </>
                    );

                    return (
                        <li aria-current={isCurrent ? 'step' : undefined} className="relative" key={step.id}>
                            {index > 0 && <span aria-hidden="true" className="absolute -left-3 top-1/2 hidden h-px w-3 bg-border md:block" />}
                            {onStepSelect ? (
                                <button
                                    className="flex w-full items-center gap-3 rounded-2xl border bg-surface p-3 text-left transition hover:bg-muted/60 focus:outline-none focus:ring-2 focus:ring-primary"
                                    onClick={() => onStepSelect(step)}
                                    type="button"
                                >
                                    {content}
                                </button>
                            ) : (
                                <div className="flex items-center gap-3 rounded-2xl border bg-surface p-3">{content}</div>
                            )}
                        </li>
                    );
                })}
            </ol>
        </nav>
    );
}
